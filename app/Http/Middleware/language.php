<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;
use Auth;

class language {

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


    public function handle($request, Closure $next) {
//            $locale = Session::get('locale', Config::get('app.locale'));
        $locale = 'ar';
        if (Auth::user()) {
            $locale = Auth::user()->lang;
        } elseif ($locale = Session::has('locale')) {
            $locale = Session::get('locale');
        } else {
            $locale = Config::get('app.locale');
        }

        App::setLocale($locale);
        return $next($request);
    }

}
