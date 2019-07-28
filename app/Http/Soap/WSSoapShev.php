<?php

namespace App\Http\Soap;

class WSSoapShev
{
    private $endpoint;
    private $client;
    const EPBSURL = 'http://212.150.41.90/TestForSite/';

    public function __construct($ws)
    {
        $this->endpoint = [
            'reg' => self::EPBSURL . 'SapBusinessOne_WebService_Registration.asmx?WSDL',
            'login' => self::EPBSURL . 'SapBusinessOne_WebService_Login.asmx?WSDL',
            'bp' => self::EPBSURL . 'SapBusinessOne_WebService_BP.asmx?WSDL',
            'pageview' => self::EPBSURL . 'SapBusinessOne_WebService_MainPageView.asmx?WSDL',
            'inventory' => self::EPBSURL . 'SapBusinessOne_WebService_Inventory.asmx?WSDL',
            'order' => self::EPBSURL . 'SapBusinessOne_WebService_SalesOrder.asmx?WSDL',
            'admin' => self::EPBSURL . 'SapBusinessOne_WebService_Admin.asmx?WSDL',
            'invoice' => self::EPBSURL . 'SapBusinessOne_WebService_InvoiceAndReceipt.asmx?WSDL',
            'general' => self::EPBSURL . 'SapBusinessOne_WebService.asmx?WSDL',
            'setcookie' => self::EPBSURL . 'SapBusinessOne_WebService_BP.asmx?WSDL',
            'getcookie' => self::EPBSURL . 'SapBusinessOne_WebService_BP.asmx?WSDL',
        ];

        $this->client = new \SoapClient(
            $this->endpoint[$ws],
            ['trace' => true, 'exception' => 0,'soap_version' => 2]
        );
    }

    /**
     * [_prepareSapXml description]
     * @param  [type] $params   [description]
     * @param  [type] $wrapper  [description]
     * @param  [type] $wrapper2 [description]
     * @param  [type] $wrapper3 [description]
     * @return [type]           [description]
     */
    private function _prepareSapXml($params, $wrapper, $wrapper2, $wrapper3)
    {
        $xml='';

        foreach ($params as $key => $value) {
            if (! is_array($key) && ! is_array($value))
                $xml .= "<$key>$value</$key>";
        }

        if ($wrapper3) {
            return "<$wrapper3><$wrapper2><$wrapper>$xml</$wrapper></$wrapper2></$wrapper3>";
        } elseif ($wrapper2) {
            return "<$wrapper2><$wrapper>$xml</$wrapper></$wrapper2>";
        } else {
            return "<$wrapper>$xml</$wrapper>";
        }
    }

    /**
     * [callTo description]
     * @param  [type] $fnn      [description]
     * @param  [type] $params   [description]
     * @param  [type] $wrapper  [description]
     * @param  [type] $wrapper2 [description]
     * @param  [type] $wrapper3 [description]
     * @return [type]           [description]
     */
    public function callTo($fnn, $params = [], $wrapper = null, $wrapper2 = null, $wrapper3 = null)
    {
        $paramsArr = $params;

        (! $wrapper) ? $wrapper = $fnn : null;
        $params = $this->_prepareSapXml($params,$wrapper, $wrapper2, $wrapper3);
        $params = new \SoapVar($params, XSD_ANYXML);

        $this->client->$fnn($params);

        // dd($this->client);
        // loggxml('xml function name and params', $fnn, $paramsArr);
        // loggxml('__last_request', $this->client->__last_request);
        // loggxml('__last_response', $this->client->__last_response);

        if ($fnn === 'GetBPDetails') {
            return self::parseBPDetails($this->client->__last_response);
        }

        return $this->client->__last_response;
    }

    /**
     * [setBP description]
     * @param [type]  $params   [description]
     * @param [type]  $userCode [description]
     * @param boolean $debug    [description]
     */
    public function setBP($params, $userCode, $debug = false)
    {
        $paramsArr = $params;

        $xml = '';
        foreach ($params as $key => $value) {
            $xml .= "<Field name=\"$key\">$value</Field>";
        }

        $params = "<SetBPDetails><XmlDoc><NewCustomer>$xml</NewCustomer></XmlDoc></SetBPDetails>";

        $params = new \SoapVar($params, XSD_ANYXML);

        $this->client->SetBPDetails($params);

        return $this->client->__last_response;
    }

    /**
     * [addDomain description]
     * @param [type] $params [description]
     */
    public function addDomain($params)
    {
        $paramsArr = $params;

        $xml='';
        foreach ($params as $key => $value) {
            $xml .= "<Field name=\"$key\">$value</Field>";
        }

        $params = "<AddDomain><XmlDoc><NewDomain>$xml</NewDomain></XmlDoc></AddDomain>";

        $params = new \SoapVar($params, XSD_ANYXML);

        $this->client->AddDomain($params);
        //dd( $this->client->__last_request);
        return $this->client->__last_response;
    }

    /**
     * [addDomain description]
     * @param [type] $params [description]
     */
    public function setSaleOrder($action, $saleParams, $itemAddonsParams)
    {
        $lineItem = '';
        foreach ($itemAddonsParams as $key => $value) {
            $lineItem .= '<LineItem>'
            . '<Field name="ItemCode">' . $value['ItemCode'] . '</Field>'
            . '<Field name="Quantity">' . $value['Quantity'] . '</Field>'
            . '</LineItem>';
        }

        $xml = '';
        foreach ($saleParams as $key => $value) {
            if (! is_array($key) && ! is_array($value))
                $xml .= '<Field name="' . $key . '">' . $value . '</Field>';
        }

        $params = "<$action><XmlDoc><SalesOrder><XmlDoc><Header>$xml</Header><Lines>$lineItem</Lines></XmlDoc></SalesOrder></XmlDoc></$action>";

        $params = new \SoapVar($params, XSD_ANYXML);
        $this->client->$action($params);

        return $this->client->__last_response;
    }

    /**
     * [addDomain description]
     * @param [type] $params [description]
     */
    public function createInvoiceAndPaymentBaseOnSalesOrder($params, $SaleOrderReferenceNo)
    {
        $lineItem = '';
        foreach ($params as $key => $value) {
            $lineItem .= '<Field name="' . $key . '">' . $value . '</Field>';
        }

        $params = "<CreateInvoiceAndPaymentBaseOnSalesOrder><XmlDoc><Invoice><Header><Field name=\"SaleOrderReferenceNo\">$SaleOrderReferenceNo</Field></Header><Lines><Field name=\"TaxCode\">EX</Field></Lines>" .
                  "<PaymentLines>$lineItem</PaymentLines></Invoice></XmlDoc></CreateInvoiceAndPaymentBaseOnSalesOrder>";

        $params = new \SoapVar($params, XSD_ANYXML);

        $this->client->CreateInvoiceAndPaymentBaseOnSalesOrder($params);

        return $this->client->__last_response;
    }

    protected static function parseBPDetails($xmlstring)
    {
        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:'], '', $xmlstring);
        $xml = simplexml_load_string($clean_xml);

        $user = [];
        foreach($xml->Body->GetBPDetailsResponse->GetBPDetailsResult->NewCustomer->Field as $k => $v) {
            $user[trim($v->attributes())] = trim($v);
        }

        return [
            'first_name' => $user['FirstName'],
            'last_name' => $user['LastName'],
            'password' => $user['Password'],
            'company_name' => $user['CompanyName'],
            'street_address' => $user['StreetAddress'],
            'city' => $user['City'],
            'zip' => $user['Zip'],
            'state' => $user['State'],
            'country' => $user['Country'],
            'phone' => $user['CellNumber'],
            'email' => $user['Email'],
            'second_email' => $user['SecondEmail'],
            'second_phone' => $user['SecondCellNumber'],
            'fax' => $user['FaxNumber'],
            'company_number' => $user['CompanyNumber'],
            'contact_person' => $user['ContactPerson'],
            'facebook' => $user['Facebook'],
        ];
    }
}
