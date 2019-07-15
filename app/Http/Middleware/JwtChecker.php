<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\ApiException;

class JwtChecker
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
        if(!auth()->check()){
            throw new ApiException("Token Expired, Missing or Blacklisted", 401);
        }
        
        return $next($request);
    }
}
