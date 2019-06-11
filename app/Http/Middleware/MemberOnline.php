<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use Carbon\Carbon;
use Auth;
class MemberOnline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
           if (Auth::guard('member')->check()) {
            $expiresAt = Carbon::now()->addMinute(1);
            Cache::put('member-is-online-' . Auth::guard('member')->user()->id, true, $expiresAt);
           }
        return $next($request);
    }
}
