<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class AdminPrivilegies
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
        
        // 1. logout with error message/redirect to login
        
        // 2. redirect to welcome page with error message
        
        
        if(auth()->check()){
            
            if(auth()->user()->role != User::ADMINISTRATOR){
                // 3. abort - status code 'Unauthorized request'
                abort(403, 'Unauthorized action.');
            }
            
            
        } else {
            // 3. abort - status code 'Unauthorized request'
            abort(403, 'Unauthorized action.');
        }
        
        return $next($request);
    }
}
