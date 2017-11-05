<?php

namespace App\Http\Middleware;

use Closure;

class EncryptMiddleware
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
        $response = $next($request);

        // Perform action
        $IF_ENCRYPT = $request->get('IF_ENCRYPT',false);
        if($IF_ENCRYPT){
            //加密
        }
        return $response;
    }
}
