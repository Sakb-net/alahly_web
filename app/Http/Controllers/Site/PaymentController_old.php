<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Model\UserMeta;
use App\User;
use App\Model\Category;
use App\Model\Post;
use App\Model\Order;
use App\Model\Options;
use Hash;
//use App\Model\Page;
//use App\Model\Message;
//use App\Model\MessageContent;
//use App\Model\MessageUser;
//use DB;
//use Carbon\Carbon;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ClassSiteApi\Class_PaymentController;

class PaymentController extends SiteController {

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

//https://www.hyperpay.com/
    //https://hyperpay.docs.oppwa.com/tutorials/integration-guide

    public function index(Request $request) {
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
                        $array_data['shopperResultUrl'] = route('payment.callback'); // 'https://hyperpay.docs.oppwa.com/tutorials/integration-guide';      
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

    public function callback(Request $request) {
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

    public function callback_old(Request $request) {
        if (isset(Auth::user()->id)) {
            View::share('title', 'ادفع الان');
            View::share('activ_menu', 3);
            //Ex:http://127.0.0.1:9000/payment/callback?id=671ABA08356B3AF4B4EBEC65842BEB31.uat01-vm-tx04&resourcePath=%2Fv1%2Fcheckouts%2F671ABA08356B3AF4B4EBEC65842BEB31.uat01-vm-tx04%2Fpayment
            $checkout_id = $_REQUEST['id'];
            $resourcePath = $_REQUEST['resourcePath'];

            $url = "https://test.oppwa.com" . $resourcePath; //"https://test.oppwa.com/v1/checkouts/{id}/payment";
            $url .= "?entityId=8ac7a4ca6a1c1fa8016a202f416c02bc";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer OGFjN2E0Y2E2YTFjMWZhODAxNmEyMDJlZWVkMTAyYjJ8MnRkdGt6Z0VobQ=='));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            $array_response = json_decode($responseData);
            // print_r($array_response);die;
            //$price_cart = $request->session()->get('price_cart');
            $price_order = $request->session()->get('price_order');
            $session_orders = $request->session()->get('session_order');
            if (empty($session_orders)) {
                $session_orders = [];
            }
            $ok = 0;
            //$code= '000.100.110';
            if (isset($array_response->result->code)) {
                $description = $array_response->result->description;
                if (preg_match("/^(000\.000\.|000\.100\.1|000\.[36])/", $array_response->result->code)) { ///^([+]?)[0-9]{8,16}$/
                    $ok = 1;
                } elseif (preg_match("/^(000\.400\.0[^3]|000\.400\.100)/", $array_response->result->code)) {
                    $ok = 1;
                }
            }
            if ($ok == 1) { //(isset($array_response->risk->score) && $array_response->amount == $price_order && ($array_response->risk->score == 100 || $array_response->risk->score == "100")) {
                //active chair
                $update = Order::All_checkout_UpdatePayment(Auth::user()->id, $checkout_id, $session_orders, 1, 'hyperpay', 'accept');
                $back_color = '#87d667'; //'green';
                $mesage_pay = 'تم الاشتراك والحجز معنا بنجاح نتمنى لك الاستمتاع معنا'; //.' '.$description
            } else {
                $all_carts = $array_order_id = [];
                $total_price_cart = 0;
                $carts = $request->session()->get('session_cart');
                if (empty($carts)) {
                    $carts = [];
                }
                foreach ($session_orders as $key_order => $val_order) {
                    $array_order_id[] = $val_order['id'];
                    $all_carts[] = $val_order;
                    $total_price_cart += Post::totalPrice($val_order['price'], $val_order['discount']);
                }
                foreach ($carts as $key_cart => $val_cart) {
                    if (!in_array($val_cart['id'], $array_order_id)) {
                        $all_carts[] = $val_cart;
                        $total_price_cart += Post::totalPrice($val_cart['price'], $val_cart['discount']);
                    }
                }
                $request->session()->put('session_cart', $all_carts);
                $request->session()->put('price_cart', $total_price_cart);
                $back_color = '#ec4f4f'; //;'red';
                $mesage_pay = 'فشلت عمليت الدفع يرجى التاكد من حسابك و اعادة المحاولة'; //.' '.$description
            }
            $request->session()->put('session_order', '');
            $request->session()->put('price_order', 0);

            $array_data = array('mesage_pay' => $mesage_pay, 'back_color' => $back_color);

            return view('site.payment.callback', $array_data);
        } else {
            return redirect()->route('home');
        }
    }

}
