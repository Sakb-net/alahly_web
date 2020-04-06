<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
use App\Http\Controllers\ClassSiteApi\Class_UserController;
use App\User;
use App\Model\Watche;
use Hash;

class UserController extends API_Controller {
    /**
     * get data profile by access_token
     * get method
     * url : http://localhost:8000/api/v1/profile
     *
     * @return response Json
     */

    /**
     * @SWG\Get(
     *   path="/profile",
     *   tags={"profile"},
     *   summary="get profile of current user",
     *   operationId="profile",
     *   @SWG\Parameter(
     *     name="access-token",
     *     in="header",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     */
    public function profile(Request $request) {
        $fields = [];
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $lang = 'ar';
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $data_user = User::user_access_token($access_token, 1);
        if (isset($data_user->id)) {
            $user = User::SelectCoulumUser($data_user);
            $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
            $response['data'] = $user;
//            $get_user = new Class_UserController();
//            $response['count_user'] = $get_user->DataUser($data_user, 'Profile', 1, 1);
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('USER_NOT_Found', $lang);
            return response()->json($response, 401);
        }
    }

    /**
     * update email  & phone & display_name & gender & image & address &fcm_token
     * post method
     * url : http://localhost:8000/api/v1/update_profile
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/update_profile",
     *   tags={"profile"},
     *   operationId="update profile current user",
     *   summary="v1/update_profile",
     *   @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="email",
     *    in= "formData",
     *    type="string",
     *  ),
     *  @SWG\Parameter(
     *    name="display_name",
     *    in= "formData",
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="phone",
     *    in= "formData",
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="image",
     *    in= "formData",
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="country",
     *    in= "formData",
     *    type="string",
     *  ),   
     *   @SWG\Parameter(
     *    name="city",
     *    in= "formData",
     *    type="string",
     *  ),   
     *   @SWG\Parameter(
     *    name="state",
     *    in= "formData",
     *    type="string",
     *  ),   
     *   @SWG\Parameter(
     *    name="gender",
     *    in= "formData",
     *    type="string",
     *  ),   
     *   @SWG\Parameter(
     *    name="fcm_token",
     *    in= "formData",
     *    type="string",
     *  ),   
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *    
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function update_profile(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $display_name = isset($input['display_name']) ? $input['display_name'] : '';
        $email = isset($input['email']) ? $input['email'] : '';
        $phone = isset($input['phone']) ? $input['phone'] : '';
        $path_image = isset($input['image']) ? $input['image'] : '';
        $address = isset($input['country']) ? $input['country'] : '';
        $city = isset($input['city']) ? $input['city'] : '';
        $state = isset($input['state']) ? $input['state'] : '';
        $gender = isset($input['gender']) ? $input['gender'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $fcm_token = isset($input['fcm_token']) ? $input['fcm_token'] : NULL;
        $state_fcm_token = isset($input['state_fcm_token']) ? $input['state_fcm_token'] : -1;

        //print_r('image');die;
        $response = [];
        $fields = [];
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if (!empty($email)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $response = API_Controller::MessageData('INVALID_EMAIL', $lang);
                return response()->json($response, 400);
            }
        }
        if (!empty($phone)) {
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
//        if (!empty($image)) {
//            $path_image = PathuploadImage($image);
//            if (empty($path_image)) {
//                $response = API_Controller::MessageData('NOT_IMAGE', $lang);
//                return response()->json($response, 400);
//            }
//        }
        // && $password != ''
//        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false && $display_name != '' && $phone != '') {
        $user = User::user_access_token($access_token, 1);
        if (isset($user->id)) {
            if (!empty($email)) {
                if ($user->email != $email) {
                    $user_found = User::whereEmail($email)->first();
                    if (isset($user_found->id)) {
                        $response = API_Controller::MessageData('EMAIL_EXIST', $lang);
                        return response()->json($response, 400);
                    } else {
                        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                            $response = API_Controller::MessageData('INVALID_EMAIL', $lang);
                            return response()->json($response, 400);
                        }
                    }
                }
                $user->email = $email;
            }
            if (!empty($phone)) {
                if ($user->phone != $phone) {
                    $user_phone = User::where('phone', $phone)->first();
                    if (isset($user_phone->id)) {
                        $response = API_Controller::MessageData('PHONE_EXIST', $lang);
                        return response()->json($response, 400);
                    } else {
                        if (!(preg_match("/^([+]?)[0-9]{8,16}$/", $phone))) { //if (!preg_match("/^[00+]{1,2}2\d{11,14}$/", $phone, $matches)) {  // ----->  0010207557338 or +10207557338
                            $response = API_Controller::MessageData('INVALID_Phone', $lang);
                            return response()->json($response, 400);
                        }
                    }
                }
                $user->phone = $phone;
            }
            if (!empty($display_name)) {
                $user->display_name = $display_name;
            } else {
                $display_name = $user->display_name;
            }
            if (!empty($path_image)) {
                $user->image = $path_image;
            } else {
                if (empty($user->image) && empty($path_image)) {
                    $user->image = generateDefaultImage($display_name);
                }
            }
            if (!empty($address)) {
                $user->address = $address;
            }
            if (!empty($city)) {
                $user->city = $city;
            }
            if (!empty($state)) {
                $user->state = $state;
            }
            if (!empty($gender)) {
                $user->gender = $gender;
            }
            if (!empty($fcm_token)) {
                $user->fcm_token = $fcm_token;
            }
//                if ($state_fcm_token == 0 || $state_fcm_token == 1) {
//                    $user->state_fcm_token = $state_fcm_token;
//                }
            $save = $user->save();
            if ($save) {
                $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                $response['data'] = User::SelectCoulumUser($user);
                return response()->json($response, 200);
            } else {
                $response = API_Controller::MessageData('ERROR_MESSAGE', $lang);
                return response()->json($response, 400);
            }
        } else {
            $response = API_Controller::MessageData('USER_NOT_Found', $lang);
            return response()->json($response, 401);
        }
//        } else {
//                $response = API_Controller::MessageData('INVALID_DATA', $lang);
//            return response()->json($response, 400);
//        }
    }

    /**
     * @SWG\Post(
     *   path="/mybill",
     *   tags={"profile"},
     *   operationId="mybill",
     *   summary="get bill of current user",
     *   @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
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
    public function mybill(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $data_user = User::user_access_token($access_token, 1);
        if (isset($data_user->id)) {
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $get_user = new Class_UserController();
            $bills = $get_user->UserBillSeat($data_user->id, 1, 1, 'accept', 1);
            $response['data'] = $get_user->get_DataBill($data_user->id, $bills, 'mybill', 1);
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('USER_NOT_Found', $lang);
            return response()->json($response, 401);
        }
    }

    /**
     * update fcm token access_token,fcm_token and return true and user date or false
     * post method
     * url : http://localhost:8000/api/v1/update_fcmtoken
     * object of inputs {access_token:somevalue,fcm_token:somevalue}
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/update_fcmtoken",
     *   tags={"profile"},
     *   operationId="update_fcmtoken",
     *   summary=" update fcmtoken for firebase",
     *   @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="fcm_token",
     *    in= "formData",
     *    required=true,
     *    type="string",
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
    public function update_fcmtoken(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $fcm_token = isset($input['fcm_token']) ? $input['fcm_token'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if ($fcm_token == "") {
            $fields['fcm_token'] = 'fcm_token';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                User::where('id', $data_user->id)->update(['state_fcm_token' => 1, 'fcm_token' => $fcm_token]);
                $user = User::SelectCoulumUser($data_user);
                $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                $response['data'] = $user;
                return response()->json($response, 200);
            } else {
                $response = API_Controller::MessageData('USER_NOT_Found', $lang);
                return response()->json($response, 401);
            }
        } else {
            $response = API_Controller::MessageData('ACCESSTOKEN_NOT_Found', $lang);
            return response()->json($response, 401);
        }
    }

    /**
     * retrieve access_token,new_password,old_password and return true and user date or false
     * post method
     * url : http://localhost:8000/api/v1/change_password
     * object of inputs {access_token:somevalue,new_password:somevalue,old_password:somevalue}
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/change_password",
     *   tags={"profile"},
     *   operationId="change_password",
     *   summary="change password",
     *   @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="new_password",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="old_password",
     *    in= "formData",
     *    required=true,
     *    type="string",
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
    public function change_password(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $new_password = isset($input['new_password']) ? $input['new_password'] : '';
        $old_password = isset($input['old_password']) ? $input['old_password'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if ($new_password == "") {
            $fields['new_password'] = 'new_password';
        }
        if ($old_password == "") {
            $fields['old_password'] = 'old_password';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        if ($access_token != "" && $old_password != "" && $new_password != "") {
            $password_hash = bcrypt($old_password);
            $data = User::user_access_token($access_token, 1);
            if (!empty($data) && isset($data->password) && isset($data->id)) {
                if (Hash::check($old_password, $password_hash) && Hash::check($old_password, $data->password)) {
                    //update new_password  
                    $new_password = bcrypt($new_password);
                    User::where('id', $data->id)->update(['password' => $new_password]);
                    $user = User::SelectCoulumUser($data);
                    $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                    $response['data'] = $user;
                    return response()->json($response, 200);
                } else {
                    $response = API_Controller::MessageData('PASSWORD_NOT_MATCH', $lang);
                    return response()->json($response, 400);
                }
            } else {
                $response = API_Controller::MessageData('USER_NOT_Found', $lang);
                return response()->json($response, 401);
            }
        }
    }

}
