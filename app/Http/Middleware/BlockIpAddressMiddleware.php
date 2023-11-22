<?php

namespace App\Http\Middleware;

use Closure;
use App\Ip;

class BlockIpAddressMiddleware
{
    public $whitelist = [];
    
    public function __construct()
    {
        $this->whitelist = Ip::pluck('ip')->all(); 
    }

    public function handle($request, Closure $next)
    {
        if(!in_array($request->getClientIp(), $this->whitelist)) {
            abort(403, "You are restricted to access.");
        }
        return $next($request);
    }
}