<?php

namespace Milano\User\Http\Middleware;

use Closure;

class StoreUserIp
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->ip != $request->ip()) {
            auth()->user()->ip = $request->ip();
            auth()->user()->save();
        }
        return $next($request);
    }
}
