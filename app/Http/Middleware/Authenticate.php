<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class Authenticate
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
        if (! session('signedIn')) {

            flash(
                'אין כניסה',
                'הכניסה לחלק זה של האתר מורשית למשתמשים רשומים בלבד, במידה והינך משתמש רשום אנא היכנס לחשבונך',
                'warning'
            );
            return redirect('/login');
        }

        return $next($request);
    }
}
