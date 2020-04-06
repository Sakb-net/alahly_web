<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API_Controller;
use App\User;
use App\Model\Role;
use App\Model\Subscribe;
use Hash;

//use Mail;
//use URL;
class AuthController extends API_Controller {
    /**
     * get data get_country  
     * get method
     * url : http://localhost:8000/api/v1/get_country
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/get_country",
     *   tags={"auth"},
     *   operationId="get_country",
     *   summary="v1/get_country",
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default ar (ar - en)",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function get_country(Request $request) {
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        if ($lang == 'en') {
            $response['data'] = ['key' => 'SA', 'name' => 'SA'];
        } else {
            $response['data'] = ['key' => 'SA', 'name' => 'السعودية']; //country_array();// $country = 'SA'; //AE
        }
        return response()->json($response, 200);
    }

    /**
     * get data get_city  
     * get method
     * url : http://localhost:8000/api/v1/get_city
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/get_city",
     *   tags={"auth"},
     *   operationId="get_city",
     *   summary="v1/get_city",
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default ar (ar - en)",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function get_city(Request $request) {
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $response['data'] = cityName_API(1, $lang);
        return response()->json($response, 200);
    }

    /**
     * insert email & name & password & account gender & address
     * post method
     * url : http://localhost:8000/api/v1/register
     * object of inputs {email:somevalue,$display_name:somevalue,password:somevalue,phone:somevalue,fcm_token:somevalue}
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/register",
     *   tags={"auth"},
     *   operationId="register",
     *   summary="creat new account",
     *   @SWG\Parameter(
     *    name="email",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="password",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="display_name",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="phone",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     *  @SWG\Parameter(
     *    name="country",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),   
     *   @SWG\Parameter(
     *    name="city",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),   
     *   @SWG\Parameter(
     *    name="state",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),  
     *  @SWG\Parameter(
     *    name="reg_site",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),   
     *  @SWG\Parameter(
     *    name="device_id",
     *    in= "formData",
     *    required=false,
     *    type="string",
     *  ),
     *  @SWG\Parameter(
     *    name="fcm_token",
     *    in= "formData",
     *    required=false,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default ar (ar - en)",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function register(Request $request) {
        $input = $request->all();
        $display_name = isset($input['display_name']) ? $input['display_name'] : '';
        $email = isset($input['email']) ? $input['email'] : '';
        $password = isset($input['password']) ? $input['password'] : '';
        $phone = isset($input['phone']) ? $input['phone'] : '';
        $address = isset($input['country']) ? $input['country'] : '';
        $city = isset($input['city']) ? $input['city'] : '';
        $state = isset($input['state']) ? $input['state'] : '';
        $reg_site = isset($input['reg_site']) ? $input['reg_site'] : '';
        $device_id = isset($input['device_id']) ? $input['device_id'] : NULL;
        $fcm_token = isset($input['fcm_token']) ? $input['fcm_token'] : NULL;
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($email == "") {
            $fields['email'] = 'email'; // or user_name
        } else {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $response = API_Controller::MessageData('INVALID_EMAIL', $lang);
                return response()->json($response, 400);
            }
        }
        if ($display_name == "") {
            $fields['display_name'] = 'display_name';
        }
        if ($password == "") {
            $fields['password'] = 'password';
        }
        if ($address == "") {
            $fields['country'] = 'country';
        }
        if ($city == "") {
            $fields['city'] = 'city';
        }
        if ($state == "") {
            $fields['state'] = 'state';
        }
        if ($reg_site == "") {
            $fields['reg_site'] = 'reg_site';
        }
//        if ($device_id == "") {
//            $fields['device_id'] = 'device_id';
//        }
        if ($phone == "") {
            $fields['phone'] = 'phone';
        } else {
            if (!(preg_match("/^([+]?)[0-9]{8,16}$/", $phone))) { //if (!preg_match("/^[00+]{1,2}2\d{11,14}$/", $phone, $matches)) {  // ----->  0010207557338 or +10207557338
                $response = API_Controller::MessageData('INVALID_Phone', $lang);
                return response()->json($response, 400);
            }
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false && $display_name != '' && $password != '' && $phone != '') {
            $user_found = User::whereEmail($email)->first();
            if (isset($user_found->id)) {
                $response = API_Controller::MessageData('EMAIL_EXIST', $lang);
                return response()->json($response, 400);
            } else {
                $user_phone = User::where('phone', $phone)->first();
                if (isset($user_phone->id)) {
                    $response = API_Controller::MessageData('PHONE_EXIST', $lang);
                    return response()->json($response, 400);
                } else {
                    $user_reg = User::addCreate($request, '', $display_name, $email, $password, $phone, $fcm_token, $device_id, $reg_site, $address, $city, $state);
                    if ($user_reg) {
                        $user = User::SelectCoulumUser($user_reg);
                        $user['new_fcm_token'] = $fcm_token;
                        User::SendEmailTOUser($user_reg->id, 'register', '');
                        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                        $response['data'] = $user;
                        return response()->json($response, 200);
                    } else {
                        $response = API_Controller::MessageData('ERROR_MESSAGE', $lang);
                        return response()->json($response, 400);
                    }
                }
            }
        }
    }

    /**
     * retrieve username and password exist or not and return user id and account gender (Facebook / email)
     * post method
     * url : http://localhost:8000/api/v1/login/email
     * object of inputs {email:somevalue ,password:somevalue}
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/login/email",
     *   tags={"auth"},
     *   operationId="loginEmail",
     *   summary="login by email",
     *   @SWG\Parameter(
     *    name="email_user_name",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="password",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="device_id",
     *    in= "formData",
     *    required=false,
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="fcm_token",
     *    in= "formData",
     *    required=false,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default ar (ar - en)",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function loginEmail(Request $request) {
        $input = $request->all();
        $email_user_name = isset($input['email_user_name']) ? $input['email_user_name'] : '';
        $password = isset($input['password']) ? $input['password'] : '';
        $device_id = isset($input['device_id']) ? $input['device_id'] : NULL;
        $fcm_token = isset($input['fcm_token']) ? $input['fcm_token'] : NULL;
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($password == "") {
            $fields['password'] = 'password';
        }
//        if ($device_id == "") {
//            $fields['device_id'] = 'device_id';
//        }
        if ($email_user_name == "") {
            $fields['email_user_name'] = 'email'; // or user_name
        } else {
            if (filter_var($email_user_name, FILTER_VALIDATE_EMAIL) === false) {
                $response = API_Controller::MessageData('INVALID_EMAIL', $lang);
                return response()->json($response, 400);
            }
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        if ((!filter_var($email_user_name, FILTER_VALIDATE_EMAIL) === false || $email_user_name != "") && $password != "") {
            $password_hash = bcrypt($password);
            $data = User::where('email', $email_user_name)->orwhere('name', $email_user_name)->first();   //if (Auth::attempt(array('email' => $email, 'password' => $password)))
            if (!empty($data) && isset($data->password) && isset($data->id)) {
                if (isset($data->is_active) && $data->is_active == 1) {
                    if (Hash::check($password, $password_hash) && Hash::check($password, $data->password)) {
                        //update access_token  auth()->login($user)
                        $access_token = generateRandomToken();
                        $old_fcm_token = $data->fcm_token;
                        $session_user = generateRandomValue();
                        if (empty($fcm_token) && empty($device_id)) {
                            User::updateColumTwo($data->id, 'access_token', $access_token, 'session', $session_user);
                        } elseif (empty($fcm_token) && empty(!$device_id)) {
                            User::updateColumTwo($data->id, 'access_token', $access_token, 'session', $session_user, 'device_id', $device_id);
                        } elseif (!empty($fcm_token) && empty($device_id)) {
                            User::updateColumThree($data->id, 'access_token', $access_token, 'session', $session_user, 'fcm_token', $fcm_token);
                        }
                        $user = User::SelectCoulumUser($data);
                        $user['access_token'] = $access_token;
                        $user['new_fcm_token'] = $fcm_token;
                        $user['old_fcm_token'] = $old_fcm_token;
                        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                        $response['data'] = $user;
                        return response()->json($response, 200);
                    } else {
                        $response = API_Controller::MessageData('AUTH_FAIL', $lang);
                        return response()->json($response, 200);
                    }
                } else {
                    $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                    $response['Message'] = API_Controller::CLOSE_ACCOUNT;
                    return response()->json($response, 400);
                }
            } else {
                $response = API_Controller::MessageData('AUTH_FAIL', $lang);
                return response()->json($response, 200);
            }
        }
    }

    public function loginSocial(Request $request) {
        $input = $request->all();
        $email = isset($input['email']) ? $input['email'] : '';
        $social_id = \Input::get('social_id') ? $input['social_id'] : '';
        $user_name = isset($input['user_name']) ? $input['user_name'] : '';
        $socail_access = \Input::get('socail_access') ? $input['socail_access'] : '';  //socail_accesstoken
        $image = \Input::get('image') ? $input['image'] : '';
        $type_user = \Input::get('type_user') ? $input['type_user'] : '';
        $socail_type = \Input::get('socail_type') ? $input['socail_type'] : '';
        $fcm_token = isset($input['fcm_token']) ? $input['fcm_token'] : NULL;
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($socail_access == "") {
            $fields['socail_access'] = 'socail_access';
        }
        if ($social_id == "") {
            $fields['social_id'] = 'social_id';
        }
        if ($socail_type == "") {
            $fields['socail_type'] = 'socail_type';
        }
        if ($type_user == "") {
            $fields['type_user'] = 'type_user';
        }

        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response);
        }
        $path_image = '';
        if ($image != '') {
            $path_image = uploadImage($image);
            if (empty($path_image)) {
                $response = API_Controller::MessageData('NOT_IMAGE', $lang);
                return response()->json($response);
            }
        }
        if ($socail_access != '' && $social_id != '' && $socail_type != '') {
            $user_found = User::where([['social_id', '=', $social_id], ['type', '=', $socail_type]])->get(['id']);
            if (!$user_found->isEmpty()) {
                $user_img = UsersMeta::where([['user_id', '=', $user_found[0]->id], ['meta_type', '=', 'image_type'], ['meta_key', '=', 'social']])->get(['id']);
                if (!$user_img->isEmpty()) {

                    User::where('id', $user_found[0]->id)->update(['image' => $path_image]);
                }
                User::where('id', $user_found[0]->id)->update(['social_access' => $socail_access]);
                if ($access_token != "") {
                    User::where('id', $user_found[0]->id)->update(['access_token' => $access_token]);
                }
                $user = User::where('id', '=', $user_found[0]->id)->get();
                $response = API_Controller::MessageData('USER_FOUND', $lang);
                $response['data'] = $user;
                return response()->json($response);
            } else {
                $user = new User();
                $user->social_id = $social_id;
                $user->user_name = $user_name;
                $user->social_access = $socail_access;
                $user->image = $path_image;
                $user->access_token = $access_token;
                if ($email == "") {
                    $user->email = $social_id;
                } else {
                    $user->email = $email;
                }
                $user->type = $socail_type;
                $saved = $user->save();
                //add role
                $get_rols = Role::where('name', $type_user)->first();
                $user->assignRoles(array($get_rols->id));
                if ($image != '') {
                    $user_meta = new UsersMeta();
                    $user_meta->user_id = $user->id;
                    $user_meta->meta_type = 'image_type';
                    $user_meta->meta_key = 'social';
                    $user_meta->save();
                }
                $user_reg = User::where([['social_id', '=', $social_id], ['type', '=', $socail_type]])->get();
                if ($saved) {
                    $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                    $response['data'] = $user_reg;
                    return response()->json($response);
                } else {
                    $response = API_Controller::MessageData('NOT_SAVED', $lang);
                    return response()->json($response);
                }
            }
        }
    }

    /**
     * retrieve access_token and return true or false
     * post method
     * url : http://localhost:8000/api/v1/logout
     * object of inputs {access_token:somevalue}
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/logout",
     *   tags={"auth"},
     *   operationId="logout",
     *   summary="logout",
     *   @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default ar (ar - en)",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function logout(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $user = User::user_access_token($access_token, 1);
//        $user = Auth::guard('api')->user();
        if (isset($user->id)) {
            //User logged out
            $user->access_token = null;
            $user->session = null;
            $user->save();
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('USER_NOT_Found', $lang);
            return response()->json($response, 401);
        }
    }

//*******************************************************
    public function sendEmailReminder() {
        $user = User::findOrFail(53);

//        $us=Mail::send('admin.send_email', ['user' => $user], function ($m) use ($user) {
//            $m->from('no-reply@Master.com', 'Your Application');
//            $m->to($user->email, $user->user_name)->subject('Your Reminder!');
//        });



        $us = Mail::send('admin.send_email', ['user' => $user], function ($message) use ($user) {
                    $message->to($user->email, $user->user_name)->subject('Baims dd!');
                });
        print_r($us . 'gg');
        die;
    }

    public function forgetpassword() {
        $fields = [];
        $input = \Input::all();
        $email = \Input::get('email') ? $input['email'] : '';

        if (isset($email) && $email != '') {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $fields['invalid_email'] = API_Controller::INVALID_EMAIL;
            }
            if (!empty($fields)) {
                $response['StatusCode'] = 3;
                $response['Message'] = API_Controller::INVALID_EMAIL;
                return response()->json($response);
            }
            $response = [];
            $user = User::where('email', '=', $email)->get(['id', 'user_name', 'mobile', 'email']);
            if (!$user->isEmpty()) {
                $response['StatusCode'] = 0;
                $current_time = time();

                $data = PasswordReset::where([['email', "=", $email], ['status', '=', 0]])->get();
                if (!$data->isEmpty()) {
                    $create = strtotime($data[0]->created_at);

                    if ($current_time < ($create + (6 * 60 * 60))) {
                        $response['StatusCode'] = 24;
                        $response['Message'] = API_Controller::EMAIL_SEND_BEFORE;
                        return response()->json($response);
                    }
                }
                $token = generateRandomToken();
                $password = new PasswordReset();
                $password->email = $user[0]->email;
                $password->token = $token;
                $password->status = 0;
                $password->created_at = date('Y-m-d H:i:s');
                $save = $password->save();
                if ($save) {
                    $response['StatusCode'] = 0;
                    $response['Message'] = API_Controller::SUCCESS_MESSAGE;
                    $subject = "Reset Password Baims App";
                    $send_email = array(
                        'subject' => $subject,
                    );

                    $link = URL::to('/') . "/resetpassword/$token";
//                    $response['data'] = $link;

                    $contents = "Hello " . $user[0]->user_name . ",
                    To reset your password please follow the link below: $link
                    Thanks! 
                    Baims";

                    $myfile = fopen("../resources/views/admin/send_email.blade.php", "w") or die("Unable to open file!");
                    fwrite($myfile, $contents);
                    fclose($myfile);

                    Mail::send('emails.reset_pass', [$send_email], function ($message) use ($user, $send_email) {
                        $message->to($user[0]->email, $user[0]->user_name)->subject($send_email['subject']);
                    });

                    return response()->json($response);
                } else {
                    $response['StatusCode'] = 21;
                    $response['Message'] = API_Controller::NOT_SAVED;
                    return response()->json($response);
                }
//                $response['data'] = $user;
            } else {
                $response['StatusCode'] = 11;
                $response['Message'] = API_Controller::USER_NOT_Found;
                return response()->json($response);
            }
        } else {
            $fields['email'] = 'email';
            $response['StatusCode'] = 2;
            $response['Message'] = API_Controller::MISSING_FIELD;
            $response['data'] = $fields;
            return response()->json($response);
        }
    }

}
