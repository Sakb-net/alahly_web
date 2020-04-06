<?php

namespace App\Http\Controllers\ClassSiteApi;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Order;
use App\Model\Post;
use App\Model\OrderProduct;
use App\Model\OrderDetailProduct;
use App\Model\CartProduct;
use App\Model\Fees;
use App\Model\Options;
use App\Http\Controllers\SiteController;

class Class_PaymentController extends SiteController {

    public function __construct() {
        $data_site = Options::Site_Option();
        $this->site_open = $data_site['site_open'];
        $this->lang = $data_site['lang'];
        $this->site_title = $data_site['site_title'];
        $this->site_url = $data_site['site_url'];
        $this->current_id = 0;
        if (!empty(Auth::user())) {
            $this->current_id = Auth::user()->id;
            $this->user_key = Auth::user()->name;
        }
    }

    function Message_failPay($request, $type = 0, $api = 0) {
        $mesage_pay = $back_color = null;
        if ($api == 0) {
            $request->session()->put('session_cart', '');
            $request->session()->put('price_cart', 0);
            $request->session()->put('session_order', '');
            $request->session()->put('price_order', 0);
        }
        if ($type == 1) {
            $back_color = '#87d667'; //'green';
            $mesage_pay = 'تم الاشتراك والحجز معنا بنجاح نتمنى لك الاستمتاع معنا';
        } elseif ($type == 2) {
            $back_color = '#ec4f4f'; //;'red';
            $mesage_pay = 'فشلت عمليت الدفع يرجى التاكد من حسابك و اعادة المحاولة';
        } elseif ($type == 3) {
            $back_color = '#78acc5';
            $mesage_pay = 'يرجى اعادة اختيار مقاعد اخرى نظرا لشراء المقاعد المختارة مسبقا'; //
        } elseif ($type == 5) {
            $back_color = '#ec4f4f';
            $mesage_pay = 'يرجى اعادة الدفع مرة اخرى نظراا حدوث خطا ما'; //
        } else {
            $back_color = '#d1d68c';
            $mesage_pay = 'يرجى اعادة اختيار مقاعد اخرى واعادة المحاولة';
        }
        return array('mesage_pay' => $mesage_pay, 'back_color' => $back_color);
    }

    function get_cart_checkFound($user_id, $cart, $api = 0) {
        $available = $not_available = [];
        $total_price = 0;
        foreach ($cart as $key => $val_c) {
            $order_found = Order::Check_buy_setMatch($val_c['id'],$val_c['match_id'], 1, 1, 1, 0);
            if (isset($order_found->id)) {
                if ($order_found->user_id == $user_id) {
                    $available[] = $val_c;
                } else {
                    $not_available[] = $val_c;
                }
            } else {
                $available[] = $val_c;
            }
        }
        return array('available' => $available, 'not_available' => $not_available); //, 'total_price' => $total_price
    }

    function get_cart($user_id, $cart, $state = 0, $api = 0) {
        $array_data = [];
        $get_data = new Class_PaymentController();
        if ($state == 3) {
            $array_data = $get_data->get_cart_checkFound($user_id, $cart, $api);
        }
        return $array_data;
    }

//***************************Payment Product **********************
    function Payment_product($current_user, $api = 0) {
        //get data of cart from table
        $data_cart = CartProduct::getCartProductType('user_id', $current_user->id, 'product', 'id', 'DESC', 1, -1);
        $array_data = CartProduct::dataCartProduct($data_cart);
        $product_cart = $array_data['product_cart'];
        $total_product = $array_data['total_price_cart'];
        //total fees
        $data_fees = Fees::feesSelectArrayCol('product', 'id', [1, 2], 1, 0);
        $total_price_cart = Fees::get_FeesTotalPrice($data_fees, 0, $total_product);
        $fees_price = $total_price_cart - $total_product;
        $fees = json_encode([1, 2], true);
        $ok_chechout = 0;
        if (!empty($total_price_cart) && $total_price_cart > 0) {
            $payment = new Class_PaymentController();
            $array_data = $payment->Get_checkOutID($current_user, $total_price_cart, $api);
            if ($array_data['ok_chechout'] == 1) {
                $insert_order = OrderProduct::insertOrderProduct($current_user->id, $total_product, 0, $fees, $fees_price, NULL, 'hyperpay', 'site_pay', 'request', 0, 1, $array_data['merchantTransactionId'], $array_data['checkoutId']);
                foreach ($product_cart as $key => $value) {
                    OrderDetailProduct::insertOrderDetailProduct($insert_order['id'], $value, $type = 'hyperpay', 1, 0);
                }
                //clear cart
                // CartProduct::deleteCartUser($current_user->id);
            }
        } else {
            $array_data = array('ok_chechout' => $ok_chechout);
        }
        return $array_data;
    }

    function Product_paymentCallBack($request, $current_user, $checkout_id, $resourcePath, $api = 0) {
        $array_data = array('mesage_pay' => '', 'back_color' => '', 'ok_pay' => 0);
        //$url = "https://test.oppwa.com" . $resourcePath; //"https://test.oppwa.com/v1/checkouts/{id}/payment";
        $url = "https://test.oppwa.com/v1/checkouts/".$checkout_id."/payment"; //"https://test.oppwa.com/v1/checkouts/{id}/payment";
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
        $ok = 0;
        $description = $code = null;
        if (isset($array_response->result->code)) {
            $code = $array_response->result->code; //'000.100.110';
            $description = $array_response->result->description;
            if (preg_match("/^(000\.000\.|000\.100\.1|000\.[36])/", $code)) { ///^([+]?)[0-9]{8,16}$/
                $ok = 1;
            } elseif (preg_match("/^(000\.400\.0[^3]|000\.400\.100)/", $code)) {
                $ok = 1;
            }
        }
        $get_data = new Class_PaymentController();
        if ($ok == 1) { //(isset($array_response->risk->score) && $array_response->amount == $price_order && ($array_response->risk->score == 100 || $array_response->risk->score == "100")) {
            //active order
            $update = OrderProduct::All_checkout_UpdatePayment($current_user->id, $checkout_id, 1, 'hyperpay', 'accept', $code);
            //update count product
            $updatecount_prod = OrderProduct::updatecountProduct($current_user->id, $checkout_id);
            $array_data = $get_data->Message_failPay($request, 1, $api);
            $array_data['ok_pay'] = 1;
            //clear cart for current user
            CartProduct::deleteCartUser($current_user->id);
        } else {
            $array_data = $get_data->Message_failPay($request, 2, $api);
            $array_data['ok_pay'] = 0;
        }
        $array_data['reson_description']=$description;
        return $array_data;
    }

//***************************  Payment Seat of Section  **********************
    function Paymenthyperpay_Seat($current_user, $carts, $total_price_cart, $cart, $api = 0) {
        $testMode = 'EXTERNAL';
        $merchantTransactionId = $current_user->id . time() . rand(100, 99999);
        $customer_email = $current_user->email;
        $billing_street1 = 'alrowad street'; //'street address of customer' ;         
        $billing_city = 'riyadh'; //'should be city of customer';          
        $billing_state = 'alrowad'; //'should be state of customer' ;  
        if (!empty($current_user->city)) {
            $billing_city = $current_user->city;
        }
        if (!empty($current_user->state)) {
            $billing_state = $current_user->state;
        }
        $country = 'SA'; //AE
        if (!empty($current_user->address)) {
            $country = $current_user->address;
        }
        $billing_country = $country; //'Saudi Arabia';  //' should be country of customer  (Alpha-2 codes with Format A2[A-Z]{2})';
        $billing_postcode = '1234';
        $customer_givenName = $current_user->display_name;
        $customer_surname = $current_user->display_name;
        //************
        $ok_chechout = 0;
        if (!empty($total_price_cart) && $total_price_cart > 0) {
            $url = "https://test.oppwa.com/v1/checkouts";
//            $data = "entityId=8ac7a4ca6a1c1fa8016a202f416c02bc" .
//                    "&amount=$total_price_cart" .
//                    "&currency=SAR" .
//                    "&paymentType=DB";

            $data = "entityId=8ac7a4ca6a1c1fa8016a202f416c02bc" .
                    "&amount=$total_price_cart" .
                    "&currency=SAR" .
                    "&paymentType=DB" .
                    "&testMode=$testMode" .
                    "&merchantTransactionId=$merchantTransactionId" .
                    "&customer.email=$customer_email" .
                    "&billing.street1=$billing_street1" .
                    "&billing.city=$billing_city" .
                    "&billing.state=$billing_state" .
                    "&billing.country=$billing_country" .
                    "&billing.postcode=$billing_postcode" .
                    "&customer.givenName=$customer_givenName" .
                    "&customer.surname=$customer_surname";
            // print_r($data);die;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer OGFjN2E0Y2E2YTFjMWZhODAxNmEyMDJlZWVkMTAyYjJ8MnRkdGt6Z0VobQ=='));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            //return $responseData;
            //print_r($responseData);die;
            $array_response = json_decode($responseData);
            //print_r($array_response);die;
            $ok_chechout = 0;
            if (isset($array_response->id)) {
                $ok_chechout = 1;
                $checkoutId = $array_response->id;

//{
//"result":{"code":"000.200.100","description":"successfully created checkout"},
//"buildNumber":"5722481a6ed3a5cfea3c8e48d1d62348dde956b8@2019-04-16 11:07:00 +0000",
//"timestamp":"2019-04-17 21:20:25+0000",
//"ndc":"C7AB01F3A6C18B28E8477C8E47729347.uat01-vm-tx02",
//"id":"C7AB01F3A6C18B28E8477C8E47729347.uat01-vm-tx02"
//}        
                //start cart in session
                foreach ($carts as $key => $value) {
                    $insert_order = Order::insertOrderCart($current_user->id, $value, NULL, 'hyperpay', 'site_pay', 'request', 0, 0, 1, '', $merchantTransactionId, $checkoutId);
                }
                //end cart
                $array_data = array('ok_chechout' => $ok_chechout, 'customer_givenName' => $customer_givenName, 'billing_postcode' => $billing_postcode, 'customer_surname' => $customer_surname,
                    'billing_country' => $billing_country, 'billing_state' => $billing_state, 'billing_city' => $billing_city,
                    'billing_street1' => $billing_street1, 'customer_email' => $customer_email,
                    'testMode' => $testMode, 'merchantTransactionId' => $merchantTransactionId,
                    'checkoutId' => $checkoutId);
            } else {
                $array_data = array('ok_chechout' => $ok_chechout);
            }
        } else {
            $array_data = [];
        }
        return $array_data;
    }

    function payment_CallBack($request, $current_user, $checkout_id, $resourcePath, $session_orders, $price_order, $api = 0) {
        $array_data = array('mesage_pay' => '', 'back_color' => '', 'ok_pay' => 0);
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
        $ok = 0;
        $description = $code = null;
        if (isset($array_response->result->code)) {
            $code = $array_response->result->code; //'000.100.110';
            $description = $array_response->result->description;
            if (preg_match("/^(000\.000\.|000\.100\.1|000\.[36])/", $code)) { ///^([+]?)[0-9]{8,16}$/
                $ok = 1;
            } elseif (preg_match("/^(000\.400\.0[^3]|000\.400\.100)/", $code)) {
                $ok = 1;
            }
        }
        $get_data = new Class_PaymentController();
        if ($ok == 1) { //(isset($array_response->risk->score) && $array_response->amount == $price_order && ($array_response->risk->score == 100 || $array_response->risk->score == "100")) {
            //active chair
            $update = Order::All_checkout_UpdatePayment($current_user->id, $checkout_id, $session_orders, 1, 'hyperpay', 'accept', $code);
            $array_data = $get_data->Message_failPay($request, 1, $api);
            $array_data['ok_pay'] = 1;
        } else {
            $array_data = $get_data->Message_failPay($request, 2, $api);
            $all_carts = $array_order_id = [];
            $total_price_cart = 0;
            foreach ($session_orders as $key_order => $val_order) {
                $array_order_id[] = $val_order['id'];
                $all_carts[] = $val_order;
                $total_price_cart += Post::totalPrice($val_order['price'], $val_order['discount']);
            }
            $update = Order::All_checkout_UpdateFailPayment($current_user->id, $array_order_id, 0, 0, 1);
            if ($api == 0) {
                $carts = $request->session()->get('session_cart');
                if (empty($carts)) {
                    $carts = [];
                }
                foreach ($carts as $key_cart => $val_cart) {
                    if (!in_array($val_cart['id'], $array_order_id)) {
                        $all_carts[] = $val_cart;
                        $total_price_cart += Post::totalPrice($val_cart['price'], $val_cart['discount']);
                    }
                }
                $request->session()->put('session_cart', $all_carts);
                $request->session()->put('price_cart', $total_price_cart);
            }
        }

        return $array_data;
    }

//*******************************************
    function Get_checkOutID($current_user, $total_price_cart, $api = 0) {
        $testMode = 'EXTERNAL';
        $merchantTransactionId = $current_user->id . time() . rand(100, 99999);
        $customer_email = $current_user->email;
        $billing_street1 = 'alrowad street'; //'street address of customer' ;         
        $billing_city = 'riyadh'; //'should be city of customer';          
        $billing_state = 'alrowad'; //'should be state of customer' ;  
        if (!empty($current_user->city)) {
            $billing_city = $current_user->city;
        }
        if (!empty($current_user->state)) {
            $billing_state = $current_user->state;
        }
        $country = 'SA'; //AE
        if (!empty($current_user->address)) {
            $country = $current_user->address;
        }
        $billing_country = $country; //'Saudi Arabia';  //' should be country of customer  (Alpha-2 codes with Format A2[A-Z]{2})';
        $billing_postcode = '1234';
        $customer_givenName = $current_user->display_name;
        $customer_surname = $current_user->display_name;
        //************
        $ok_chechout = 0;
        if (!empty($total_price_cart) && $total_price_cart > 0) {
            $url = "https://test.oppwa.com/v1/checkouts";
//            $data = "entityId=8ac7a4ca6a1c1fa8016a202f416c02bc" .
//                    "&amount=$total_price_cart" .
//                    "&currency=SAR" .
//                    "&paymentType=DB";
            $total_price_cart= round($total_price_cart,0);
            $data = "entityId=8ac7a4ca6a1c1fa8016a202f416c02bc" .
                    "&amount=$total_price_cart" .
                    "&currency=SAR" .
                    "&paymentType=DB" .
                    "&testMode=$testMode" .
                    "&merchantTransactionId=$merchantTransactionId" .
                    "&customer.email=$customer_email" .
                    "&billing.street1=$billing_street1" .
                    "&billing.city=$billing_city" .
                    "&billing.state=$billing_state" .
                    "&billing.country=$billing_country" .
                    "&billing.postcode=$billing_postcode" .
                    "&customer.givenName=$customer_givenName" .
                    "&customer.surname=$customer_surname";
            // print_r($data);die;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer OGFjN2E0Y2E2YTFjMWZhODAxNmEyMDJlZWVkMTAyYjJ8MnRkdGt6Z0VobQ=='));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            //return $responseData;
            //print_r($responseData);die;
            $array_response = json_decode($responseData);
            //print_r($array_response);die;
            $ok_chechout = 0;
            if (isset($array_response->id)) {
                $ok_chechout = 1;
                $checkoutId = $array_response->id;

                //end cart
                $array_data = array('ok_chechout' => $ok_chechout, 'customer_givenName' => $customer_givenName, 'billing_postcode' => $billing_postcode, 'customer_surname' => $customer_surname,
                    'billing_country' => $billing_country, 'billing_state' => $billing_state, 'billing_city' => $billing_city,
                    'billing_street1' => $billing_street1, 'customer_email' => $customer_email,
                    'testMode' => $testMode, 'merchantTransactionId' => $merchantTransactionId,
                    'checkoutId' => $checkoutId);
            } else {
                $array_data = array('ok_chechout' => $ok_chechout);
            }
        } else {
            $array_data = array('ok_chechout' => $ok_chechout);
        }
        return $array_data;
    }

}
