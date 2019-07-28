<?php

namespace App\Http\Controllers\API;

use App\Models\Items;
use App\Models\Cart;
use App\Models\CartAddons;
use App\Http\Soap\WSSoapShev;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Cookie;

Class WizardController extends Controller
{
    public function __construct()
    {
        # Code...
    }

    /**
     * $vps = 'V';
     * $server = 'S';
     * $reseller = 'R';
     * $linux = 'L';
     * $windows = 'W';
     * $period = '01';
     * $runningNumber = '01';
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index(Request $request)
    {
        $cart = Cart::find($request->cart);

        return [
            'package' => Items::find($cart->item_id),
            'domain' => $cart->domain,
            'ipHostSelected' => $cart->ip_host,
            'ipVpsOs' => $cart->vps_os,
        ];
    }

    public function getSharedAddons(Request $request)
    {
        $package = Items::find($request->itemid)->toArray();

        if (! $package) {
            return response('error trying to fetch item ' . __FILE__ . __LINE__);
        }

        if ($package['item_os'] === 'Linux') {
            $os = 'L';
        } else if ($package['item_os'] === 'Windows') {
            $os = 'W';
        } else {
            return response('error trying to fetch operationg system ' . __FILE__ . __LINE__);
        }

        $osName = $package['item_os'];

        $addons = Items::where('id', 'like', 'A%')
                ->where('id', 'like', '_' . $os . '%')
                ->where('id', 'like', '__' . substr($request->itemid, 0, 2) . '%')
                ->get();

        $cadn = CartAddons::where('cart_id', $request->cart)->get();

        $vals = [];
        foreach ($cadn as $key => $value) {
            $vals[$value['addon_id']] = $value['value'];
        }

        $ret = [];

        foreach ($addons as $key => $value) {

            if($value['uom'] == 1024) {
                $min_slider = $value['min_slider'];
                $max_slider = $value['max_slider'] / $value['uom'];
                $interval_slider = $value['interval_slider'] / $value['uom'];
                $default_slider = $value['default_slider'] / $value['uom'];
                $formatter = '{value} GB';

            }else if($value['uom'] == 100){
                $min_slider = $value['min_slider'];
                $max_slider = $value['max_slider'] ;
                $interval_slider = $value['interval_slider'] ;
                $default_slider = $value['default_slider'] ;
                $formatter = '{value} MB';

            }else if($value['uom'] == 1){
                $min_slider = $value['min_slider'];
                $max_slider = $value['max_slider'];
                $interval_slider = $value['interval_slider'];
                $default_slider = $value['default_slider'];
                $formatter = '{value}';
            }

//            in process version
            if(empty($min_slider)){
                $min_slider = 0;
            }
            if(empty($max_slider)){
                $max_slider = 200;
            }
            if(empty($interval_slider)){
                $interval_slider = 5;
            }
            if(empty($default_slider)){
                $default_slider = 5;
            }


                $ret[$key] = $value;
//                $ret[$key]['value'] = array_get($vals, $value['id'], 0);
                $ret[$key]['value'] = intval($default_slider);
                $ret[$key]['slidercog'] = [
                    'min' => intval($min_slider),
                    'max' => intval($max_slider),
                    'interval' => intval($interval_slider),
                    'reverse' => true,
                    'piecewise' => true,
                    'piecewiseLabel' => false,
                    'dotSize' => 20,
                    'formatter'=> $formatter
                ];
//            }
        }

        //GetAllIPsForNewDomains
        $sapinv = new WSSoapShev('inventory');

        $ipHostList = [];

        $ipHost = xmlToArray($sapinv->callTo('GetAllIPsForNewDomains', []));
        $ipHost = array_get($ipHost, 'Body.GetAllIPsForNewDomainsResponse.GetAllIPsForNewDomainsResult.NewDataSet.Table', []);

        $ipHostList = [];
        foreach ($ipHost as $key => $value) {
            if ($value['U_OSTYPE'] === $osName) {
                $ipHostList[] = $value;
            }
        }

        return [
            'addons' => $addons,
            'ipHostList' => $ipHostList,
        ];
    }

    public function store(Request $request)
    {
        $addons = array_merge($request->data['addons'], $request->data['trAddons']);

        foreach ($addons as $key => $value) {
            if ($value['value'] > 0) {
                $cadn = CartAddons::updateOrCreate([
                    'cart_id' => $request->data['packageId'],
                    'addon_id' => $value['id']
                ],[
                    'value' => $value['value'],
                    'end_date' => !empty($value['endDate']) ? $value['endDate'] . ' ' . $value['endTime'] . ':00': null,
                    'total_hours' => !empty($value['total_hours']) ? $value['total_hours']: 0,
                ]);
            } else {
                $cadn = CartAddons::where('addon_id', $value['id'])->where('cart_id', $request->data['packageId'])->delete();
            }
        }

        $cart = Cart::find($request->data['packageId']);
        $cart->ip_host = $request->data['ipHostSelected'];
        $cart->vps_os = $request->data['vpsOs'];
        $cart->total = $request->data['total'];
        $cart->updated_at = date("Y-m-d H:i:s");
        $cart->save();

        return response()->json();
    }

    public function getVPSAddons(Request $request)
    {
        $cart = Cart::find($request->cart);

        if(! $cart) {
            return '0';
        }

        $package = Items::find($request->item_id);

        $addon = 'AV';
        $period = '12';// substr($item_id, 3, 2);
        //AVL1220-AddonBTCpuCore

        $addons = Items::where('id', 'like', $addon . '%')
                ->where('id', 'like', '__' . substr($request->os, 0, 1) . '%')
                ->where('id', 'like', '___' . $period . '%')
                ->get();

        $cadn = CartAddons::where('cart_id', $request->cart)->get();

        $vals = [];
        foreach ($cadn as $key => $value) {
            $vals[$value['addon_id']]['value'] = $value['value'];
            $vals[$value['addon_id']]['endDate'] = $value['end_date'];
        }

        $ret = [];
        foreach ($addons as $key => $value) {

            if (!empty($vals[$value['id']]['endDate'])) {
                $date = strtotime($vals[$value['id']]['endDate']);
                $dat = date('Y-m-d', $date);
                $tme = date('H:i',$date);
            } else {
                $dat = '';
                $tme = '';
            }

            $ret[$key] = $value;
            $ret[$key]['value'] = !empty($vals[$value['id']]['value']) ? $vals[$value['id']]['value']: 0;
            $ret[$key]['total_hours'] = !empty($vals[$value['id']]['total_hours']) ? $vals[$value['id']]['total_hours']: 0;
            $ret[$key]['endDate'] = $dat;
            $ret[$key]['endTime'] = $tme;
            $ret[$key]['slidercog'] = [
                'min' => 0,
                'max' => 5,
                'interval' => 1,
                'reverse' => true,
                'piecewise' => true,
                'piecewiseLabel' => false,
                'dotSize' => 20,
            ];
        }

        $addons = $addons->toArray();

        $regularAddons = array_where($addons, function($key, $value)
        {
            return strpos($key['id'], 'BT') === false;
        });

        $boostTemporaryAddons = array_where($addons, function($key, $value)
        {
            return strpos($key['id'], 'BT') > -1;
        });

        foreach ($boostTemporaryAddons as $key => $value) {
            $boostTemporaryAddons[$key]['price'] = ($value['price'] / $period / 30 / 24);
        }

        //GetAllIPsForNewDomains
        $sapinv = new WSSoapShev('general');

        $ipHost = xmlToArray($sapinv->callTo('GetVpsIPs', []));
        $ipHost = array_get($ipHost, 'Body.GetVpsIPsResponse.GetVpsIPsResult.NewDataSet.Table', []);

        return ['addons' => $regularAddons, 'boostTemporaryAddons' => $boostTemporaryAddons, 'ipHostList' => $ipHost];
    }

    /*
    private function saveDomain(Request $request)
    {
        $domain = $request->data['domain'];

        $sapord = new WSSoapShev('order');

        $res = xmlToArray($sapord->callTo('CheckDomainStatus', ['domainName' => $domain]));
        $res2 = array_get($res, 'Body.CheckDomainStatusResponse.CheckDomainStatusResult', []);

        if (strpos($res2, '<Exsist>true</Exsist>') !== false) {

            if (session('signedIn')) {
                $sappv = new WSSoapShev('pageview');

                $params = [
                    'BPCode' => session('BPCode')
                ];

                $xmlstring = $sappv->callTo('GetActiveDomainSpacesFor_A_BPCode', $params);
                $dataXml = xmlToArray($xmlstring);
                $domains = array_get($dataXml, 'Body.GetActiveDomainSpacesFor_A_BPCodeResponse.GetActiveDomainSpacesFor_A_BPCodeResult.NewDataSet.Table', []);
                $domainsList = array_column($domains, 'U_DOMAIN_NAME');
                $domainActive = array_column($domains, 'U_Active', 'U_DOMAIN_NAME');

                if(! in_array($domain, $domainsList)) {
                    return ['error' => 'domain not avaliable', 'msg' => 'This domain busy by other user please select other domain 1'];
                } else {
                    if ($domainActive[$domain] !== 'Y') {
                        return ['error' => 'domain not avaliable', 'msg' => 'This domain busy by other user please select other domain 2'];
                    }
                }
            } else {
                return ['error' => 'must connect', 'msg' => 'You must connect to check if this domain is yours'];
            }
        }

        $cart = Cart::find($request->data['packageId']);
        $cart->domain = $request->data['domain'];
        $cart->ip_host = $request->data['ipHostSelected'];
        $cart->vps_os = $request->data['vpsOs'];
        $cart->total = $request->data['total'];
        $cart->save();

        return ['success' => 'ok', 'msg' => ''];
    }
    */
}
