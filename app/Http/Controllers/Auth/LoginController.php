<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\SiteController;
use Session;
use App\Model\CartProduct;

class LoginController extends SiteController {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    private function checkActive() {
        $state = 1;
        if (!empty(Auth::user())) {
            if (!Auth::user()->is_active == 1) {
//            if (!Auth::user()->isActive()) {
                Auth::logout();
                $state = 0;
            } else {
                //add product in table of cart
                $product_cart = session()->get('session_product_cart');
                if (!empty($product_cart)) {
                    //add to table cart
                    foreach ($product_cart as $k_cart => $v_cart) {
                        CartProduct::InsertColums(Auth::user()->id, $v_cart, 'product');
                    }
                    CartProduct::emptySessionproduct_cart();
                }
                //add session
                $session_user = generateRandomValue();
                $access_token = generateRandomToken();
                session()->put('session_user', $session_user);
                Auth::user()->updateColumTwo(Auth::user()->id, 'access_token', $access_token, 'session', $session_user);
                Auth::user()->sessionLang(Auth::user()->id);
                $state = 1;
            }
        } else {
            $state = -1;
        }
        return $state;
    }

    private function sendLoginResponseNotActive(Request $request, $is_active = 0) {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        if ($is_active == -1) {
            $wrong_form = trans('app.name_or_password_not_correct');
        } else {
//        $wrong_form = '<a href="' . route('contact') . '"> trans('app.account_disabled_site')</a>';
            $wrong_form = trans('app.account_disabled_site');
        }
        session()->put('wrong_form_login', $wrong_form);
        return $this->authenticated($request, $this->guard()->user()) ?: redirect()->route('login');
    }

    protected function sendLoginResponseActive(Request $request) {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        $get_session = session()->get('session_url');
        if (empty($get_session) || $get_session == '/') {
            $get_session = route('home');
        }
        return $this->authenticated($request, $this->guard()->user()) ?: redirect($get_session);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request) {
        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            $is_active = $this->checkActive();
            if ($is_active == 1) {
                return $this->sendLoginResponseActive($request);
//                return $this->sendLoginResponse($request);
            } else {
                return $this->sendLoginResponseNotActive($request, $is_active);
            }
        } else {
            return $this->sendLoginResponseNotActive($request, -1);
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

//****************************
    public function logout(Request $request) {
        if (isset(Auth::user()->id)) {
            Auth::user()->updateColumTwo(Auth::user()->id, 'access_token', null, 'session', null);
            Auth::logout();
        }
        return redirect(route('home'));
    }

    //****************************

    public function cvlogin(Request $request) {
        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            $is_active = $this->checkActive();
            if ($is_active == 1) {
                return $this->sendLoginResponseActive($request);
//                return $this->sendLoginResponse($request);
            } else {
                return $this->sendLoginResponseNotActive($request, $is_active);
            }
        } else {
            return $this->sendLoginResponseNotActive($request, -1);
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

//public function authenticated($request, $user) {
//    
//}
}
