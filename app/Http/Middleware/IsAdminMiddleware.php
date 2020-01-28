<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class IsAdminMiddleware
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
        if (auth('api')->user()->isAdmin()){
            return $next($request);
        }
        return Response::unAuthorized();
    }
}
