<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Support\Facades\Auth;

class SiteOpen
{
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
    
     public function handle($request, Closure $next, $guard = null) {
        
        
        if (Auth::guard($guard)->check()) {
            $user = auth()->user();
            $site_open = DB::table('options')->where('option_key', 'site_open')->value('option_value');
            if (!$user->can(['access-all','category*', 'user*', 'message*', 'post-type-all','post-all','comment-all','admin-panel']) && $site_open == 0) {
                return redirect()->route('close');
            }
            return $next($request);
        } else {
            $site_open = DB::table('options')->where('option_key', 'site_open')->value('option_value');
            if ($site_open == 0) {
                return redirect()->route('close');
            }
            return $next($request);
        }
    }
}
