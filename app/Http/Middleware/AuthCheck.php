<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if( !session()->has('LOGGED_ADMIN') ){
            return redirect('login')->with('fail', 'Morate biti ulogovani, da bi ste pristupili profilu ...');
        }
        return $next($request);
    }
}
