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
           if (Auth::guard('api')->check()) {
            $expiresAt = Carbon::now()->addMinute(1);
            Cache::put('member-is-online-' . Auth::guard('api')->user()->id, true, $expiresAt);
           }
        return $next($request);
    }
}
