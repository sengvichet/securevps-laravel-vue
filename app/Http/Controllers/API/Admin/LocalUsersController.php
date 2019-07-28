<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocalUsersController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        return response()->json(User::all());
    }

    public function trancate(Request $request)
    {
        return User::truncate();
    }

    # TODO transform to rest names

    public function delete(Request $request)
    {
        return User::destroy($request->id);
    }
}
