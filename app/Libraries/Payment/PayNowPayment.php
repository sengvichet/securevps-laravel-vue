<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/7/2018
 * Time: 4:44 PM
 */

namespace App\Libraries\Payment;

use App\Http\Soap\WSSoapShev;
use Illuminate\Http\Request;

class PayNowPayment extends Payment
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
            ->setSaleOrder()
            ->createInvoiceAndPaymentBaseOnSalesOrder($this->lastDocEntry)
            ->validateAvaliableDomain()
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
     * [addSales description]
     * @param string $value [description]
     */
    protected function setSaleOrder()
    {
        $action = 'AddSalesOrderOnNewDomainOnly';

        $ostype = getOsType(session('payfor_itemId'));

        $saleParams = [
            'ORDER_TYPE' => 'PAYNOW',
            'U_ICR_DOMAIN_NAME' => session('payfor_domain'),
            'BP_CODE' => session('BPCode'),
            'ORDER_DOCENTRY' => '',
            'PromotionCode' => '',
            'OSType' => $ostype,
            'IP' => session('payfor_iphost'),
            'ControlPanelName' => 'DIRECTADMIN',
        ];

        $itemAddonsParams = [];

        array_push($itemAddonsParams, [
            'ItemCode' => session('payfor_itemId'),
            'Quantity' => 1,
        ]);

        array_push($itemAddonsParams, [
            'ItemCode' => session('payfor_refund_itemId'),
            'Quantity' => -1,
        ]);


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

}

