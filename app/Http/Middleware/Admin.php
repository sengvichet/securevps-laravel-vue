<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class Admin
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        if (! session('admin_signedIn')) {

            flash(
                'אין כניסה',
                'הכניסה לחלק זה של האתר מורשית למנהלים רשומים בלבד, במידה והינך משתמש רשום אנא היכנס לחשבונך',
                'warning'
            );
            return redirect('/admin/login');
        }

        return $next($request);
    }
}
