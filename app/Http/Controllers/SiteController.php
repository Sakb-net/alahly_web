<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Options;
//use App\Model\Language;
use Auth;

class SiteController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
//    const SUCCESS_MESSAGE = "Success";

    protected $limit;
    protected $site_title;
    protected $site_url;
    protected $site_open;
    protected $current_id;
    protected $user_key;
    protected $user_email;
    protected $lang;
    protected $admin_panel;

    public function __construct() {
        $data_site = Options::Site_Option();
        $this->limit = $data_site['limit'];
        $this->site_title = $data_site['site_title'];
        $this->site_url = $data_site['site_url'];
        $this->site_open = $data_site['site_open'];
        $this->current_id = $data_site['current_id'];
        $this->user_key = $data_site['user_key'];
        $this->user_email = $data_site['user_email'];
        $this->lang = $data_site['lang'];
        $this->middleware('site.open', ['except' => ['close']]);
        $this->middleware(function ($request, $next) {
            $user_account = Auth::user();
            if (!empty($user_account)) {
                $this->current_id = $user_account->id;
                $this->user_key = $user_account->name;
                $this->user_email = $user_account->email;
                if ($user_account->can(['access-all', 'post-type-all', 'post-all'])) {
                    $this->admin_panel = 1;
                }
                $get_session = session()->get('session_user');
                if ($user_account->is_active == 0 || $user_account->session != $get_session) {
                    Auth::logout();
                    return redirect(route('home'));
                }
            }
            return $next($request);
        });
    }

    public function close() {
        $message_close = trans('app.we_happy');
        $msgmain_close = trans('app.site_under');
        $logo_image = asset('images/icon/logo-white.svg');
        $array_option_key = ['msgmain_close', 'message_close', 'logo_image'];
        $All_options = Options::get_Option('setting', $array_option_key, 1);
        foreach ($All_options as $key => $value) {
            $$key = $value;
        }
        $close_image = $close_goal = null;
        return view('close', compact('message_close', 'msgmain_close', 'close_goal', 'close_image', 'logo_image'));
    }

}
