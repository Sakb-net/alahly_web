<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests\ContactFormRequest;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use App\Model\Options;
use App\Model\Match;
//use App\Model\Category;
//use App\Model\Post;
//use App\Model\Contact;
use Auth;
use Mail;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ClassSiteApi\Class_MasterController;
use App\Http\Controllers\ClassSiteApi\Class_PaymentController;

class TicketController extends SiteController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        // parent::__construct();
        $this_data = Options::Site_Option();
        $this->site_open = $this_data['site_open'];
        $this->site_title = $this_data['site_title'];
        $this->limit = $this_data['limit'];
        $this->logo_image = $this_data['logo_image'];
        $this->current_id = $this_data['current_id'];
//        $this->middleware('auth');
//        $this->middleware(function ($request, $next) {
//            $this->user = auth()->user();
//            return $next($request);
//        });
    }

    //tickets match
    public function index_match(Request $request, $match_link) {
//        $request->session()->put('session_cart', '');
//        $request->session()->put('session_order', '');
//        $request->session()->put('price_order', 0);
//        $request->session()->put('price_cart', 0);
        if ($this->site_open == 1 || $this->site_open == "1") {
            if (isset(Auth::user()->id)) {
                $match = Match::get_matchLink('link', $match_link, 1);
                if (isset($match->id)) {
                    $match = Match::get_MatchSingle($match);
                    $state_booking = Match::get_StateBooking($match);
                    $ok_booking = $state_booking['ok_booking'];
                    $msg_booking = $state_booking['msg_booking'];
                    $logo_image = $this->logo_image;
                    $title = "حجز التذاكر" . " - " . $this->site_title;
                    $user_key = $this->user_key;
                    $posts = [];
                    $get_data = new Class_MasterController();
                    $data = $get_data->DrawMaster('section', 0, 0);
                    View::share('title', $title);
                    View::share('activ_menu', 3);
                    return view('site.tickets.index', compact('logo_image', 'match', 'msg_booking', 'ok_booking', 'match_link', 'user_key', 'data', 'posts'));
                } else {
                    return redirect()->route('home');
                }
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('close');
        }
    }

//********************payment Ticket**************************
//https://www.hyperpay.com/
    //https://hyperpay.docs.oppwa.com/tutorials/integration-guide

    public function checkoutTicket(Request $request) {
        if (isset(Auth::user()->id)) {
            $array_data = [];
            View::share('title', 'ادفع الان');
            View::share('activ_menu', 3);
            //************
            $total_price_cart = $request->session()->get('price_cart');
            $carts = $request->session()->get('session_cart');
            if (empty($carts)) {
                $carts = [];
            }
            $array_data['match_link'] = '';
            $get_data = new Class_PaymentController();
            $array_check_cart = $get_data->get_cart(Auth::user()->id, $carts, 3, 1);
            if (!empty($total_price_cart) && $total_price_cart > 0) {
                if (empty($array_check_cart['not_available'])) {
                    $array_data = $get_data->Paymenthyperpay_Seat(Auth::user(), $carts, $total_price_cart, 0);
                    if (isset($array_data['ok_chechout']) && $array_data['ok_chechout'] == 1) {
                        //start cart in session
                        $request->session()->put('session_cart', '');
                        $request->session()->put('session_order', $carts);
                        $request->session()->put('price_cart', 0);
                        $request->session()->put('price_order', $total_price_cart);
                        $array_data['shopperResultUrl'] = route('tickets.callback.match'); // 'https://hyperpay.docs.oppwa.com/tutorials/integration-guide';      
                        return view('site.payment.index', $array_data);
                    } else {
                        $array_data = $get_data->Message_failPay($request, 5, 0);
                        return view('site.payment.callback', $array_data);
                    }
                } else {
                    $array_data = $get_data->Message_failPay($request, 3, 0);
                    return view('site.payment.callback', $array_data);
                }
            } else {
                $array_data = $get_data->Message_failPay($request, 4, 0);
                return view('site.payment.callback', $array_data);
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function paymentcallback(Request $request) {
        if (isset(Auth::user()->id)) {
            View::share('title', 'ادفع الان');
            View::share('activ_menu', 3);
            //Ex:http://127.0.0.1:9000/payment/callback?id=671ABA08356B3AF4B4EBEC65842BEB31.uat01-vm-tx04&resourcePath=%2Fv1%2Fcheckouts%2F671ABA08356B3AF4B4EBEC65842BEB31.uat01-vm-tx04%2Fpayment
            $checkout_id = $_REQUEST['id'];
            $resourcePath = $_REQUEST['resourcePath'];
            //$price_cart = $request->session()->get('price_cart');
            $price_order = $request->session()->get('price_order');
            $session_orders = $request->session()->get('session_order');
            if (empty($session_orders)) {
                $session_orders = [];
            }
            $array_data['match_link'] = '';
            $get_data = new Class_PaymentController();
            $array_data = $get_data->payment_CallBack($request, Auth::user(), $checkout_id, $resourcePath, $session_orders, $price_order, 0);
            return view('site.payment.callback', $array_data);
        } else {
            return redirect()->route('home');
        }
    }

//**************************not use **************************
    //tickets
    public function index(Request $request) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            if (isset(Auth::user()->id)) {
                $logo_image = $this->logo_image;
                $title = "حجز التذاكر" . " - " . $this->site_title;
                $user_key = $this->user_key;
                $posts = [];
                $get_data = new Class_MasterController();
                $data = $get_data->DrawMaster('section', 0, 0);
                View::share('title', $title);
                View::share('activ_menu', 3);
                return view('site.tickets.index', compact('logo_image', 'user_key', 'data', 'posts'));
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('close');
        }
    }

}
