<?php

namespace App\Libraries\Payment;

use Illuminate\Http\Request;

abstract class Payment
{
    public $parsePelecard;
    /**
     * [perform description]
     * @return [type] [description]
     */
    public static function perform(Request $request)
    {
        return (new static($request))->handle();
    }

    /**
     * [handle description]
     * @return [type] [description]
     */
    abstract public function handle();

    /**
     * [addSales description]
     */
    abstract protected function setSaleOrder();

    /**
     * [deleteSessionData description]
     * @return [type] [description]
     */
    protected function deleteSessionData()
    {
        session()->forget([
            'payfor_type',
            'payfor_cartId',
            'payfor_itemId',
            'payfor_total',
            'payfor_domain',
            'payfor_orderId',
            'payfor_iphost',
        ]);

        return $this;
    }

    /**
     * [validateSameDomain description]
     * @return [type] [description]
     */
    protected function validateSameDomain()
    {
        if (substr($this->request->parmx, 0, -5) === session('payfor_domain')) {
            return $this;
        } else {
            throw new \Exception('Domain name that get from Pelecard not meat the session domain.');
        }
    }

    /**
     * [parsePelecardResults description]
     * @return [type] [description]
     */
    protected function parsePelecardResults()
    {
        /*
        "result" => "0000***************202521000412193300000001        000000006011 150  0000000000000000000000000036001003„†‰… ƒ˜€— ‰Ž…€Œ0ertertwer.hrghg-183  "
        "token" => "6091648828"
        "authNum" => "0000000"
        "parmx" => "ertertwer.hrghg-1832"
        "id" => "038568697"
        "CreditCardHolder" => ""
        "InvoiceLink" => ""
        */

        $responseFromPelecard = [
            'result' => $this->request->result,
            'token' => $this->request->token,
            'authNum' => $this->request->authNum,
            'parmx' => $this->request->parmx,
            'id' => $this->request->id,
            'CreditCardHolder' => $this->request->CreditCardHolder,
            'InvoiceLink' => $this->request->InvoiceLink,
        ];

        logg('responseFromPelecard: ', $responseFromPelecard);

        $pcrdresult = $this->request->result;
        $numPayments = (int) substr($pcrdresult, 93, 2);
        $payed = self::cleanPayment(substr($pcrdresult, 36, 8));
        $expiration = substr($pcrdresult, 29, 4);
        $domain = substr($this->request->parmx, 0, -5);

        $this->parsePelecard = [
            'expiration' => $expiration,
            'creditCompanyCode' => substr($pcrdresult, 59, 1),
            'expirationLabel' => substr($expiration,0,2) . "/20" . substr($expiration, 2, 2),
            'expLabelShort' => substr($expiration, 0, 2) . "/" . substr($expiration, 2, 2),
            'token' => $this->request->token,
            'payed' => $payed,
            'numPayments' => $numPayments < 7 ? $numPayments + 1 : $numPayments,
            'payedNumber' => str_replace(',', '', $payed),
            'payedFor' => $this->request->parmx,
            'domain' => $domain,
            'authnum' => $this->request->authNum,
            'cardHolder' => $this->request->CreditCardHolder ? $this->request->CreditCardHolder : 'לא מופיע',
            'base_url' => urldecode($this->request->base_url),
            'creditCardName' => self::getCreditCompany($pcrdresult),
            'paymentTypeCode' => self::getCreditPaymentType($pcrdresult),
            'creditnumLast4dig' => substr($pcrdresult, 19, 4),
        ];

        session([
            'payed' => true,
            'parse_pelecard' => $this->parsePelecard,
            'payfor_itemId_for_log' => session('payfor_itemId'),
            'raw_response_pelecard' => $this->request->all(),
            'payedFor' => $this->request->parmx,
        ]);

        logg('parsePelecard: ', $this->parsePelecard);

        return $this;
    }

    /**
     * [cleanPayment description]
     * @param  [type] $payed [description]
     * @return [type]        [description]
     */
    private static function cleanPayment($payed)
    {
        //  $payed = 000117700";
        // ==>>>  1,176
        $len = strlen ($payed);
        $payed = substr ($payed, 0, $len-1);

        // clean the heading 000..
        if(isset($payed['0']) && !empty($payed['0'])) {
            while ($payed['0'] == '0' ) {
                if (strlen ($payed) >= 2){
                    $payed = substr ($payed, 1 );
                }
            }
        }

        //
        return ((int) $payed) / 100;
    }

    /**
     * [getCreditCompany description]
     * @param  [type] $clearing_result [description]
     * @return [type]                  [description]
     */
    private static function getCreditCompany($clearing_result)
    {
        $code = substr ($clearing_result, 59, 1);
        //
        $card_name = Array (
                "0" => "כרטיס דמו",
                "1" => "ישראכארד",
                "2" => "ויזה כ.א.ל",
                "3" => "דיינרס",
                "4" => "אמריקן אקספרס",
                "5" => "JCB",
                "6" => "לאומיכארד"
              );

        return $card_name[$code];
    }

    /**
     * [getCreditPaymentType description]
     * @param  [type] $clearing_result [description]
     * @return [type]                  [description]
     */
    private static function getCreditPaymentType($clearing_result)
    {
        $code = substr($clearing_result, 59, 1);
        //paymentType       = 4 - Israe , 5 - visa , 7 dinars , 8 American
        // based Tal explanations for Mapping 28-10-2013
        $card_name = [
                "0" => 4,
                "1" => 4,
                "2" => 5,
                "3" => 7,
                "4" => 8,
                "5" => 4,
                "6" => 5
            ];

        return $card_name[$code];
    }

    /**
     * [getCurrentDateFormat description]
     * @return [type] [description]
     */
    protected static function getCurrentDateFormat()
    {
        $time = time();

        $sign = "+";
        $offset = date("Z", $time);
        if ($offset < 0) {
            $sign = "-";
            $offset = -$offset;
        }

        $hours = floor($offset/3600);
        $min = floor(($offset - $hours * 3600)/60);

        if ($hours < 10)
            $hours = "0" . $hours;

        if ($min < 10)
            $min = "0" . $min;

        return gmdate("Y-m-d\TH:i:s", $time) . $sign . $hours . ":" . $min;
    }


    /**
     * [createInvoiceAndPaymentBaseOnSalesOrder description]
     * @return [type] [description]
     */
    public function createInvoiceAndPaymentBaseOnSalesOrder($SaleOrderReferenceNo)
    {
        $recurringModeOptions = [
            '00' => 'none',
            '01' => 'month',
            '03' => 'querter',
            '12' => 'annual',
        ];

        $period = substr(session('payfor_itemId'), 0, 2);

        if(isset($recurringModeOptions[$period])) {
            $modeOptions = $recurringModeOptions[$period];
        } else {
            $modeOptions = '';
        }

        $saveToken = 'true';
        if(!empty(session('saveToken'))) {
            $saveToken = session('saveToken');
        }

        $params = [
            'CreditCompanyCode' => $this->parsePelecard['creditCompanyCode'],
            'CreditCardNumber' => $this->parsePelecard['creditnumLast4dig'],
            'Currency' => 'NIS',
            'Amount' => $this->parsePelecard['payed'],
            'Payment_Time' => date("Y-m-d H:i:s"), # now in sql format 'YYYY-MM-DDTHH:mm:ss+02:00'
            'Gateway' => 'PELECARD',
            'Credit_exp' => $this->parsePelecard['expirationLabel'],
            'Approval_Reference' => $this->parsePelecard['authnum'],
            'PaymentMethod' => '1',
            'VoucherNumber' => '99999999',
            'PaymentType' => $this->parsePelecard['paymentTypeCode'],
            'PaidFor' => $this->parsePelecard['payedFor'],
            'RecurringToken' => $this->parsePelecard['token'],
            'RecurringMode' => $modeOptions, // # "none", "month" , "querter" , "annual"
            'keepCCForFuture' => $saveToken,
        ];

        logg('createInvoiceAndPaymentBaseOnSalesOrder params: ', $params);

        $sap = new \App\Http\Soap\WSSoapShev('invoice');
        $res = xmlToArray($sap->createInvoiceAndPaymentBaseOnSalesOrder($params, $SaleOrderReferenceNo));

        logg('createInvoiceAndPaymentBaseOnSalesOrderRESULTS params: ', $res);

        return $this;
    }
}
