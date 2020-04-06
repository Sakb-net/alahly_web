<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Model\UserMeta;
use App\User;
use App\Model\Order;
use App\Model\Category;
use App\Model\Options;
use Hash;

//use App\Model\Page;
//use App\Model\Message;
//use App\Model\MessageContent;
//use App\Model\MessageUser;
//use DB;
//use Carbon\Carbon;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ClassSiteApi\Class_UserController;
class ProfileController extends SiteController {

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
        //  parent::__construct();
        $this_data = Options::Site_Option();
        $this->site_open = $this_data['site_open'];
        $this->site_title = $this_data['site_title'];
        $this->limit = $this_data['limit'];
        $this->logo_image = $this_data['logo_image'];

//        $this->middleware('auth');
//        $this->middleware(function ($request, $next) {
//            $this->user = auth()->user();
//            return $next($request);
//        });
    }

    //profile
    public function index(Request $request) {
        if (isset(Auth::user()->id)) {
            $array_data = [];
            View::share('title', 'البروفايل');
              View::share('activ_menu', 1);
            $birth_day = NULL;
            
            $get_user = new Class_UserController();
            $orders = $get_user->UserBillSeat(Auth::user()->id,1,1,'accept',0,$this->limit);
            //start cart in session
            //$request->session()->put('session_cart', ''); //to empty session_cart
            $price_cart = $request->session()->get('price_cart');
            if (empty($price_cart)) {
                $price_cart = $request->session()->get('price_order');
                if (empty($price_cart)) {
                    $price_cart = 0.00;
                } else {
                    $request->session()->put('price_cart', $price_cart);
                    $request->session()->put('price_order', 0);
                }
            }
            $carts = $request->session()->get('session_cart');
            if (empty($carts)) {
                $carts = $request->session()->get('session_order');
                if (empty($carts)) {
                    $carts = [];
                } else {
                    $request->session()->put('session_cart', $carts);
                    $request->session()->put('session_order', '');
                }
            }
            $count_cart = count($carts);
            $match_link='';
            //end cart
            $array_data = array('match_link'=>$match_link,'carts' => $carts, 'count_cart' => $count_cart, 'price_cart' => $price_cart, 'orders' => $orders, 'user' => Auth::user(), 'birth_day' => $birth_day);
            return view('site.profile.index', $array_data)->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            return redirect()->route('home');
        }
    }

    //profile store
    public function store(Request $request) {
        $user = Auth::user();
        if (isset($input['submit'])) {
            $this->validate($request, [
                'name' => 'required|max:255|unique:users,name,' . $user->id,
                'email' => 'required|max:255|email|unique:users,email,' . $user->id,
                'phone' => 'max:50',
//            'display_name' => 'required',
            ]);
        } elseif (isset($input['email_pass'])) {
            $this->validate($request, [
                'password' => 'same:confirm-password',
            ]);
        }
        $input = $request->all();
        foreach ($input as $key => $value) {
            $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
        }
        if (isset($input['submit'])) {
            $input['password'] = $user->password;
            $input['display_name'] = $input['name'];
            $input['name'] = $user->name;
            if (empty($input['image'])) {
                $input['image'] = $user->image;
            }
            $update_user = $user->update($input);
//            $data_meta = UserMeta::DataUserMetaValue(Auth::user()->id, 'data', 'meta_value');
//            $input['stateSend'] = $data_meta['stateSend'];
//            $array_meta = array('birth_day' => $input['birth_day'], 'stateSend' => $input['stateSend'],
//                'social' => ['facebook' => $input['facebook'], 'twitter' => $input['twitter'],
//                    'instagram' => $input['instagram'], 'youtube' => $input['youtube']]);
//            $meta_value = json_encode($array_meta);
//            $meta = new UserMeta();
//            $meta->updateMeta($user->id, $meta_value);
            session()->put('correct_form', trans('app.save_success'));
        }
        if (isset($input['email_pass'])) {
            if ($input['password'] == $input['password_confirmation']) {
                $password_hash = Hash::make($input['user_pass']);  //bcrypt($input['user_pass']);
                if (Hash::check($input['user_pass'], $password_hash) && Hash::check($input['user_pass'], $user->password)) {
                    $new_password = Hash::make($input['password']);  //bcrypt($input['password']);
                    User::where('id', $user->id)->update(['password' => $new_password]);
                    session()->put('correct', trans('app.Data_change_success'));
                } else {
                    session()->put('wrong', trans('app.please_verify_email_password'));
                }
            } else {
                session()->put('wrong', trans('app.enter_password_match'));
            }
            session()->put('correct', trans('app.save_success'));
        }
        return redirect()->route('profile.index'); //->with('success', 'Successfully Saved');
    }

}
