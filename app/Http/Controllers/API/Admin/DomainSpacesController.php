<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Soap\WSSoapShev;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 *
 */
class DomainSpacesController extends Controller
{
    private $sap;

    public function __construct()
    {
        $this->sap = new WSSoapShev('bp');
    }

    public function index(Request $request)
    {
        $sorting = [
            'U_DOMAIN_NAME' => 'DOMAINNAME',
            'U_CP_USER_Name' => 'USERNAME',
            'U_ICR_BP_NAME' => 'LASTNAME',
            'CardCode' => 'BPCODE',
            'U_Active' => 'DOMAINSTATUS',
            'LastOrderdate' => 'DOMAINLASTORDERDATE',
        ];

        $params = [
            'filterUsername' => $request['query']['U_CP_USER_Name'],
            'filterBPCode' => $request['query']['CardCode'],
            'filterFirstName' => $request['query']['U_ICR_BP_NAME'],
            'filterLastName' => $request['query']['U_ICR_BP_NAME'],
            'filterEmail' => '',
            'filterCellNo' => '',
            'filterDomainName' => $request['query']['U_DOMAIN_NAME'],

            'pageIndex' => $request->page,
            'pageSize' => $request->limit,
            'orderbyDirection' => ($request->ascending ? 'asc': 'desc'),
        ];

        if(isset($request->orderBy) && !empty($request->orderBy)){
            $params['orderbyField'] = $sorting[$request->orderBy];
        }else{
            $params['orderbyField'] = '';
        }

        $xmlstring = xmlToArray($this->sap->callTo('GetAllDomainsResult_by_FilterOptions', $params));
        $domains = array_get($xmlstring, 'Body.GetAllDomainsResult_by_FilterOptionsResponse.GetAllDomainsResult_by_FilterOptionsResult.NewDataSet.Table', []);

        foreach ($domains as $key => $value) {
            $domains[$key]['LastOrderdate'] = date("d/m/Y", strtotime($value['LastOrderdate']));
        }

        return response()->json(['data' => $domains, 'count' => $domains[0]['TotalRows'], 'orderby' => $request->orderBy]);
    }
}
