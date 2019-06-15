<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class MemberAuth {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::guard('api')->check()) {
            return $next($request);
        }
        return redirect()->route('v1.member.login');
    }

}
