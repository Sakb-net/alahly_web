<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate;

class AuthSite extends Authenticate {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
//    public function handle($request, Closure $next)
//    {
//        return $next($request);
//    }

    public function handle($request, Closure $next, ...$guards) {
dd(Auth::user());
        if (Auth::guard($guards)->check()) {
            $user = auth()->user();
            
            return $next($request);
        } else {
            return redirect()->route('login');
        }
    }

}
