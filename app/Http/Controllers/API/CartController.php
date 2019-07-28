<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Http\Soap\WSSoapShev;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartAddons;

Class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::where('cookie', $request->cookie('cartCookie'))->orWhere([['username', '=', session('username')],['username','<>', NULL]])->orderBy('id', 'desc')->with('items', 'itemAddons')->get()->toArray();

        foreach ($cart as $key => $value) {
            foreach ($value['item_addons'] as $key2 => $value2) {
                if (strpos($value2['id'], 'BT') > -1) {
                    $cart[$key]['item_addons'][$key2]['price'] =  number_format(($value2['price'] / 12 / 30 / 24), 5);
                }
            }
        }

        if (isset($cart[0]['id'])) {

            session()->forget([
                'payfor_type',
                'payfor_cartId',
                'payfor_itemId',
                'payfor_total',
                'payfor_domain',
                'payfor_orderId',
                'payfor_iphost',
            ]);

            session([
                'payfor_type' => 'cart',
                'payfor_cartId' => $cart[0]['id'],
                'payfor_itemId' => $cart[0]['item_id'],
                'payfor_total' => $this->calcTotal($cart),
                'payfor_domain' => $cart[0]['domain'],
            ]);
        }

        return $cart;
    }

    public function store(Request $request)
    {
        $restrict = true;

        $cartCookie = $request->cookie('cartCookie');
   
        if ($restrict) {
            $cart = Cart::where('cookie', $cartCookie)->orWhere([['username', '=', session('username')],['username','<>', NULL]])->get()->count();
            
            if ($cart > 30) {
                flash(
                    'מצטערים אבל...',
                    'לא ניתן להוסיף לעגלה יותר ממוצר אחד',
                    'error'
                );
                return redirect('/cart');
            }
        }

        $cart = new Cart;
        $cart->username = session('username');
        $cart->item_id = $request->id;
        
        if(! $cartCookie) {
            $cartCookie = uniqid();
            $cart->cookie = $cartCookie;
            $cart->save();

            return redirect('/wizard?cart=' . $cart->id)->withCookie('cartCookie', $cartCookie, 100000);
        } else {
            $cart->cookie = $cartCookie;
            $cart->save();

            return redirect('/wizard?cart=' . $cart->id);
        }
    }

    /**
     * [destroy description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function destroy(Request $request)
    {
        //$this->authorize('owner', $cart);

        $cart = Cart::find($request->id);
        $cart->delete();

        $addons = CartAddons::where('cart_id', $request->id);
        $addons->delete();

        return 1;
    }

    public function isUserConnected () {
        if (session('signedIn')) {
            return 1;
        } else {
            return 0;
        }
    }

    public function calcTotal($data)
    {
        $total = 0;
        foreach ($data as $value) {
            $total += $value['items']['price'];

            foreach ($value['item_addons'] as $k2 => $value2) {
                if (strpos($value2['id'], 'BT') === false) {
                    $total += $value2['price'] * $value2['pivot']['value'];
                } else {
                    $total += $value2['pivot']['total_hours'] * $value2['price'] * $value2['pivot']['value'];
                }
            }
        }

        return $total;
    }
}
