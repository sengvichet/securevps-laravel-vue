<?php

namespace App\Http\Controllers\API\User;

use App\Models\User;
use App\Models\Items;
use Carbon\Carbon;
use Validator;
use App\Http\Soap\WSSoapShev;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Session;
Class DomainSpacesController extends Controller
{
    private $sapord;
    private $sappv;
    const DESCRIPTION_PACKAGE ='/(Package)/';
    const DESCRIPTION_ADDON ='/(Addon)/';
    const DESCRIPTION_BANDWIDTH ='/(Bandwidth)/';
    const DESCRIPTION_WEBSPACE ='/(Webspace)/';

    public function __construct()
    {
        $this->sapord = new WSSoapShev('order');
        $this->sappv = new WSSoapShev('pageview');
        $this->sapinvoice = new WSSoapShev('invoice');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index(Request $request)
    {
        $paramsTest = [
            'pageIndex' => 1,
            'pageSize' => 1,
            'BPCode' => session('BPCode')
        ];
        $domainsTest = $this->GetActiveDomainSpacesFor_A_BPCode_Filter($paramsTest);
        session(['count' => $domainsTest['dataRows']['totalRows']]);

        if(session()->has('domains')){
            $arrayDomains = session()->get('domains');
        }

        if(session()->has('domainsCount')){

            $count = session()->get('domainsCount');

        } else if(session()->has('count')){

            $count = session()->get('count');

        }
        else if(isset($request->limit) && isset($request->page)){

            $count = $request->limit;

        }

        $params = [
            'pageIndex' => 1,
            'pageSize' => $count,
            'BPCode' => session('BPCode')
        ];


        $domains = $this->GetActiveDomainSpacesFor_A_BPCode_Filter($params);


        $list = [];
        foreach ($domains['list'] as $key => $value) {

            $taq = $this->_getTotalAmountAndQty($value);
            $docDate = date("d/m/Y", strtotime(array_get($value, 'DocDate', '')));

            $salesOrder = $this->_getSalesOrder($value);
            $listItem = [
                'domainName' => $value['U_DOMAIN_NAME'],
                'userName' => $value['U_CP_USER_Name'],
                'passw' => $value['U_CP_Password'],
                'docStatus' => $salesOrder['status'],
                'docDate' => $docDate,
                'order_id' => array_get($value, 'DocEntry', ''),
                'numOrders' => $taq['numOrders'],
                'totalAmount' => $taq['totalAmount'],
                'salesOrder' => $salesOrder['list'],
            ];
            array_push($list, $listItem);
        }

        $dateForEachDomain = [];
        foreach ($list as $i => $item) {
            foreach ($list as $key => $value) {
                if ($value['domainName'] === $item['domainName']) {
                    if(isset($dateForEachDomain[$item['domainName']]) && !empty($dateForEachDomain[$item['domainName']])) {
                        if($value['order_id'] > $dateForEachDomain[$item['domainName']]) {
                            $dateForEachDomain[$item['domainName']] = $value['order_id'];
                        }
                    } else {
                        $dateForEachDomain[$item['domainName']] = $value['order_id'];
                    }
                }
            }
        }

        foreach ($list as $key => $value) {
            foreach ($list as $keyU => $valueU) {
                if ($list[$key]['domainName'] == $list[$keyU]['domainName']) {
                    if ($list[$key]['docDate'] != $list[$keyU]['docDate']) {
                        array_push($list[$keyU]['salesOrder'], $list[$key]['salesOrder'][0]);
                    }
                }
            }
        }

        $newList = [];
        foreach ($list as $key => $value ) {
            $list[$key]['numOrders'] = count($value['salesOrder']);
            if ($list[$key]['order_id'] == $dateForEachDomain[$list[$key]['domainName']]) {
                array_push($newList, $list[$key]);
            }
        }
        $newListDomainName = [];
        foreach ($newList as $key => $value) {
            array_push($newListDomainName, $value['domainName']);
        }
        if(isset($arrayDomains)) {
            $arrayDiff = array_diff($arrayDomains,$newListDomainName);
            $arrayDiff = array_unique($arrayDiff);
            $domainsArray = [];
            foreach ($arrayDiff as $key => $value) {
                $domainsArray[]['domainName'] = $value;
            }
        } else {
            $domainsArray =[];
        }
        return response()->json(['data' => $newList, 'count' => count($newList), 'diff' => $domainsArray]);
    }

    /**
     * [_GetAllSalesOrderHeaderDataFor_A_Domain description]
     * @param  [type] $domainName [description]
     * @return [type]             [description]
     */
    private function GetActiveDomainSpacesFor_A_BPCode_Filter($params)
    {
        $xmlstring = $this->sappv->callTo('GetActiveDomainSpacesFor_A_BPCode_Filter', $params);
        $dataXml = xmlToArray($xmlstring);
        $list = array_get($dataXml, 'Body.GetActiveDomainSpacesFor_A_BPCode_FilterResponse.GetActiveDomainSpacesFor_A_BPCode_FilterResult.NewDataSet.Table', []);
        $dataRows = array_get($dataXml, 'Body.GetActiveDomainSpacesFor_A_BPCode_FilterResponse.GetActiveDomainSpacesFor_A_BPCode_FilterResult.NewDataSet.DataRows', []);
        $domains = [
            "list"=>$list,
            "dataRows"=>$dataRows
        ];

        return $domains;
    }

    /**
     * [_getTotalAmountAndQty description]
     * @param  [type] $salesData [description]
     * @return [type]            [description]
     */
    private function _getTotalAmountAndQty($salesData)
    {
        if (! count($salesData)) {
            $no = 0;
            $docStatus = 'M';
            $totalAmount = 0;
            $order_id = '';
        } elseif (!empty($salesData['DocEntry'])) {
            $no = 1;
            $totalAmount = (int) array_get($salesData, 'DocTotal', 0);
        } else {
            $totalAmount = 0;
            $no = 0;
            foreach ($salesData as $key => $value) {
                $no ++;
                $totalAmount += (int) array_get($value, 'DocTotal', 0);
            }
        }

        $docStatus = 'M';

        return [
            'totalAmount' => $totalAmount,
            'numOrders' => $no,
            'DocStatus' => $docStatus,
        ];
    }

    /**
     * [_getSalesOrder description]
     * @param  [type] $salesData [description]
     * @return [type]            [description]
     */
    private function _getSalesOrder($salesData)
    {
        $list = [];

        if(empty($salesData['DocEntry'])) {
            $i = 0;
            $close = false;
            $open = false;
            $mix = false;
            $status = '';
            foreach ($salesData as $key => $value) {
                $docDate = date("d/m/Y", strtotime(array_get($value, 'DocDate', '')));
                $list[$i]['docDate'] = $docDate;
                $list[$i]['docEntry'] = $value['DocEntry'];
                $list[$i]['docStatus'] = $value['DocStatus'];
                $list[$i]['totalAmount'] = number_format(array_get($value, 'DocTotal', 0), 2);
                $list[0]['domainName'] = array_get($value, 'U_ICR_DOMAIN_NAME', '');
                $list[0]['userName'] = array_get($value, 'U_ICR_CP_USER_NAME', '');
                $list[0]['passw'] = array_get($value, 'U_ICR_CP_PASSWORD', '');
                $list[$i]['phone'] = array_get($value, 'U_ICR_PHONE1', '');
                $list[$i]['email'] = array_get($value, 'U_ICR_EMAIL1', '');
                $list[$i]['address'] = array_get($value, 'Address', '');
                $i++;

                if ($value['DocStatus'] == 'C') {
                    $status = 'C';
                    $close = true;
                }

                if ($value['DocStatus'] == 'O') {
                    $status = 'O';
                    $open = true;
                }

                if ($close && $open) {
                    $status = 'M';
                    $mix = true;
                }
            }
        } elseif(!empty($salesData['DocEntry'])) {
            $docDate = date("d/m/Y", strtotime(array_get($salesData, 'DocDate', '')));
            $list[0]['docDate'] = $docDate;
            $list[0]['docEntry'] = $salesData['DocEntry'];
            $list[0]['docStatus'] = $salesData['DocStatus'];
            $list[0]['totalAmount'] = number_format(array_get($salesData, 'DocTotal', 0), 2);
            $list[0]['domainName'] = array_get($salesData, 'U_ICR_DOMAIN_NAME', '');
            $list[0]['userName'] = array_get($salesData, 'U_ICR_CP_USER_NAME', '');
            $list[0]['passw'] = array_get($salesData, 'U_ICR_CP_PASSWORD', '');
            $list[0]['phone'] = array_get($salesData, 'U_ICR_PHONE1', '');
            $list[0]['email'] = array_get($salesData, 'U_ICR_EMAIL1', '');
            $list[0]['address'] = array_get($salesData, 'Address', '');

            $status = $salesData['DocStatus'];
        }

        return ['list' => $list, 'status' => $status];
    }

    /**
     * @param $token
     * @return mixed
     */
    public function getAllPackages($token){
        $dataXml = xmlToArray($this->sapord->callTo('GetSpecificSalesOrderDataFor_A_DocEntry', ['docEntry' => $token]));
        $ret = array_get($dataXml, 'Body.GetSpecificSalesOrderDataFor_A_DocEntryResponse.GetSpecificSalesOrderDataFor_A_DocEntryResult.NewDataSet', []);
        return $ret;
    }
    /**
     * [orderData description]
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function orderData($token)
    {
        $ret = $this->getAllPackages($token);
        return response()->json(['data' => $ret]);
    }

    /**
     * [getDomainInvoices description]
     * @param  [type] $domain [description]
     * @return [type]         [description]
     */
    public function getDomainInvoicesAndReceipts(Request $request)
    {
        $domain = $request->domain;
        session(['invoicedomain' => $domain]);
        $xmlstringInvoices = $this->sapinvoice->callTo('GetAllDomainInvoices', ['clientUserName' => session('username'), 'domainName' => $domain]);
        $dataXmlInvoices = xmlToArray($xmlstringInvoices);
        $invoices = array_get($dataXmlInvoices, 'Body.GetAllDomainInvoicesResponse.GetAllDomainInvoicesResult.NewDataSet.Table', []);

        $resInvoices = [];
        if (isset($invoices['DocEntry'])) {
            $resInvoices[] = $invoices;
        } else {
            $resInvoices = $invoices;
        }

        $xmlstringReceipts = $this->sapinvoice->callTo('GetAllDomainReceipts', ['clientUserName' => session('username'), 'domainName' => $domain]);
        $dataXmlReceipts = xmlToArray($xmlstringReceipts);
        $receipts = array_get($dataXmlReceipts, 'Body.GetAllDomainReceiptsResponse.GetAllDomainReceiptsResult.NewDataSet.Table', []);

        $resReceipts = [];
        if (isset($receipts['DocEntry'])) {
            $resReceipts[] = $receipts;
        } else {
            $resReceipts = $receipts;
        }

        return response()->json(['data' => ['invoices' => $resInvoices, 'receipts' => $resReceipts]]);
    }

    /**
     * [GetAllClientInvoices description]
     */
    public function getAllClientInvoices()
    {
        $xmlstring = $this->sapinvoice->callTo('GetAllClientInvoices', ['clientUserName' => session('username')]);
        $dataXml = xmlToArray($xmlstring);

        $invoices = array_get($dataXml, 'Body.GetAllClientInvoicesResponse.GetAllClientInvoicesResult.NewDataSet.Table', []);

        $docStatus = [
            'C' => 'חשבונית סגורה',
            'O' => 'חשבונית פתוחה',
        ];

        $results = [];
        foreach ($invoices as $key => $value) {
            $results[$key]['DocEntry'] = $value['DocEntry'];
            $results[$key]['DocDate'] = date('m/d/Y', strtotime($value['DocDate']));
            $results[$key]['DocStatus'] = $docStatus[$value['DocStatus']];
            $results[$key]['U_ICR_DOMAIN_NAME'] = $value['U_ICR_DOMAIN_NAME'];
            $results[$key]['DocTotal'] = $value['DocTotal'];
        }

        return response()->json(['data' => $results]);
    }

    /**
     * [GetAllClientReceipts description]
     */
    public function getAllClientReceipts()
    {
        $xmlstring = $this->sapinvoice->callTo('GetAllClientReceipts', ['clientUserName' => session('username')]);
        $dataXml = xmlToArray($xmlstring);

        $receipts = array_get($dataXml, 'Body.GetAllClientReceiptsResponse.GetAllClientReceiptsResult.NewDataSet.Table', []);
        $results = [];
        foreach ($receipts as $key => $value) {
            $results[$key]['DocNum'] = $value['ReceiptNum'];
            $results[$key]['Ref1'] = $value['invoiceNumber'];
            $results[$key]['DocDate'] = date('m/d/Y', strtotime($value['DocDate']));
            $results[$key]['DocTotal'] = $value['DocTotal'];
        }

        return response()->json(['data' => $results]);
    }

    /**
     * [download description]
     * @param  [type] $filename [description]
     * @return [type]           [description]
     */
    public function download($filename)
    {
        if (session('filename') === $filename) {

            return response()->download(storage_path() . "/downloadPdf/" . $filename);
        } else {
            return false;
        }
    }

    /**
     * [createPdf description]
     * @param  [type] $docEntry [description]
     * @param  [type] $thedate  [description]
     * @param  [type] $doctype  [description]
     * @return [type]           [description]
     */
    public function createPdf($docEntry, $thedate, $doctype)
    {
        //$docEntryList = array_column($this->getDomainInvoices(session('invoicedomain')), 'Sales_x0020_Order_x0020_DocEntry');

        // if (! in_array($docEntry, $docEntryList)) {
        //     return false;
        // }

        $sapRequest['invoice'] = stripslashes('<?xml version="1.0" encoding="utf-8"?><soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"><soap12:Body><DownloadInvoice><DocEntry>'.$docEntry.'</DocEntry><datetime>'.$thedate.'</datetime></DownloadInvoice></soap12:Body></soap12:Envelope>');
        $sapRequest['receipt'] = stripslashes('<?xml version="1.0" encoding="utf-8"?><soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"><soap12:Body><DownloadReceipt><DocEntry>'.$docEntry.'</DocEntry><datetime>'.$thedate.'</datetime></DownloadReceipt></soap12:Body></soap12:Envelope>');

        // allocate curl
        $curl = curl_init('http://212.150.41.90/TestForSite/SapBusinessOne_WebService_InvoiceAndReceipt.asmx');

        // initialize curl
        curl_setopt($curl, CURLOPT_HEADER, 				0 );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 		1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 		1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, 			array( "Content-Type: application/soap+xml; charset=utf-8" ) );
        curl_setopt($curl, CURLOPT_POST, 				1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, 			$sapRequest[$doctype]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 		0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 		0);

        // get data
        $xmlstring = curl_exec($curl);

        // close curl
        curl_close($curl);

        $dataXml = xmlToArray($xmlstring);
        $tar = [
            'invoice' => 'Body.DownloadInvoiceResponse.DownloadInvoiceResult',
            'receipt' => 'Body.DownloadReceiptResponse.DownloadReceiptResult',
        ];
        $res = array_get($dataXml, $tar[$doctype], '');
        $filename = 'shev_' . $doctype . '_' . $docEntry . '_' . $thedate . '.pdf';
        $doc = base64_decode($res);
        $len = file_put_contents(storage_path() . "/downloadPdf/" . $filename, $doc);

        if (is_bool($len) || $len != strlen($doc)) {
            return 'error create pdf';
        }

        session(['filename' => $filename]);

        return response()->json(['data' => $filename]);
    }

    public function GetInvoiceYears(){
        $xmlstring = $this->sapinvoice->callTo('GetInvoiceYears', ['username' => session('username')]);
        $dataXml = xmlToArray($xmlstring);
        $res = array_get($dataXml, 'Body.GetInvoiceYearsResponse.GetInvoiceYearsResult.NewDataSet.Table', []);

        return $res;

    }

    public function CreateInvoiceYears(Request $request){

       $data = [
           'username' => session('username'),
           'year' => $request->params
       ];

      $xmlstring = $this->sapinvoice->callTo('CreateInvoiceExcelByYear', $data);
      $dataXml = xmlToArray($xmlstring);
      $res = array_get($dataXml, 'Body.CreateInvoiceExcelByYearResponse.CreateInvoiceExcelByYearResult.NewDataSet.Table', []);

       $doc = file_get_contents($res['LinkKartesetFile']);
       $len = file_put_contents(public_path() . "/downloadXls/" . 'invoices_'.$data['year'].'_'.$data['username'].'_'.date("m.d.y").'.xls', $doc);

       $result = [
         'path' => 'invoices_'.$data['year'].'_'.$data['username'].'_'.date("m.d.y").'.xls',
       ];

       return $result;
    }

    /**
     * Get all Packages and find Active
     * Return active Packages
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAddonParentPackageDate(){

        $count = session('count');
        $page = 1;

        $params = [
            'pageIndex' => $page,
            'pageSize' => $count,
            'BPCode' => session('BPCode')
        ];

        $domains = $this->GetActiveDomainSpacesFor_A_BPCode_Filter($params);

        $lists = collect([]);
        $lists1 = collect([]);

        foreach ($domains['list'] as $key => $value) {
            $getAllPackages = $this->getAllPackages($value['DocEntry']);
            $result = $getAllPackages['Table1'];

            if (!array_key_exists(0,$result)) {

                $description = $result['Dscription'];
                $success = preg_match(self::DESCRIPTION_PACKAGE, $description, $match);

                if (!$success && ($result["U_ICR_END_DATE"] < Carbon::now())) {
                    $lists1[] = $result;
                }
            } else {
                $collection = collect($result);

                $filtered = $collection->map(function ($items, $k) use ($lists, $result) {
                    if (isset($items['Dscription'])) {
                        $description = $items['Dscription'];

                        if (isset($description)) {
                            $success = preg_match(self::DESCRIPTION_PACKAGE, $description);

                            if ($success && ($items["U_ICR_END_DATE"] < Carbon::now())) {
                                return $items;
                            } else {
                                return null;
                            }
                        }
                    }
                });
            }

            if (isset($filtered) && $filtered->isNotEmpty()) {
                $lists->push($filtered);
            }
        }

        if ($lists->isNotEmpty()) {
            $lists[] = $lists1;
        } else {
            $lists = $lists1;
        }

        $lengths = [];
        $max = -1;
        $count = 0;
        if (isset($lists) && $lists->isNotEmpty()) {
            foreach ($lists as $list){
                foreach ($list as $packInfo) {
                    if (!is_null($packInfo) && $packInfo['U_ICR_END_DATE'] !== 'false') {
                        $today = Carbon::parse($packInfo['U_ICR_END_DATE']);
                        $now = Carbon::now();

                        $length = $today->diffInDays($now);

                        if ($max < $length) {

                            $max = $length;
                            $lengths[$count] = $packInfo;
                            $lengths[$count]['ActiveDays'] = $max;

                        }
                    }
                }
            }

           $packageAllInfo = $this->getPackageInfoInItems($lengths[0]['ItemCode']);

            $packageAllInfo[0]['U_ICR_END_DATE'] = $lengths[0]['U_ICR_END_DATE'];
            $packageAllInfo[0]['U_ICR_START_DATE'] = $lengths[0]['U_ICR_START_DATE'];

            if (!empty($packageAllInfo)) {
                return response()->json(['data' => $packageAllInfo]);
            } else {
                return response()->json(['data' => '-1']);
            }
        } else {
            return response()->json(['data' => '-1']);
        }
    }

    /**
     * Get all Addons and find Active
     * Return active Addons
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkActiveAddonOnPackage(){

        $count = session('count');
        $page = 1;

        $params = [
            'pageIndex' => $page,
            'pageSize' => $count,
            'BPCode' => session('BPCode')
        ];

        $domains = $this->GetActiveDomainSpacesFor_A_BPCode_Filter($params);

        $lists = collect([]);
        $lists1 = collect([]);

        foreach ($domains['list'] as $key => $value) {
            $getAllPackages = $this->getAllPackages($value['DocEntry']);
            $result = $getAllPackages['Table1'];

             if (!array_key_exists(0,$result)) {

                    $description = $result['Dscription'];
                    $success = preg_match(self::DESCRIPTION_ADDON, $description, $match);

                    if ($success && ($result["U_ICR_END_DATE"] < Carbon::now())) {

                         $lists1[] = $result;
                    }
            } else {
                $collection = collect($result);

                $filtered = $collection->map(function ($items, $k) use ($lists, $result) {
                    if (isset($items['Dscription'])) {
                        $description = $items['Dscription'];

                        if (isset($description)) {
                            $success = preg_match(self::DESCRIPTION_ADDON, $description);

                            if ($success && ($items["U_ICR_END_DATE"] < Carbon::now())) {
                                return $items;
                            } else {
                                return null;
                            }
                        }
                    }
                });
            }

            if (isset($filtered) && $filtered->isNotEmpty()) {
                $lists->push($filtered);
            }
        }

        if ($lists->isNotEmpty()) {
            $lists[] = $lists1;
        } else {
            $lists = $lists1;
        }

        $addonInfo = [];
        $count = 0;
        if (isset($lists) && $lists->isNotEmpty()) {
            foreach ($lists as $list){
                foreach ($list as $key => $addInfo) {
                    if (!is_null($addInfo) && $addInfo['U_ICR_END_DATE'] !== 'false') {
                        $count++;

                        $today = Carbon::parse($addInfo['U_ICR_END_DATE']);
                        $now = Carbon::now();

                        $length = $today->diffInDays($now);

                        $addonInfo[$count]['Addon'] = $addInfo;
                        $addonInfo[$count]['Addon']['ActiveDays'] = $length;


                        $successBandwidth = preg_match(self::DESCRIPTION_BANDWIDTH, $addInfo['Dscription'], $match);
                        $successWebspace = preg_match(self::DESCRIPTION_WEBSPACE, $addInfo['Dscription'], $match);

                      if($successBandwidth || $successWebspace){
                          $addonUom = Items::select('uom', 'uom_type')->where('id', $addInfo['ItemCode'])->get();

                          $addonInfo[$count]['Addon']['uom'] = $addonUom[0]['uom'];
                          $addonInfo[$count]['Addon']['uom_type'] = $addonUom[0]['uom_type'];

                      }
                    }
                }
                if($count == 5){
                    break;
                }
            }

            if (!empty($addonInfo)) {
                return response()->json(['data' => $addonInfo]);
            } else {
                return response()->json(['data' => '-1']);
            }
        } else {
            return response()->json(['data' => '-1']);
        }
    }

    public function getPackageInfoInItems($id){

        $list = Items::where([['item_type', 'Hosting-Package'],['id', $id]])->with('itemProps')->orderby('price')->limit(1)->get()->toArray();
        $list2 = [];
        foreach ($list as $key => $value) {
            $list2[$key] = $value;
            $list2[$key]['itemprops'] = array_column($value['item_props'], 'quantity', 'name');

            foreach ($list2[$key]['itemprops'] as $key2 => $value2) {
                unset($list2[$key]['itemprops'][$key2]);
                $key2 = explode('-', $key2)[1];
                $list2[$key]['itemprops'][$key2] = $value2;
            }

            unset($list2[$key]['item_props']);
        }

        return $list2;
    }
}
