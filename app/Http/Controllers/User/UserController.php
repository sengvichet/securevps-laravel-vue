<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Class UserController extends Controller
{
    /**
     * [domainSpaces description]
     * @return [type] [description]
     */
    public function domainSpaces()
    {
        return view('website.user.domain-spaces');
    }

    /**
     * [invoices description]
     * @return [type] [description]
     */
    public function invoices()
    {
        return view('website.user.invoices');
    }

    /**
     * [receipts description]
     * @return [type] [description]
     */
    public function receipts()
    {
        return view('website.user.receipts');
    }

    /**
     * [receipts description]
     * @return [type] [description]
     */
    public function creditCard()
    {
        return view('website.user.credit-card');
    }

    public function removeCard(Request $request)
    {
        print_r($request->all());
        die;

    }
}
