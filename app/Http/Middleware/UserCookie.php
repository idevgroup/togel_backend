<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserCookie {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        if ($request->hasCookie('cookie_user')) {
            return $next($request);
        }
        if (Auth::check()) {
            $response = $next($request);
            return $response->withCookie(cookie()->forever('cookie_user', Auth::user()->name));
        }
    }

}
