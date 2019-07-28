<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\User;
use Validator;
use App\Http\Soap\WSSoapShev;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Class UsersController extends Controller
{
    private $sap;

    public function __construct()
    {
        $this->middleware('admin');
        $this->sap = new WSSoapShev('bp');
    }

    public function index(Request $request)
    {
        $params = [
            'filterUsername' => $request['query']['U_WEBSITE_USERNAME'],
            'filterLastName' => $request['query']['CardName'],
            'filterBPCode' => $request['query']['CardCode'],

            'pageIndex' => $request->page,
            'pageSize' => $request->limit,
            'orderbyField' => $request->orderBy,
            'orderbyDirection' => ($request->ascending ? 'asc': 'desc'),
        ];

        $prepareAccountsList = $this->prepareAccountsList ($params);
        $allAccountsList = $this->prepareAccountsList (array());

        // dd($prepareAccountsList);

        // return response()->json(['data' => $prepareAccountsList, 'count' => $prepareAccountsList[0]['TotalRows'], 'orderby' => $request->orderBy]);
        return response()->json(['data' => $prepareAccountsList, 'count' => count($allAccountsList), 'orderby' => $request->orderBy]);
    }

    /*
    public function index_old()
    {
        $accounts = xmlToArray($this->sap->callTo('GetAllBusinessPartners', []));
        $accountsList = array_get($accounts, 'Body.GetAllBusinessPartnersResponse.GetAllBusinessPartnersResult.NewDataSet.Table', []);
        $prepareAccountsList = [];

        foreach ($accountsList as $key => $value) {
            **$prepareAccountsList[$key]['U_WEBSITE_USERNAME'] = $value['U_WEBSITE_USERNAME'];
            **$prepareAccountsList[$key]['CardName'] = $value['CardName'];
            **$prepareAccountsList[$key]['U_CLIENT_EMAIL1'] = $value['U_CLIENT_EMAIL1'];
            **$prepareAccountsList[$key]['CreateDate'] = $value['CreateDate'];
            **$prepareAccountsList[$key]['CardCode'] = $value['CardCode'];
        }

        return response()->json($prepareAccountsList);
    }
    */

    public function loginAsUser(Request $request)
    {
        session([
            'signedIn' => true,
            'userId' => \Session::getId(),
            'username' => $request->asUser['username'],
            'firstName' => $request->asUser['firstName'],
            'lastName' => $request->asUser['lastName'],
            'password' => $request->asUser['password'],
            'BPCode' => $request->asUser['BPCode'],
        ]);
    }

    public function prepareAccountsList ($params)
    {
        $xmlstring = xmlToArray($this->sap->callTo('GetAllBusinessPartners_Filter', $params));
        $accountsList = array_get($xmlstring, 'Body.GetAllBusinessPartners_FilterResponse.GetAllBusinessPartners_FilterResult.NewDataSet.Table', []);

        $prepareAccountsList = [];
        foreach ($accountsList as $key => $value) {
            $prepareAccountsList[$key]['U_WEBSITE_USERNAME'] = $value['U_WEBSITE_USERNAME'];
            $prepareAccountsList[$key]['CardName'] = $value['CardName'];
            $prepareAccountsList[$key]['U_CLIENT_EMAIL1'] = $value['U_CLIENT_EMAIL1'];
            $prepareAccountsList[$key]['CreateDate'] = $value['CreateDate'];
            $prepareAccountsList[$key]['CardCode'] = $value['CardCode'];
        }

        foreach ($prepareAccountsList as $key => $value) {
            $prepareAccountsList[$key]['CreateDate'] = date("d/m/Y", strtotime($value['CreateDate']));
        }

        return $prepareAccountsList;

    }
}
