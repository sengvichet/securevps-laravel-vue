<?php

namespace App\Libraries\Payment;

use App\Http\Soap\WSSoapShev;
use Illuminate\Http\Request;


class UpgradePayment extends Payment
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

    public function handle()
    {
        $this->parsePelecardResults()
             //->validateSameDomain()
             ->setSaleOrder()
             ->createInvoiceAndPaymentBaseOnSalesOrder($this->lastDocEntry)
             ->deleteSessionData();
    }

    protected function setSaleOrder()
    {
        $action = 'UpdateSalesOrderOnExistingDomain';

        if (strpos(session('payfor_itemId'), 'L') !== false) {
            $ostype = 'Linux';
        }

        if (strpos(session('payfor_itemId'), 'W') !== false) {
            $ostype = 'Windows';
        }

        $saleParams = [
            'ORDER_TYPE' => 'UPDATE',
            'U_ICR_DOMAIN_NAME' => session('payfor_domain'),
            'BP_CODE' => session('BPCode'),
            'ORDER_DOCENTRY' => session('payfor_orderId'),
            'PromotionCode' => '',
            'ConfigType' => '9',
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

        $itemAddons = json_decode(session('payfor_items'), true);
        foreach($itemAddons as $code => $qty) {
            if($qty > 0) {
                array_push($itemAddonsParams, [
                    'ItemCode' => $code,
                    'Quantity' => $qty,
                ]);
            }
        }

        $refundItemAddons = json_decode(session('payfor_refund_items'), true);
        foreach($refundItemAddons as $code => $qty) {
            array_push($itemAddonsParams, [
                'ItemCode' => $code,
                'Quantity' => $qty,
            ]);
        }

        $res = xmlToArray($this->sapord->setSaleOrder($action, $saleParams, $itemAddonsParams));

        $result = array_get($res, 'Body.UpdateSalesOrderOnExistingDomainResponse.UpdateSalesOrderOnExistingDomainResult.string', []);

        logg('AddSalesOrderOnNewDomainOnlyResponse: ', $result);

        $this->lastDocEntry = $result[0];

        return $this;
    }
}
