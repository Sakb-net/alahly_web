<?php

namespace App\Http\Controllers\Api\V1;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
use App\Http\Controllers\ClassSiteApi\Class_PaymentController;
use App\User;
use App\Model\Order;
use App\Model\Post;
use App\Model\Subscribe;

class PaymentController extends API_Controller {
    /**
     * check register in cart
     * get method
     * url : http://localhost:8000/api/v1/payment.
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/payment",
     *   tags={"ticket"},
     *   operationId="payment",
     *   summary="payment ticket",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="cart",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="total_price",
     *    in= "formData",
     *    required=true,
     *    type="number",
     *  ),
     * @SWG\Parameter(
     *    name="type",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="type is (seat , product)",
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
    public function payment(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $cart = isset($input['cart']) ? $input['cart'] : [];
        $total_price = isset($input['total_price']) ? $input['total_price'] : 0;
        $type = isset($input['type']) ? $input['type'] : '';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if (empty($cart)) {
            $fields['cart'] = 'cart';
        }
        if ($type == '' || !in_array($type, ['seat', 'product'])) {
            $fields['type'] = 'type';
        }
        if ($access_token == '') {
            $fields['access_token'] = 'access-token';
        }
        if ($total_price <= 0 || $total_price == '') {
            $fields['total_price'] = 'total_price';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;

            return response()->json($response, 400);
        }
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                $user_id = $data_user->id;
                $get_data = new Class_PaymentController();
                $array_check_cart = $get_data->get_cart($user_id, $cart, 3, 1);
                if (!empty($array_check_cart['not_available'])) {
                    $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                    $array_payment = $get_data->Paymenthyperpay_Seat($data_user, $cart, $total_price, 1);
//                    $response['data'] = $array_payment; 
                    $response['checkoutId'] = $array_payment['checkoutId'];
                    $response['redirect_url'] = 'http://alahliclub.sakb.net/payment/mobile/' . $array_payment['checkoutId'];
                    $response['shopperResultUrl'] = $array_payment['shopperResultUrl'];
                    return response()->json($response, 200);
                } else {
                    $response = API_Controller::MessageData('CART_DATA_FOUND', $lang);
                    $response['data'] = $array_check_cart['not_available'];
                    return response()->json($response, 400);
                }
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
     * check register in cart
     * get method
     * url : http://localhost:8000/api/v1/confirmPayment.
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/confirmPayment",
     *   tags={"ticket"},
     *   operationId="confirmPayment",
     *   summary="confirm Payment ticket",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="orders",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="total_price",
     *    in= "formData",
     *    required=true,
     *    type="number",
     *  ),
     * @SWG\Parameter(
     *    name="resourcePath",
     *    in= "formData",
     *    required=true,
     *    description="resourcePath from url callback from hyper",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="checkout_id",
     *    in= "formData",
     *    required=true,
     *    description="checkout_id from url callback from hyper",
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
    public function confirmPayment(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        //Access-Token
        $input = $request->all();
        $orders = isset($input['orders']) ? $input['orders'] : [];
        $resourcePath = isset($input['resourcePath']) ? $input['resourcePath'] : '';
        $checkout_id = isset($input['checkout_id']) ? $input['checkout_id'] : '';
        $total_price = isset($input['total_price']) ? $input['total_price'] : 0;
        $response = [];
        $fields = [];
        $lang = 'ar';
        if (empty($orders)) {
            $fields['orders'] = 'orders';
        }
        if ($resourcePath == '') {
            $fields['resourcePath'] = 'resourcePath';
        }
        if ($checkout_id == '') {
            $fields['checkout_id'] = 'checkout_id';
        }
        if ($access_token == '') {
            $fields['access_token'] = 'access-token';
        }
        if ($total_price <= 0 || $total_price == '') {
            $fields['total_price'] = 'total_price';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['Message'] = API_Controller::MISSING_FIELD;
            $response['data'] = $fields;

            return response()->json($response, 400);
        }
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                $user_id = $data_user->id;
                $get_data = new Class_PaymentController();
                $res_response = $get_data->payment_CallBack('', $data_user, $checkout_id, $resourcePath, $orders, $total_price, 1);
                if ($res_response['ok_pay'] == 1) {
                    $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                    $response['data'] = $res_response;
                    return response()->json($response, 200);
                } else {
                    $response = API_Controller::MessageData('ERROR_Payment', $lang);
                    $response['data'] = $res_response;
                    return response()->json($response, 400);
                }
            } else {
                $response = API_Controller::MessageData('USER_NOT_Found', $lang);
                return response()->json($response, 401);
            }
        } else {
            $response = API_Controller::MessageData('ACCESSTOKEN_NOT_Found', $lang);
            return response()->json($response, 401);
        }
    }

    //***************************************************
    /**
     * check current user register cart
     * get method
     * url : http://localhost:8000/api/v1/isRegistered.
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/isRegistered",
     *   tags={"ticket"},
     *   operationId="isRegistered",
     *   summary="check isRegistered or not for ticket",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="cart",
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
    public function isRegistered(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $cart = isset($input['cart']) ? $input['cart'] : '';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($cart == '') {
            $fields['cart'] = 'cart';
        }
        if ($access_token == '') {
            $fields['access_token'] = 'access-token';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;

            return response()->json($response, 400);
        }
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                $user_id = $data_user->id;
                $get_cart = new Class_PaymentController();
                $post = $get_cart->get_cart($cart, 3, 1);
                if (isset($post->id)) {
                    $check_order = Order::CheckBuyCart($post->id, $user_id, 1, 1, 0);
                    if ($check_order == 1) {
                        $response = API_Controller::MessageData('REGISTER_SHARE', $lang);
                        return response()->json($response, 200);
                    } elseif ($check_order == 2) {
                        $response = API_Controller::MessageData('REGISTER_NOT_SHARE', $lang);
                        return response()->json($response, 200);
                    } else {
                        $response = API_Controller::MessageData('REGISTER_NOT_COMPLETE', $lang);
                        return response()->json($response, 200);
                    }
                } else {
                    $response = API_Controller::MessageData('CART_DATA_FOUND', $lang);
                    return response()->json($response, 400);
                }
            } else {
                $response = API_Controller::MessageData('USER_NOT_Found', $lang);
                return response()->json($response, 401);
            }
        } else {
            $response = API_Controller::MessageData('ACCESSTOKEN_NOT_Found', $lang);
            return response()->json($response, 401);
        }
    }

}
