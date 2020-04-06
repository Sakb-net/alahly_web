<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use DB;
use Socialite;

//use Auth;
class RegisterController extends SiteController { /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
 */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => 'required|string|max:255',
                    'phone' => 'required|string|max:100',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function MakeConfirmValidat(array $input) {
        $wrong_form = $correct_form = NULL;
        if (strlen($input['password']) >= 8 && strlen($input['password']) <= 100) {
            if ($input['password'] == $input['password_confirmation']) {
                if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL) === false) {
                    //confirm not use email
                    $user_email_id = User::foundUser($input['email'], 'email');
                    if ($user_email_id <= 0) {
                        if (strlen($input['name']) >= 3 && strlen($input['name']) <= 100) {
                            if ($input['name'] == 'master' || $input['name'] == 'ticketmaster') {
                                $input['name'] = $input['name'] . time();
                            }
                            if (!empty($input['city'])) {
                                if (!empty($input['state'])) {
                                    if (preg_match("/^([+]?)[0-9]{8,16}$/", $input['phone'])) {
                                        //confirm not use phone
                                        $user_phone_id = User::foundUser($input['phone'], 'phone');
                                        if ($user_phone_id <= 0) {
                                            //ok register
                                            $wrong_form = NULL;
                                        } else {
                                            $wrong_form = trans('app.phone_number_already_used');
                                        }
                                    } else {
                                        $wrong_form = trans('app.please_phone_correct');
                                    }
                                } else {
                                    $wrong_form = trans('app.please_enter_state');
                                }
                            } else {
                                $wrong_form = trans('app.please_enter_city');
                            }
                        } else {
                            $wrong_form = trans('app.user_name_3_100');
                        }
                    } else {
                        $wrong_form = trans('app.email_already_use');
                    }
                } else {
                    $wrong_form = trans('app.email_not_correct');
                }
            } else {
                $wrong_form = trans('app.enter_password_match');
            }
        } else {
            $wrong_form = trans('app.password_8_100');
        }
        return $wrong_form;
    }

    protected function create(array $data) {
        // $user_active = DB::table('options')->where('option_key', 'user_active')->value('option_value');
        $is_active = 1; // is_numeric($user_active) ? $user_active : 0;
        $display_name = $data['name'];
        $email = $data['email'];
        $user_name = explode('@', $email);
        $type = 'member';
        //add session
        $session_user = generateRandomValue();
        session()->put('session_user', $session_user);
        return User::create([
                    'display_name' => $display_name,
                    'email' => $email,
                    'password' => bcrypt($data['password']),
                    'name' => (str_replace(' ', '_', $user_name[0] . time())), //str_random(8)
                    'phone' => $data['phone'],
                    'image' => generateDefaultImage($display_name),
                    'access_token' => generateRandomToken(),
                    'session' => $session_user,
                    'is_active' => $is_active,
                    'type' => $type,
                    'address' => 'SA',
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'reg_site' => 'site',
        ]);
    }

    protected function addCreate($request, array $input, $user_role = '') {
        if (empty($user_role)) {
            $user_role = DB::table('options')->where('option_key', 'default_role')->value('option_value');
        }
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($input)));
        $user->attachRole($user_role);
        $this->guard()->login($user);
        //add product in table of cart
        $product_cart = session()->get('session_product_cart');
        if (!empty($product_cart)) {
            //add to table cart
            foreach ($product_cart as $k_cart => $v_cart) {
                CartProduct::InsertColums($user['id'], $v_cart, 'product');
            }
            CartProduct::emptySessionproduct_cart();
        }
        //end
        return $user;
    }

    public function register(Request $request) {
        $input = $request->all();
        foreach ($input as $key => $value) {
            $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
        }
        $wrong_form = $correct_form = NULL;
        $wrong_form = $this->MakeConfirmValidat($input);
        if (empty($wrong_form)) {
            $user = $this->addCreate($request, $input);
            User::sessionLang($user['id']);
            //send email
            // $sen_email = User::SendEmailTOUser($user['id'], 'register');
//            return $this->registered($request, $user) ?: redirect(route('home'));
            return $this->registered($request, $user) ?: redirect($this->redirectPath());
        } else {
            return view('auth.register', compact('wrong_form', 'correct_form'));
        }
    }

    //*************************** Login By social (facebook ,twitter , google )***************************************************
    //https://laravel.com/docs/5.6/socialite 
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider) {
        try {
            $socialuser = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect('/');
        }
        //check we have logged provider
        $socialprovider = SocialProvider::where('provider_id', '=', $socialuser->getId())->where('provider', '=', $provider)->first();
        // $socialprovider = SocialProvider::where('provider_id', '=', $socialuser->getId())->first();
        if (!$socialprovider) {
            //create user and provider
            $user = User::firstOrCreate(
                            ['email' => $socialuser->getEmail()], ['user_name' => $socialuser->getName()], ['image' => $socialuser->getAvatar()], ['display_name' => $socialuser->getNickname()]
            );
//            ['mobile' => $socialuser->getPhone()],
            $user->socialproviders()->create(
                    ['provider_id' => $socialuser->getId(), 'provider' => $provider]
            );
            //add role
            $type_user = 'member';
            $get_rols = Role::where('name', $type_user)->first();
            $user->assignRoles(array($get_rols->id));
        } else {
            //get user
            $user = $socialprovider->user;
        }
        auth()->login($user);

        return redirect('/');

        // $user->token;
//        return $user->getEmail();
    }

//**************************** End Login By Social Media**************************************************
}
