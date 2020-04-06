<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate;

class AdminPanel extends Authenticate {

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

        if (Auth::guard($guards)->check()) {
            $user = auth()->user();
            if (!$user->can(['access-all', 'category*', 'user*', 'message*', 'post-type-all', 'post-all', 'comment-all', 'admin-panel'])) {
                return redirect()->route('home');
            }

            return $next($request);
        } else {
            return redirect()->route('admin.login');
        }
    }

}
