<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\ItemProps;

class PagesController extends Controller
{
    public function index()
    {
     return view('website/index');
    }

    public function cart()
    {
        if (! session('signedIn')) {
            session(['redirectAfterLogin' => '/cart']);
        }

        return view('website.cart.index', ['login' => session('username')]);
    }

    public function wizard(Request $request)
    {
        return view('website.wizard.index', ['cartid' => $request->cart]);
    }

    public function aboutUs()
    {
        return view('website/about-us');
    }

    public function faq()
    {
        return view('website/faq');
    }

    public function servers()
    {
        return view('website/servers');
    }

    public function amazonGoogleCloud()
    {
        return view('website/amazon-google-cloud');
    }

    public function ssl()
    {
        return view('website/ssl');
    }

   public function ips()
   {
        return view('website/ips');
   }

    public function controlPanel()
    {
        return view('website/control-panel');
    }

    public function policy()
    {
        return view('website/policy');
    }

    public function shared()
    {
        $sharedList = Items::catalogShared();
      
        // dd($sharedList);
        return view('website/shared', ['sharedList' => $sharedList]);
    }

    public function vps()
    {
        $vpsList = Items::with('itemProps')
            ->whereHas('itemProps')
            ->where('item_type', 'VPS-Package')
            ->get();
        $itemTypes = [];
        foreach($vpsList as $vps) {

            $item_types_array = $vps->itemProps;

            $item_types_unique_name_array = array(); // distinct by name

            foreach($item_types_array as $item_type) {

                if(! in_array($item_type['name'], $item_types_unique_name_array)) {
                    array_push($item_types_unique_name_array, $item_type['name']);
                } else {
                    continue;
                }
            }

            $item_types_unique_array = [];

            foreach($item_types_unique_name_array as $item_type_name) {

                $item_type = json_decode(ItemProps::where(['name' => $item_type_name, 'item_id' => $vps->id])->orderBy('updated_at', 'desc')->first());

                array_push($item_types_unique_array, $item_type);
            }

            array_push($itemTypes, $item_types_unique_array);
        }

        return view('website/vps', ['vpsList' => $vpsList, 'itemTypes' => $itemTypes]);
    }

    public function contact()
    {
        return view('website/contact');
    }

    public function terms()
    {
        $text = \App\Models\LanguagesTerms::first();
        return view('website/terms', ['text' => $text->hebrew]);
    }

    public function domains()
    {
        return view('website/domains');
    }

    public function blog()
    {
        return view('website/blog');
    }

    public function support()
    {
        return view('website/support');
    }

    public function order()
    {
        return view('website/order-slider');
    }

    public function cookiePolicy()
    {
        return view('website/cookie-policy');
    }

    public function getSessionResult(){
        if(\Session::has('username')){
            return 1;
        }else {
            return 0;
        }
    }
}
