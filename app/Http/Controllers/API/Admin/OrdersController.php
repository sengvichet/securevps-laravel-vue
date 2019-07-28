<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Soap\WSSoapShev;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 *
 */
class OrdersController extends Controller
{
    private $sap;

    public function __construct()
    {
        $this->sap = new WSSoapShev('order');
    }

    public function index(Request $request)
    {
        $sorting = [
            'DocNum' => 'ORDERNO',
            'U_WEBSITE_USERNAME' => 'USERNAME',
            'CardName' => 'LASTNAME',
            'CardCode' => 'BPCODE',
            'U_ICR_DOMAIN_NAME' => 'DOMAINNAME',
            'DocTotal' => 'ORDERTOTALAMOUNT',
            'DocStatus' => 'ORDERSTATUS',
            'DocDate' => 'ORDERDATE',
        ];

        $params = [
            'filterUsername' => $request['query']['U_WEBSITE_USERNAME'],
            'filterLastName' => $request['query']['CardName'],
            'filterOrderNo' => $request['query']['DocNum'],
            'filterDomainName' => $request['query']['U_ICR_DOMAIN_NAME'],
            'filterBPCode' => $request['query']['CardCode'],

            'pageIndex' => $request->page,
            'pageSize' => $request->limit,
            'orderbyDirection' => ($request->ascending ? 'asc': 'desc'),
        ];

        if(isset($request->orderBy) && !empty($request->orderBy)){
            $params['orderbyField'] = $sorting[$request->orderBy];
        }else{
            $params['orderbyField'] = '';
        }

        $xmlstring = xmlToArray($this->sap->callTo('GetAllSalesOrders_by_FilterOptions', $params));
        $orders = array_get($xmlstring, 'Body.GetAllSalesOrders_by_FilterOptionsResponse.GetAllSalesOrders_by_FilterOptionsResult.NewDataSet.Table', []);

        foreach ($orders as $key => $value) {
            $orders[$key]['DocDate'] = date("d/m/Y", strtotime($value['DocDate']));
        }

        return response()->json(['data' => $orders, 'count' => $orders[0]['TotalRows'], 'orderby' => $request->orderBy]);
    }


}
