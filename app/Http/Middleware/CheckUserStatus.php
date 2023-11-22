<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserStatus
{
    public function handle($request, Closure $next)
    {
        if( auth('web')->user()->status == "I" ) {
            return redirect()->route('user.inativo');
        }

        return $next($request);
    }
}
