<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // //var_dump(\session('signedIn'));
        // view()->share('signedIn', $signedIn);
        // view()->share('username', session('username'));
        // view()->share('firstName', session('firstName'));
        // view()->share('lastName', session('lastName'));

        //php artisan migrate:refresh
        //return response(['message' => 'No way.'], 403); //ajax mode json
    }
}
