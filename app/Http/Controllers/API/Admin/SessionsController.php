<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\LoggedSessions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

Class SessionsController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return response()->json(LoggedSessions::all());
    }

    public function trancate(Request $request)
    {
        //delete all sessions write now
        dd(LoggedSessions::truncate());
        return LoggedSessions::truncate();
    }

    public function delete(Request $request)
    {
        return LoggedSessions::destroy($request->id);
    }
}
