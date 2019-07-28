<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

Class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function domainSpaces()
    {
        return view('website.admin.domain-spaces');
    }

    public function items()
    {
        return view('website.admin.items');
    }

    public function localUsers()
    {
        return view('website.admin.local-users');
    }

    public function orders()
    {
        return view('website.admin.orders');
    }

    public function sessions()
    {
        return view('website.admin.sessions');
    }

    public function users()
    {
        return view('website.admin.users');
    }
}
