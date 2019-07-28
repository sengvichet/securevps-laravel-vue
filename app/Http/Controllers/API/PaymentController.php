<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Http\Soap\WSSoapShev;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartAddons;
//use Illuminate\Cookie;

Class PaymentController extends Controller
{
    public function __construct()
    {
        $this->sap = new WSSoapShev('bp');
    }

    public function getData()
    {
        if (session('payfor_type') === 'cart') {

            $matchCart = [
                'id' => session('payfor_cartId'),
                'domain' => session('payfor_domain'),
                'item_id' => session('payfor_itemId'),
            ];

            $cart = Cart::where($matchCart)->get()->toArray();

            if ( ! $cart) {
                return ['ok' => false];
            }
        }

        if (session('payfor_type') === 'upgrade') {
            // TODO
        }

        $user = $this->sap->callTo('GetBPDetails', ['BPCode' => session('BPCode')]);

        return [
            'ok' => true,
            'cartPackages' => [
                'total' => session('payfor_total'),
                'domain' => session('payfor_domain'),
                'cartId' => session('payfor_cartId'),
                'itemId' => session('payfor_itemId'),
            ],
            'user' => [
                'firstName' => $user['first_name'],
                'lastName' => $user['last_name'],
                'email' => $user['email'],
                'mobile' => $user['phone'],
                'company' => $user['company_name'],
                'idn' => $user['company_number'],
                'street_address' => $user['street_address'],
                'zip' => $user['zip'],
                'city' => $user['city'],
                'country' => $user['country'],
            ]
        ];
    }

    public function index()
    {
        $cartCookie = \Cookie::get('cartid');

        $cart = Cart::where('cookie', $cartCookie)->orWhere('username', session('username'))->with('items')->with('itemAddons')->get();

        return $cart;
    }

    public function checkDomainAvaliable(Request $request)
    {
        $domain = $request->data['domain'];
        $sapord = new WSSoapShev('order');

        $res = xmlToArray($sapord->callTo('CheckDomainStatus', ['domainName' => $domain]));
        $res2 = array_get($res, 'Body.CheckDomainStatusResponse.CheckDomainStatusResult', []);

        if (strpos($res2, '<Exsist>true</Exsist>') !== false && $domain) {

            $sappv = new WSSoapShev('pageview');

            $xmlstring = $sappv->callTo('GetActiveDomainSpacesFor_A_BPCode', ['BPCode' => session('BPCode')]);
            $dataXml = xmlToArray($xmlstring);
            $domains = array_get($dataXml, 'Body.GetActiveDomainSpacesFor_A_BPCodeResponse.GetActiveDomainSpacesFor_A_BPCodeResult.NewDataSet.Table', []);
            $domainsList = array_column($domains, 'U_DOMAIN_NAME');
            $domainActive = array_column($domains, 'U_Active', 'U_DOMAIN_NAME');

            if(! in_array($domain, $domainsList)) {
                return response()->json(['error' => 'domain not avaliable', 'msg' => 'הדומיין שהזנת תפוס על ידי משתמש אחר']);
            } else {
                if ($domainActive[$domain] !== 'Y') {
                    return response()->json(['error' => 'domain not avaliable', 'msg' => 'הדומיין שהזנת תפוס על ידי משתמש אחר']);
                }
            }
        }

        // if from cart need to save the domain name if from payment do not do that
        // ************************************************************************
        if ($request->data['action'] === 'selectDomain') {
            $cart = Cart::find($request->data['cartId']);
            $cart->domain = $request->data['domain'];
            session(['payfor_domain' => $request->data['domain']]);
            $cart->save();
        }

        return response()->json(['success' => 'ok', 'msg' => '', 'data' => $request->data]);
    }

    public function changeSaveTokenStatus(Request $request)
    {
        $saveToken = $request->data;

        session('saveToken', $saveToken);

        return response()->json(['saveToken' => $saveToken]);
    }

    /**
     * [setSummerize description]
     * @param Request $request [description]
     */
    public function setSummerize(Request $request)
    {
        $data = $request->params;

        session([
            'payfor_type' => $data['payfor_type'],
            'payfor_cartId' => '',
            'payfor_orderId' => $data['orderId'],
            'payfor_iphost' => $data['ipHost'],
            'payfor_total' => number_format($data['total'], 2),
            'payfor_domain' => $data['domain'],
            'payfor_itemId' => $data['ItemCode'],
            'total' => number_format($data['total'], 2),
        ]);

        return $data;
    }
}
