<?php

namespace App\Http\Controllers\API\User;

use App\Models\User;
use App\Models\Items;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

Class UpgradeController extends Controller
{
    public function __construct()
    {

    }

    public function getPackeges(Request $request)
    {
        $currentId = $request->currentId;
        $upgradeType = $request->upgradeType;
        $res = $request->res;

        $current = Items::find($currentId);
        $pckid = explode('-', $currentId);
        $current->item_type;
        $current->item_os;
        $current->user_level;

        $upTypeQ = [
                '1' => [
                    '%',
                    '____-' . $pckid[1],
                ],
                '2' => [
                    substr($pckid[0], 0, 2) . '%',
                    '%',
                ],
                '3' => [
                    '%',
                    '%',
                ],
            ];

        $list = Items::where('item_type', $current->item_type)
                        ->where('item_os', $current->item_os)
                        ->where('user_level', $current->user_level)
                        //->where('id', 'not like', $currentId)
                        ->where('price', '>=', $current->price)
                        ->where('id', 'like', $upTypeQ[$upgradeType][0])
                        ->where('id', 'like', $upTypeQ[$upgradeType][1])
                        ->orWhere('id', 'like', '%' . '-'. $pckid[1]. '%')
                        ->where('id', 'like', '%' . substr($pckid[0], 0, 2) . '%')
                        ->with('itemProps')->orderby('id')->orderby('price')->get();

        $list2 = [];
        foreach ($list as $key => $value) {
            $list2[$key] = $value;
            $list2[$key]['itemprops'] = $value->itemProps->pluck('quantity', 'name')->toArray();
        }

        $result = $request->segments();

        if($result[4] == 2 && $res != 'pack'){

            foreach ($list as $key => $value) {
                $checkId = substr($value['id'], 2, 2);

                if($checkId == $res){
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
                }
            }
            return $ret;
        };

        return $list2;
    }

    /**
     * [setSummerize description]
     * @param Request $request [description]
     */
    public function setSummerize(Request $request)
    {
        session([
            'payfor_type' => 'upgrade',
            'payfor_cartId' => '',
            'payfor_orderId' => $request->params['orderId'],
            'payfor_items' => $request->params['items'],
            'payfor_refund_items' => $request->params['refundItems'],
            'payfor_iphost' => $request->params['ipHost'],
            'payfor_itemId' => $request->params['selectedId'],
            'payfor_refund_itemId' => $request->params['currentId'],
            'payfor_total' => number_format($request->params['total'], 2),
            'payfor_domain' => $request->params['domain'],
        ]);

        return 1;
    }

    /**
     * [getNewAddons description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getNewAddons(Request $request)
    {
        $idList = [];
        $period = substr($request->selectedId, 0, 2);

        if(strpos($request->selectedId, 'Lx') !== false) {
            $os = 'Linux';
        } else {
            $os = 'Windows';
        }

        foreach ($request->addList as $key => $value) {
            $newValue = substr_replace($value, $period, 2,2);
            $idList[] = $newValue;
        }

        return Items::where('item_os', $os)->where(function($query) use ($idList) {
            foreach($idList as $value) {
                $query->orWhere('id', 'LIKE', substr($value, 0, 4) . '__' . substr($value, 6));
            }})->get()->toArray();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllPackages($type, $os, $description)
    {

        $list = Items::where([
            ['item_type', 'Hosting-Package'],
            ['item_os','=', $os],
            ['description','!=', $description],
            ['id', 'LIKE', $type.'%'],
            ['id', 'NOT LIKE', '%Res%']
        ])->with('itemProps')->orderby('price')->get()->toArray();


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
