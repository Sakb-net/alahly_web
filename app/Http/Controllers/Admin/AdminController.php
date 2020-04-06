<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;

class AdminController extends Controller
{
    protected $user;
    protected $limit;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $limit_view = DB::table('options')->where('option_key', 'table_limit')->value('option_value');
        $limit = is_numeric($limit_view) ? $limit_view : 50;
        $this->limit= $limit;
        $this->middleware('admin');
        $this->middleware(function ($request, $next) {
        $this->user = auth()->user();
        return $next($request);
    });
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    
    public function pageError()
    {
       return view('admin.errors.404');
    }
    
    public function pageUnauthorized()
    {
       return view('admin.errors.unauthorized');
    }
    
}
