<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Model\Apimessage;
//https://swagger.io/docs/specification/2-0/describing-parameters/
/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="ALAHLIFC API",
 *     version="1.1.0"
 *   )
 * )
 */
class API_Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public static function AuthAPI($type = 'ios', $value = '') {
        $data_ok = 1; // 0;
        if ($type = 'ios' && $value == 'I$&h6#565iOs5ioS#(*I$&h6#565iOs5ioS#(*') {
            $data_ok = 1;
        } elseif ($type = 'android' && $value == 'A$&h6#565aN$DrOiD#(*I$&h6#aN$&*rOiD#(*') {
            $data_ok = 1;
        }
        return $data_ok;
    }

    public static function MessageData($type, $lang = 'ar') {
        $message = Apimessage::get_messageData($type, 'type');
        $col_name = $lang . '_message';
        if (isset($message->$col_name)) {
            $response['StatusCode'] = $message->id;
            $response['Message'] = $message->$col_name;
        } else {
            $response['StatusCode'] = 0;
            $response['Message'] = null;
        }
        $response['data'] = null;
        return $response;
    }

    const SUCCESS_MESSAGE = "Success";
    const ERROR_MESSAGE = "Error";
    const MISSING_FIELD = "Missing Fields";
    const ERROR_LANGUAGE = "Error Language";
    const ERROR_PAGE = "Error Page";
    const ERROR_URL = "Error URL";
    const ERROR_FIELD = "Error Field Data";
    const AUTH_FAIL = "Email or Password incorrect";
    const USERNAME_EXIST = "User Name Already Exist";
    const USERNAME_NOT_EXIST = "User Name Not Exist";
    const USER_NOT_Found = "User Not Found";
    const EMAIL_EXIST = "Email Already Exist";
    const PHONE_EXIST = "Phone Already Exist";
    const EMAIL_NOT_EXIST = "Email Not Exist";
    const NO_DATA_FOUND = "No Data Found";
    const LOGIN_FAIL = "Login Faild";
    const EMAIL_SEND_ERR = "Email Send Error";
    const USER_FOUND = "User Found";
    const PASSWORD_MATCH = "New Password Match Old Password";
    const INVALID_Phone = "Invalid Phone";
    const NOT_SAVED = "Not saved";
    const INVALID_EMAIL = "Invalid Email";
    const EMAIL_SEND_BEFORE = "Email send Before";
    const DELETE_MESSAGE = "Delete Success";
    const NOT_DELETE = "Not delete";
    const NOT_IMAGE = "Not Save Image";
    const PASSWORD_NOT_MATCH = "Password Not Match old Password";
    const Account_CLOSE = "This account closed please communicate with the site management";
    const PASSWORD_WEAK = "Password is weak";
    const NOT_REGISTER = "Not Register";
    const REGISTER_NOT_COMPLETE = "Register Not Complete";
    const REGISTER_SHARE = "Register and Share";
    const REGISTER_NOT_SHARE = "Register and Not Share";
    const NOT_VIDEO = "Not Save Video";
    const INVALID_DATA = "Invalid Data";
    const CART_Not_DATA_FOUND = "No Cart Found";
    const ACCESSTOKEN_NOT_Found = 'No access token Found';
    const ERROR_Payment = "Fail Payment";
    const NOT_MatchNameCART = "Not Match Name Cart";
    const SECTION_NOT_DATA_FOUND = "Section Not Found";
    const NoOWner = "Not Owner";

    private $_status_codes = [
        0 => "Success",
        1 => "Error",
        2 => "Missing Fields",
        3 => "Invalid Email",
        4 => "Error Language",
        5 => "Error Page",
        6 => "Error URL",
        7 => "Error Field Data",
        8 => "Email or Password incorrect",
        9 => "User Name Already Exist",
        10 => "User Name Not Exist",
        11 => "User Not Found",
        12 => "Email Already Exist",
        13 => "Phone Already Exist",
        14 => "Email Not Exist",
        15 => "No Data Found",
        16 => "Login Faild",
        17 => "Email Send Error",
        18 => "User Found",
        19 => "New Password Match Old Password",
        20 => "Invalid Phone",
        21 => "Not saved",
        22 => "Invalid Email",
        23 => "Email send Before",
        24 => "Delete Success",
        25 => "Not delete",
        26 => "Not Save Image",
        27 => "New Password Not Match old Password",
        28 => 'Cart Not Free',
        29 => 'Cart Free',
        30 => "This account closed please communicate with the site management",
        31 => 'Password is weak',
        32 => 'Not course Register',
        33 => 'Register Not Complete',
        34 => 'Register and Share',
        35 => "Register and Not Share",
        37 => 'Not Save Video',
        39 => 'Invalid Data',
        40 => 'No Cart Found',
        41 => 'No access token Found',
        44 => 'Fail Payment',
        46 => 'Not Match Name Cart',
        47 => 'Section Not Found',
        48 => 'Not Owner',
    ];

    protected function responseSuccess($message = '') {
        return $this->response(true, $message);
    }

    protected function responseFail($message = '') {
        return $this->response(false, $message);
    }

    protected function response($status = false, $message = '') {
        return response()->json([
                    'status' => $status,
                    'message' => $message,
        ]);
    }

}
