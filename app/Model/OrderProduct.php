<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use App\Model\Post;
use App\Model\OrderDetailProduct;

//use App\Model\Fees;

class OrderProduct extends Model {

    protected $table = 'order_products';
    protected $fillable = [
        'user_id', 'add_by', 'fees_price', 'fees', 'link', 'type', 'source_share', 'type_request',
        'checkoutId', 'transactionId', 'total_discount', 'total_price', 'is_stoke', 'is_bill',
        'is_read', 'is_active', 'code','state_stoke','is_recieved','is_delivery'
    ]; //'quantity',

    //type_request-->accept,request,....
    //type-->hyper , free
    //source_share-->site /app  (site_pay - site_free - apple - app_free- app_pay)
//    is_bill
//      0         free can buy
//      1         stock to buy
//      2         delete from billpage of user
//is_stoke   is_active
//    1            1      ok buy and share
//    0            1      stop share
//    1            0      not compelete share or not pay

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function actions() {
        return $this->morphMany(\App\Model\Action::class, 'actionable');
    }

    public function products() {
        return $this->belongsTo(\App\Model\Post::class, 'fees_price');
    }

    public static function Make_order_link($fees_product) {
        $fees_product = str_limit($fees_product, 20);
        $order_time = str_replace(' ', '_', $fees_product . str_random(8));
        $order_link = rand(5, 90) . substr(md5($order_time), 3, 20);
        return $order_link;
    }

    public static function insertOrderProduct($user_id, $total_price, $total_discount, $fees, $fees_price, $add_by = NULL, $type = 'hyperpay', $source_share = 'site_pay', $type_request = 'request', $is_active = 0, $is_bill = 0, $transactionId = NULL, $checkoutId = NULL) {
        $input['user_id'] = $user_id;
        $input['add_by'] = $add_by;
        $input['fees_price'] = $fees_price;
        $input['fees'] = $fees;
        $input['link'] = OrderProduct::Make_order_link(time()); //str_replace(' ', '_', $product['fees'] . str_random(8));
        $input['type'] = $type;
        $input['type_request'] = $type_request;
        $input['source_share'] = $source_share;
        $input['total_price'] = conditionPrice($total_price);
        $input['total_discount'] = conditionDiscount($total_discount);
        $input['is_active'] = $is_active;
        $input['is_bill'] = $is_bill;
        $input['transactionId'] = $transactionId;
        $input['checkoutId'] = $checkoutId;
        $order = OrderProduct::create($input);
        return $order;
    }

    public static function insertOrderProductCart($user_id, $product, $add_by = NULL, $type = 'hyperpay', $source_share = 'site_pay', $type_request = 'request', $total_discount = 0, $is_active = 0, $is_bill = 1, $total_price = '', $transactionId = NULL, $checkoutId = NULL) {
        $input['user_id'] = $user_id;
        $input['add_by'] = $add_by;
        $input['fees_price'] = $product['id'];
        $input['fees'] = $product['fees'];
        $input['link'] = OrderProduct::Make_order_link($product['fees']); //str_replace(' ', '_', $product['fees'] . str_random(8));
        $input['type'] = $type;
        $input['type_request'] = $type_request;
        $input['source_share'] = $source_share;
        if (!empty($total_price)) {
            $input['total_price'] = conditionPrice($total_price);
        } else {
            $input['total_price'] = Post::totalPrice($product['total_price'], $product['total_discount']);
        }
        $input['total_discount'] = conditionDiscount($product['total_discount']);
        $input['is_active'] = $is_active;
        $input['is_bill'] = $is_bill;
        $input['transactionId'] = $transactionId;
        $input['checkoutId'] = $checkoutId;
        $order = OrderProduct::create($input);
        return $order;
    }

    public static function updateOrderProductBuy($id, $user_id, $total_total_price, $total_discount, $is_active = 1, $type_request = 'accept', $type = 'hyperpay', $source_share = 'site_pay') {
        $order = static::findOrFail($id);
        $input['user_id'] = $user_id;
        $input['type'] = $type;
        $input['type_request'] = $type_request;
        $input['source_share'] = $source_share;
        $input['is_active'] = $is_active;
        $input['total_price'] = $total_total_price;
        $input['total_discount'] = $total_discount;
        $order_update = $order->update($input);
        return $order_update;
    }

    public static function checkout_UpdatePayment($user_id, $checkout_id, $val_order, $is_active, $type, $type_request) {
        // $order = static::where('checkoutId',$checkout_id)->get();
        // 'total_price' => $val_order['total_price'],'total_discount'=>$val_order['total_discount']
        return static::where('checkoutId', $checkout_id)->where('user_id', $user_id)
                        ->update(['type_request' => $type_request, 'type' => $type, 'is_active' => $is_active]);
    }

    public static function All_checkout_UpdatePayment($user_id, $checkout_id, $is_active, $type, $type_request, $code = null) {
        return static::where('checkoutId', $checkout_id)->where('user_id', $user_id)
                        ->update(['type_request' => $type_request, 'type' => $type, 'is_active' => $is_active, 'code' => $code]);
    }

    public static function All_checkout_UpdateFailPayment($user_id, $array_id, $is_bill = 0, $is_active = 0, $is_stoke = 1) {
        return static::whereIn('id', $array_id)->where('user_id', $user_id)
                        ->update(['is_bill' => $is_bill, 'is_active' => $is_active, 'is_stoke' => $is_stoke]);
    }

    public static function updateOrderProductColumnID($id, $column, $column_value) {
        $order = static::findOrFail($id);
        $order->$column = $column_value;
        return $order->save();
    }

    public static function updateOrderProductColum($colum, $valueColum, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->update([$columUpdate => $valueUpdate]);
    }

    public static function updateOrderProductTwoColum($colum, $valueColum, $columTwo, $valueColumTwo, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->where($columTwo, $valueColumTwo)->update([$columUpdate => $valueUpdate]);
    }

    public static function updateOrderProduct($colum, $arrayOrderProduct_id, $columUpdate, $valueUpdate) {
        $result = OrderProduct::where($colum, $all_array_id)->update([$columUpdate => $valueUpdate]);
        return $result;
    }

    public static function updateArrayOrderProduct($colum, $arrayOrderProduct_id, $columUpdate, $valueUpdate) {
        $all_array_id = array_values($arrayOrderProduct_id);
        $result = OrderProduct::whereIn($colum, $all_array_id)->update([$columUpdate => $valueUpdate]);
        return $result;
    }

    public static function updatecountProduct($user_id, $checkout_id) {
        $order_prod = static::get_LastcheckoutId($user_id, $checkout_id);
        $detail_products = OrderDetailProduct::get_orderDetail('order_detail_id', $order_prod->id);
        foreach ($detail_products as $key => $val_del) {
            Product::updateColumProductCount($val_del->product_id, 'sale_number_prod', $val_del->quantity);
        }
        return $order_prod;
    }

    public static function deleteOrderProductUser($user_id, $fees_price = 0) {
        if ($fees_price == 0) {
            return self::where('user_id', $user_id)->delete();
        } else {
            return self::where('fees_price', $fees_price)->where('user_id', $user_id)->delete();
        }
    }

    public static function deleteArrayOrderProduct($colum, $arrayOrderProduct_id) {
        $all_array_id = array_values($arrayOrderProduct_id);
        $result = OrderProduct::whereIn($colum, $all_array_id)->delete();
        return $result;
    }

    public static function Check_buy_set($fees_price, $is_active = 0, $is_stoke = 1, $is_bill = 1, $check = 0) {
        $order = OrderProduct::where('fees_price', $fees_price)
                        ->where('is_active', $is_active)->where('is_stoke', $is_stoke)->where('is_bill', $is_bill)->orderBy('id', 'DESC')->first();
        if ($check == 1) {
            if (isset($order->id)) {
                $order = 1;
            } else {
                $order = 0;
            }
        }
        return $order;
    }

    public static function get_LastcheckoutId($user_id, $checkout_id, $data_order = 'id') {
        $order = OrderProduct::where('user_id', $user_id)->where('checkoutId', $checkout_id)->orderBy($data_order, 'DESC')->first();
        return $order;
    }

    public static function Check_NOTComplete_BuyCourse($fees_price, $user_id, $is_active = 0, $is_stoke = 1, $type_request = 'request', $colum_fees = '') {
        $data = static::where('fees_price', '=', $fees_price)
                ->where('user_id', '=', $user_id)
                ->where('is_active', '=', $is_active)
                ->where('type_request', $type_request)
                ->where('is_stoke', '=', $is_stoke);
        $result = $data->first();
        if (isset($result->id) && $result->id > 0) {
            if (!empty($colum_fees)) {
                return $result->$colum_fees;
            } else {
                return $result->toArray();
            }
        } else {
            return '';  //not buy
        }
    }

    public static function CheckFoundOrderProductACtiveShare($user_id, $fees_price, $is_stoke = 1, $is_active = 1, $arrayColume = []) {
        if (!empty($user_id)) {
            $order = static::where('user_id', $user_id);
        } else {
            $order = static::with('user');
        }
        $data = $order->where('fees_price', $fees_price)->where('is_stoke', $is_stoke)->where('is_active', $is_active);
        if (!empty($user_id) && empty($arrayColume)) {
            $data = $order->first();
        } elseif (!empty($user_id) && !empty($arrayColume)) {
            $data = $order->first();
        } elseif (empty($user_id) && !empty($arrayColume)) {
            $data = $order->get($arrayColume);
        } else {
            $data = $order->get();
        }
        return $data;
    }

    public static function OrderProduct_BuyLink($fees_price, $user_id, $order_link, $is_active = 1) {
        $data = static::where('fees_price', '=', $fees_price)->where('user_id', '=', $user_id)
                ->Where('link', $order_link);
        $result = $data->first();
        return $result;
    }

    public static function CheckBuyCart($fees_price, $user_id, $is_active = 1, $is_stoke = 1, $check_share = 1) {
        $data = static::where('fees_price', '=', $fees_price)->where('user_id', '=', $user_id)->where('is_active', '=', $is_active);
        if ($check_share == 1) {
            $result = $data->where('is_stoke', '=', $is_stoke);
        }
        $result = $data->orderBy('id', 'DESC')->first();
        if (isset($result->id) && $result->id > 0) {
            if ($result->is_stoke == 1) {
                return 1;  //buy and share
            } else {
                return 2; //buy and not share
            }
        } else {
            return 0;  //not buy
        }
    }

    public static function CheckShare($id, $fees_price, $user_id) {
        return static::where('id', '>', $id)->where('fees_price', '=', $fees_price)->where('user_id', '=', $user_id)->get();
    }

    public static function get_UserOrderProductShareActive($user_id, $is_active = 1, $is_stoke = 1, $type_request = '', $limit = 0) {
        $data = OrderProduct::where('user_id', $user_id)->where('is_active', $is_active)->where('is_stoke', $is_stoke);
        if (!empty($type_request)) {
            $result = $data->where('type_request', $type_request);
        }
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_OrderProductShareActive($is_active = 1, $is_stoke = 1, $type_request = '', $limit = 0) {
        $data = OrderProduct::with('user')->where('is_active', $is_active)->where('is_stoke', $is_stoke);
        if (!empty($type_request)) {
            $result = $data->where('type_request', $type_request);
        }
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_OrderProductRangeDate($start_date = '', $end_date = '', $fees_price = -1, $is_active = '') {
        $data = OrderProduct::with('products')->whereBetween('created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
        if (!empty($is_active)) {
            $result = $data->where('is_active', $is_active);
        }
        if ($fees_price > 0) {
            $result = $data->where('fees_price', $fees_price);
        }
        $result = $data->get();
        return $result;
    }

    public static function get_OrderProductPostActive($fees_price, $is_active = '') {
        $data = OrderProduct::where('fees_price', $fees_price);
        if (!empty($is_active)) {
            $count = $data->where('is_active', $is_active);
        }
        $count = $data->count();
        return $count;
    }

    public static function get_orderChairCategory($user_id, $category_id, $is_active = '', $is_stoke = '', $limit = 0) {
//                ->select('orders.id', 'orders.fees','orders.user_id','orders.fees_price', 'orders.is_stoke', 'products.type_cost')
        $data = OrderProduct::with('user')->leftJoin('products', 'products.id', '=', 'orders.fees_price')
                ->leftJoin('category_product', 'products.id', '=', 'category_product.fees_price')
                ->select('orders.*', 'products.*')
                ->where('category_product.category_id', $category_id);
        if (!empty($user_id)) {
            $result = $data->where('orders.user_id', $user_id);
        }
        if (!empty($is_active)) {
            $result = $data->where('orders.is_active', $is_active);
        }
        if (!empty($is_stoke)) {
            $result = $data->where('orders.is_stoke', $is_stoke);
        }
        if ($limit == -1) {
            $result = $data->pluck('orders.fees_price', 'orders.fees_price')->toArray();
        } elseif ($limit == -2) {
            $result = $data->count();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_OrderProductRangeDatePost($start_date = '', $end_date = '', $fees_price, $is_active = '') {
//                ->select('orders.id', 'orders.fees','orders.user_id','orders.fees_price', 'orders.is_stoke', 'products.type_cost')
        $data = OrderProduct::with('user')->leftJoin('products', 'products.id', '=', 'orders.fees_price')
                ->select('orders.*', 'products.*')
                ->whereBetween('orders.created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
//        $data = OrderProduct::with('user')->with('products')
//                ->whereBetween('orders.created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
        if ($fees_price == -1 || in_array(-1, $fees_price)) {
            //get all order for courses
            $fees_price = -1;
        } elseif ($fees_price == -2 || in_array(-2, $fees_price)) {
            $fees_price = -2;
            $result = $data->where('products.type_cost', 'free');
        } elseif ($fees_price == -3 || in_array(-3, $fees_price)) {
            $fees_price = -3;
            $result = $data->where('products.type_cost', '<>', 'free');
        } else { //if ($fees_price > 0)
            $result = $data->whereIn('orders.fees_price', $fees_price);
        }
        if (!empty($is_active)) {
            $result = $data->where('orders.is_active', $is_active);
        }
        $result = $data->get();
        return $result;
    }

    public static function get_BestOrderProductRangeDate($start_date = '', $end_date = '', $limit = 0, $is_active = '', $is_stoke = '', $user = '') {
        $data = OrderProduct::with('products')
                        ->whereBetween('created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"])
                        ->groupBy('fees_price')->select('fees_price', DB::raw('count(*) as total_fees_price'));
        if (!empty($is_active)) {
            $result = $data->where('is_active', $is_active);
        }
        if (!empty($is_stoke)) {
            $result = $data->where('is_stoke', $is_stoke);
        }
        if (!empty($user)) {
            $result = $data->with('user');
        }
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } elseif ($limit == -1) {
            $result = $data->pluck('id', 'id')->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function SearchOrderProduct($search, $is_stoke = '', $is_active = '', $limit = 0) {
        $data = static::Where('fees', 'like', '%' . $search . '%')
                ->orWhere('link', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%')
                ->orWhere('fees_price', 'like', '%' . $search . '%')
                ->orWhere('add_by', 'like', '%' . $search . '%')
                ->orWhere('user_id', 'like', '%' . $search . '%')
                ->orWhere('total_price', 'like', '%' . $search . '%')
                ->orWhere('total_discount', 'like', '%' . $search . '%')
                ->orWhere('type_request', 'like', '%' . $search . '%')
                ->orWhere('source_share', 'like', '%' . $search . '%')
                ->orWhere('order_id', 'like', '%' . $search . '%')
                ->orWhere('success_link', 'like', '%' . $search . '%')
                ->orWhere('error_link', 'like', '%' . $search . '%');

        if (!empty($is_active)) {
            $result = $data->where('is_active', $is_active);
        }
        if (!empty($is_stoke)) {
            $result = $data->where('is_stoke', $is_stoke);
        }
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } elseif ($limit == -1) {
            $result = $data->pluck('id', 'id')->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_LastRow($colum_value, $colum, $data_order = 'id') {
        $order = OrderProduct::where($colum_value, $colum_value)->orderBy($data_order, 'DESC')->first();
        if (!empty($order)) {
            return $order->$colum;
        } else {
            return 0;
        }
    }

    public static function CountOrderProductMore() {
        $data = OrderProduct::with('products')->select(DB::raw('orders.fees_price, count(orders.fees_price) AS count_product'))
                ->groupBy('orders.fees_price')
                ->get();
        return $data;
    }

    public static function countOrderProductUserShare($user_id, $is_stoke = 1, $is_active = 1, $limit = 0, $is_bill = -1) {
        $data = static::where('user_id', $user_id)->where('is_stoke', $is_stoke)->where('is_active', $is_active);
        if ($is_bill != -1) {
            $result = $data->where('is_bill', $is_bill);
        }
        if ($limit == -1) {
            $result = $data->pluck('fees_price', 'fees_price')->toArray();
        } elseif ($limit == -2) {
            $result = $data->count();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function countOrderProductUnRead() {
        return static::where('is_read', 0)->count();
    }

    public static function countOrderProductTypeUnRead($type_request = 'accept') {
        return static::where('type_request', $type_request)->where('is_read', 0)->count();
    }

    public static function CountOrderProduct($total_price, $stateOrderProduct, $type_request, $is_active, $is_stoke) {
        $count = OrderProduct::where('total_price', $stateOrderProduct, $total_price)->where('type_request', $type_request)->where('is_active', $is_active)->where('is_stoke', $is_stoke)->count();
        return $count;
    }

    public static function lastMonth($month, $date, $total_price, $stateOrderProduct, $type_request, $is_active, $is_stoke) {
        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$month, $date])->where('total_price', $stateOrderProduct, $total_price)->where('type_request', $type_request)->where('is_active', $is_active)->where('is_stoke', $is_stoke)->get();
        return $count[0]->count;
    }

    public static function lastWeek($week, $date, $total_price, $stateOrderProduct, $type_request, $is_active, $is_stoke) {

        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$week, $date])->where('total_price', $stateOrderProduct, $total_price)->where('type_request', $type_request)->where('is_active', $is_active)->where('is_stoke', $is_stoke)->get();
        return $count[0]->count;
    }

    public static function lastDay($day, $date, $total_price, $stateOrderProduct, $type_request, $is_active, $is_stoke) {
        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$day, $date])->where('total_price', $stateOrderProduct, $total_price)->where('type_request', $type_request)->where('is_active', $is_active)->where('is_stoke', $is_stoke)->get();
        return $count[0]->count;
    }

}
