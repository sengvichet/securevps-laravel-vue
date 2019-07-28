<?php

namespace App\Libraries\Payment;

use App\Http\Soap\WSSoapShev;
use App\Models\Cart;
use Illuminate\Http\Request;

/**
 *
 */
class CartPayment extends Payment
{
    protected $request;
    private $sappv;
    private $sapord;
    private $sapinv;
    private $lastDocEntry;

    public function __construct(Request $request)
    {
        $this->sappv = new WSSoapShev('pageview');
        $this->sapord = new WSSoapShev('order');
        $this->sapinv = new WSSoapShev('inventory');
        $this->request = $request;
    }

    /**
     * [handle description]
     * @return [type] [description]
     */
    public function handle()
    {
        $this->parsePelecardResults()
             ->validateSameDomain()
             ->validateAvaliableDomain()
             ->addDomain()
             ->setSaleOrder()
             ->createInvoiceAndPaymentBaseOnSalesOrder($this->lastDocEntry)
             ->deleteCartData()
             ->deleteSessionData();
    }

    /**
     * [validateAvaliableDomain description]
     * @return [type] [description]
     */
    private function validateAvaliableDomain()
    {
        $domainStatus = xmlToArray($this->sapord->callTo('CheckDomainStatus', ['domainName' => session('payfor_domain')]));
        $domainStatus = array_get($domainStatus, 'Body.CheckDomainStatusResponse.CheckDomainStatusResult', []);

        if (strpos($domainStatus, '<Exsist>true</Exsist>') === false) {
            return $this;
        } else {
            return $this->domainNotAvaliableAction();
        }
    }

    /**
     * [FunctionName description]
     * @param string $value [description]
     */
    private function domainNotAvaliableAction()
    {
        $xmlstring = $this->sappv->callTo('GetActiveDomainSpacesFor_A_BPCode', ['BPCode' => session('BPCode')]);
        $dataXml = xmlToArray($xmlstring);
        $domains = array_get($dataXml, 'Body.GetActiveDomainSpacesFor_A_BPCodeResponse.GetActiveDomainSpacesFor_A_BPCodeResult.NewDataSet.Table', []);
        $domainsList = array_column($domains, 'U_DOMAIN_NAME');
        $domainActive = array_column($domains, 'U_Active', 'U_DOMAIN_NAME');

        if(! in_array(session('payfor_domain'), $domainsList)) {
            return ['error' => 'domain not avaliable', 'msg' => 'This domain busy by other user please select other domain 1'];
        } else {
            if ($domainActive[session('payfor_domain')] !== 'Y') {
                return ['error' => 'domain not avaliable', 'msg' => 'This domain busy by other user please select other domain 2'];
            }
        }

        return $this;
    }

    /**
     * [AddDomain description]
     */
    private function addDomain()
    {
        $addDomainParams = [
            'DOMAIN_NAME' => session('payfor_domain'),
            'CP_USER_Name' => session('username'),
            'CP_Password' => session('password'),
            'Referrer' => '',
            'RefName' => '',
            'RefToBePaid' => 'Y',
            'Active' =>	'Y',
            'Mail' => 'N',
            'Advance' => 'N',
            'Newslet' => 'Y',
            'PromoPart' => 'Y',
            'Promo3rd' => 'Y',
            'DemoDomain' => 'N',
            'BP_CODE' => session('BPCode'),
            'BP_NAME' => session('firstName') . ' ' . session('lastName'),
            'CREATION_DATE' => self::getCurrentDateFormat(),
            'PayTerm' => '5',
            'PARENTDOMAIN' => '',
            'FLAG_CHILDDOMAIN' => '',
            'IS_IDN' =>	'',
            'IDN' => '',
        ];

        $res = xmlToArray($this->sapord->addDomain($addDomainParams));

        return $this;
    }

    /**
     * [addSales description]
     * @param string $value [description]
     */
    protected function setSaleOrder()
    {
        $cart = Cart::with('items', 'itemAddons')
                    ->find(session('payfor_cartId'));

        $ipHost = xmlToArray($this->sapinv->callTo('GetAllIPsForNewDomains', []));
        $ipHost = array_get($ipHost, 'Body.GetAllIPsForNewDomainsResponse.GetAllIPsForNewDomainsResult.NewDataSet.Table', []);

        $ipHostSelected = [];
        foreach ($ipHost as $key => $value) {
            if ($value['U_NICKNAME'] === $cart->ip_host) {
                $ipHostSelected = $value;
            }
        }

        $action = 'AddSalesOrderOnNewDomainOnly';

        $saleParams = [
            'ORDER_TYPE' => 'ADD',
            'U_ICR_DOMAIN_NAME' => session('payfor_domain'),
            'BP_CODE' => session('BPCode'),
            'ORDER_DOCENTRY' => '',
            'PromotionCode' => '',
            'ConfigType' => $ipHostSelected['U_ConfigType'],
            'OSType' => $ipHostSelected['U_OSTYPE'],
            'IP' => $ipHostSelected['U_IPADDRESS'],
            'ControlPanelName' => 'DIRECTADMIN',
        ];

        $itemAddonsParams = [];

        array_push($itemAddonsParams, [
            'ItemCode' => session('payfor_itemId'),
            'Quantity' => 1,
        ]);

        foreach($cart->itemAddons as $addon) {
            array_push($itemAddonsParams, [
                'ItemCode' => $addon['id'],
                'Quantity' => $addon['pivot']['value'],
            ]);
        }

        $res = xmlToArray($this->sapord->setSaleOrder($action, $saleParams, $itemAddonsParams));

        // if Success we get
        // -----------------
        // array:1 [▼
        //   "Body" => array:1 [▼
        //     "AddSalesOrderOnNewDomainOnlyResponse" => array:1 [▼
        //       "AddSalesOrderOnNewDomainOnlyResult" => array:1 [▼
        //         "string" => array:3 [▼
        //           0 => "0"
        //           1 => "Success"
        //           2 => "add of  Sales order"
        //         ]
        //       ]
        //     ]
        //   ]
        // ]
        $result = array_get($res, 'Body.AddSalesOrderOnNewDomainOnlyResponse.AddSalesOrderOnNewDomainOnlyResult.string', []);

        logg('AddSalesOrderOnNewDomainOnlyResponse: ', $result);

        $this->lastDocEntry = $result[0];

        return $this;
    }

    /**
     * [deleteCartData description]
     * @return [type] [description]
     */
    public function deleteCartData()
    {
        if ( ! Cart::deleteWithAddons(session('payfor_cartId'))) {
            // log delete error
        }

        return $this;
    }
}
