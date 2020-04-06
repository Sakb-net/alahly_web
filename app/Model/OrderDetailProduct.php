<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use App\Model\Post;

class OrderDetailProduct extends Model {

    protected $table = 'order_detail_products';
    protected $fillable = [
        'order_detail_id', 'product_id', 'name', 'link', 'type', 'fees', 'fees_price',
        'description', 'quantity', 'discount', 'price', 'is_share', 'is_bill',
        'is_read', 'is_active'
    ];

    //type-->hyper , free
//    is_bill
//      0         free can buy
//      1         stock to buy
//      2         delete from billpage of user
//is_share   is_active
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
        return $this->belongsTo(\App\Model\Post::class, 'product_id');
    }

    public static function Make_order_link($name_product) {
        $name_product = str_limit($name_product, 20);
        $order_time = str_replace(' ', '_', $name_product . str_random(8));
        $order_link = rand(5, 90) . substr(md5($order_time), 3, 20);
        return $order_link;
    }

    public static function insertOrderDetailProduct($order_detail_id, $product, $type = 'hyperpay', $is_active = 0, $is_bill = 0) {
        $input['order_detail_id'] = $order_detail_id;
        $input['product_id'] = $product['lang_id'];
        $input['name'] = $product['name'];
        $input['quantity'] = $product['quantity'];
        $input['link'] = OrderDetailProduct::Make_order_link($product['name']); //str_replace(' ', '_', $product['name'] . str_random(8));
        $input['type'] = $type;
        $input['fees_price'] = 0.00;
        $input['fees'] = null;
        $input['price'] = Post::totalPrice($product['price'], $product['discount']);
        $input['discount'] = conditionDiscount($product['discount']);
        $input['is_active'] = $is_active;
        $input['is_bill'] = $is_bill;
        $input['description'] = $product['description'];
        $order = OrderDetailProduct::create($input);
        return $order;
    }

    public static function insertOrderDetailProductCart($order_detail_id, $product, $add_by = NULL, $type = 'hyperpay', $fees = 'site_pay', $fees_price = 'request', $discount = 0, $is_active = 0, $is_bill = 1, $price = '', $description = NULL) {
        $input['order_detail_id'] = $order_detail_id;
        $input['add_by'] = $add_by;
        $input['product_id'] = $product['id'];
        $input['name'] = $product['name'];
        $input['link'] = OrderDetailProduct::Make_order_link($product['name']); //str_replace(' ', '_', $product['name'] . str_random(8));
        $input['type'] = $type;
        $input['fees_price'] = $fees_price;
        $input['fees'] = $fees;
        if (!empty($price)) {
            $input['price'] = conditionPrice($price);
        } else {
            $input['price'] = Post::totalPrice($product['price'], $product['discount']);
        }
        $input['discount'] = conditionDiscount($product['discount']);
        $input['is_active'] = $is_active;
        $input['is_bill'] = $is_bill;
        $input['description'] = $product['description']; //$description;
        $order = OrderDetailProduct::create($input);
        return $order;
    }

    public static function updateOrderDetailProductBuy($id, $order_detail_id, $total_price, $discount, $is_active = 1, $fees_price = 'accept', $type = 'hyperpay', $fees = 'site_pay') {
        $order = static::findOrFail($id);
        $input['order_detail_id'] = $order_detail_id;
        $input['type'] = $type;
        $input['fees_price'] = $fees_price;
        $input['fees'] = $fees;
        $input['is_active'] = $is_active;
        $input['price'] = $total_price;
        $input['discount'] = $discount;
        $order_update = $order->update($input);
        return $order_update;
    }

    public static function All_checkout_UpdateFailPayment($order_detail_id, $array_id, $is_bill = 0, $is_active = 0, $is_share = 1) {
        return static::whereIn('id', $array_id)->where('order_detail_id', $order_detail_id)
                        ->update(['is_bill' => $is_bill, 'is_active' => $is_active, 'is_share' => $is_share]);
    }

    public static function updateOrderDetailProductColumnID($id, $column, $column_value) {
        $order = static::findOrFail($id);
        $order->$column = $column_value;
        return $order->save();
    }

    public static function updateOrderDetailProductColum($colum, $valueColum, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->update([$columUpdate => $valueUpdate]);
    }

    public static function updateOrderDetailProductTwoColum($colum, $valueColum, $columTwo, $valueColumTwo, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->where($columTwo, $valueColumTwo)->update([$columUpdate => $valueUpdate]);
    }

    public static function updateOrderDetailProduct($colum, $arrayOrderDetailProduct_id, $columUpdate, $valueUpdate) {
        $result = OrderDetailProduct::where($colum, $all_array_id)->update([$columUpdate => $valueUpdate]);
        return $result;
    }

    public static function updateArrayOrderDetailProduct($colum, $arrayOrderDetailProduct_id, $columUpdate, $valueUpdate) {
        $all_array_id = array_values($arrayOrderDetailProduct_id);
        $result = OrderDetailProduct::whereIn($colum, $all_array_id)->update([$columUpdate => $valueUpdate]);
        return $result;
    }

    public static function deleteOrderDetailProductUser($order_detail_id, $product_id = 0) {
        if ($product_id == 0) {
            return self::where('order_detail_id', $order_detail_id)->delete();
        } else {
            return self::where('product_id', $product_id)->where('order_detail_id', $order_detail_id)->delete();
        }
    }

    public static function deleteArrayOrderDetailProduct($colum, $arrayOrderDetailProduct_id) {
        $all_array_id = array_values($arrayOrderDetailProduct_id);
        $result = OrderDetailProduct::whereIn($colum, $all_array_id)->delete();
        return $result;
    }

    public static function Check_buy_set($product_id, $is_active = 0, $is_share = 1, $is_bill = 1, $check = 0) {
        $order = OrderDetailProduct::where('product_id', $product_id)
                        ->where('is_active', $is_active)->where('is_share', $is_share)->where('is_bill', $is_bill)->orderBy('id', 'DESC')->first();
        if ($check == 1) {
            if (isset($order->id)) {
                $order = 1;
            } else {
                $order = 0;
            }
        }
        return $order;
    }

    public static function get_orderDetailProduct($order_detail_id, $product_id, $data_order = 'id') {
        $order = OrderDetailProduct::where('order_detail_id', $order_detail_id)->where('product_id', $product_id)->orderBy($data_order, 'DESC')->first();
        return $order;
    }
    public static function get_orderDetail($col='order_detail_id',$col_val, $data_order = 'id') {
        $order = OrderDetailProduct::where($col, $col_val)->orderBy($data_order, 'DESC')->get();
        return $order;
    }

    public static function Check_NOTComplete_BuyCourse($product_id, $order_detail_id, $is_active = 0, $is_share = 1, $fees_price = 'request', $colum_name = '') {
        $data = static::where('product_id', '=', $product_id)
                ->where('order_detail_id', '=', $order_detail_id)
                ->where('is_active', '=', $is_active)
                ->where('fees_price', $fees_price)
                ->where('is_share', '=', $is_share);
        $result = $data->first();
        if (isset($result->id) && $result->id > 0) {
            if (!empty($colum_name)) {
                return $result->$colum_name;
            } else {
                return $result->toArray();
            }
        } else {
            return '';  //not buy
        }
    }

    public static function CheckFoundOrderDetailProductACtiveShare($order_detail_id, $product_id, $is_share = 1, $is_active = 1, $arrayColume = []) {
        if (!empty($order_detail_id)) {
            $order = static::where('order_detail_id', $order_detail_id);
        } else {
            $order = static::with('user');
        }
        $data = $order->where('product_id', $product_id)->where('is_share', $is_share)->where('is_active', $is_active);
        if (!empty($order_detail_id) && empty($arrayColume)) {
            $data = $order->first();
        } elseif (!empty($order_detail_id) && !empty($arrayColume)) {
            $data = $order->first();
        } elseif (empty($order_detail_id) && !empty($arrayColume)) {
            $data = $order->get($arrayColume);
        } else {
            $data = $order->get();
        }
        return $data;
    }

    public static function OrderDetailProduct_BuyLink($product_id, $order_detail_id, $order_link, $is_active = 1) {
        $data = static::where('product_id', '=', $product_id)->where('order_detail_id', '=', $order_detail_id)
                ->Where('link', $order_link);
        $result = $data->first();
        return $result;
    }

    public static function CheckBuyCart($product_id, $order_detail_id, $is_active = 1, $is_share = 1, $check_share = 1) {
        $data = static::where('product_id', '=', $product_id)->where('order_detail_id', '=', $order_detail_id)->where('is_active', '=', $is_active);
        if ($check_share == 1) {
            $result = $data->where('is_share', '=', $is_share);
        }
        $result = $data->orderBy('id', 'DESC')->first();
        if (isset($result->id) && $result->id > 0) {
            if ($result->is_share == 1) {
                return 1;  //buy and share
            } else {
                return 2; //buy and not share
            }
        } else {
            return 0;  //not buy
        }
    }

    public static function CheckShare($id, $product_id, $order_detail_id) {
        return static::where('id', '>', $id)->where('product_id', '=', $product_id)->where('order_detail_id', '=', $order_detail_id)->get();
    }

    public static function get_UserOrderDetailProductShareActive($order_detail_id, $is_active = 1, $is_share = 1, $fees_price = '', $limit = 0) {
        $data = OrderDetailProduct::where('order_detail_id', $order_detail_id)->where('is_active', $is_active)->where('is_share', $is_share);
        if (!empty($fees_price)) {
            $result = $data->where('fees_price', $fees_price);
        }
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_OrderDetailProductShareActive($is_active = 1, $is_share = 1, $fees_price = '', $limit = 0) {
        $data = OrderDetailProduct::with('user')->where('is_active', $is_active)->where('is_share', $is_share);
        if (!empty($fees_price)) {
            $result = $data->where('fees_price', $fees_price);
        }
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_OrderDetailProductRangeDate($start_date = '', $end_date = '', $product_id = -1, $is_active = '') {
        $data = OrderDetailProduct::with('products')->whereBetween('created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
        if (!empty($is_active)) {
            $result = $data->where('is_active', $is_active);
        }
        if ($product_id > 0) {
            $result = $data->where('product_id', $product_id);
        }
        $result = $data->get();
        return $result;
    }

    public static function get_OrderDetailProductPostActive($product_id, $is_active = '') {
        $data = OrderDetailProduct::where('product_id', $product_id);
        if (!empty($is_active)) {
            $count = $data->where('is_active', $is_active);
        }
        $count = $data->count();
        return $count;
    }

    public static function get_orderChairCategory($order_detail_id, $category_id, $is_active = '', $is_share = '', $limit = 0) {
//                ->select('orders.id', 'orders.name','orders.order_detail_id','orders.product_id', 'orders.is_share', 'products.type_cost')
        $data = OrderDetailProduct::with('user')->leftJoin('products', 'products.id', '=', 'orders.product_id')
                ->leftJoin('category_product', 'products.id', '=', 'category_product.product_id')
                ->select('orders.*', 'products.*')
                ->where('category_product.category_id', $category_id);
        if (!empty($order_detail_id)) {
            $result = $data->where('orders.order_detail_id', $order_detail_id);
        }
        if (!empty($is_active)) {
            $result = $data->where('orders.is_active', $is_active);
        }
        if (!empty($is_share)) {
            $result = $data->where('orders.is_share', $is_share);
        }
        if ($limit == -1) {
            $result = $data->pluck('orders.product_id', 'orders.product_id')->toArray();
        } elseif ($limit == -2) {
            $result = $data->count();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_OrderDetailProductRangeDatePost($start_date = '', $end_date = '', $product_id, $is_active = '') {
//                ->select('orders.id', 'orders.name','orders.order_detail_id','orders.product_id', 'orders.is_share', 'products.type_cost')
        $data = OrderDetailProduct::with('user')->leftJoin('products', 'products.id', '=', 'orders.product_id')
                ->select('orders.*', 'products.*')
                ->whereBetween('orders.created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
//        $data = OrderDetailProduct::with('user')->with('products')
//                ->whereBetween('orders.created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
        if ($product_id == -1 || in_array(-1, $product_id)) {
            //get all order for courses
            $product_id = -1;
        } elseif ($product_id == -2 || in_array(-2, $product_id)) {
            $product_id = -2;
            $result = $data->where('products.type_cost', 'free');
        } elseif ($product_id == -3 || in_array(-3, $product_id)) {
            $product_id = -3;
            $result = $data->where('products.type_cost', '<>', 'free');
        } else { //if ($product_id > 0)
            $result = $data->whereIn('orders.product_id', $product_id);
        }
        if (!empty($is_active)) {
            $result = $data->where('orders.is_active', $is_active);
        }
        $result = $data->get();
        return $result;
    }

    public static function get_BestOrderDetailProductRangeDate($start_date = '', $end_date = '', $limit = 0, $is_active = '', $is_share = '', $user = '') {
        $data = OrderDetailProduct::with('products')
                        ->whereBetween('created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"])
                        ->groupBy('product_id')->select('product_id', DB::raw('count(*) as total_product_id'));
        if (!empty($is_active)) {
            $result = $data->where('is_active', $is_active);
        }
        if (!empty($is_share)) {
            $result = $data->where('is_share', $is_share);
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

    public static function SearchOrderDetailProduct($search, $is_share = '', $is_active = '', $limit = 0) {
        $data = static::Where('name', 'like', '%' . $search . '%')
                ->orWhere('link', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%')
                ->orWhere('product_id', 'like', '%' . $search . '%')
                ->orWhere('add_by', 'like', '%' . $search . '%')
                ->orWhere('order_detail_id', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%')
                ->orWhere('discount', 'like', '%' . $search . '%')
                ->orWhere('fees_price', 'like', '%' . $search . '%')
                ->orWhere('fees', 'like', '%' . $search . '%')
                ->orWhere('order_id', 'like', '%' . $search . '%')
                ->orWhere('success_link', 'like', '%' . $search . '%')
                ->orWhere('error_link', 'like', '%' . $search . '%');

        if (!empty($is_active)) {
            $result = $data->where('is_active', $is_active);
        }
        if (!empty($is_share)) {
            $result = $data->where('is_share', $is_share);
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
        $order = OrderDetailProduct::where($colum_value, $colum_value)->orderBy($data_order, 'DESC')->first();
        if (!empty($order)) {
            return $order->$colum;
        } else {
            return 0;
        }
    }

    public static function CountOrderDetailProductMore() {
        $data = OrderDetailProduct::with('products')->select(DB::raw('orders.product_id, count(orders.product_id) AS count_product'))
                ->groupBy('orders.product_id')
                ->get();
        return $data;
    }

    public static function countOrderDetailProductUserShare($order_detail_id, $is_share = 1, $is_active = 1, $limit = 0, $is_bill = -1) {
        $data = static::where('order_detail_id', $order_detail_id)->where('is_share', $is_share)->where('is_active', $is_active);
        if ($is_bill != -1) {
            $result = $data->where('is_bill', $is_bill);
        }
        if ($limit == -1) {
            $result = $data->pluck('product_id', 'product_id')->toArray();
        } elseif ($limit == -2) {
            $result = $data->count();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function countOrderDetailProductUnRead() {
        return static::where('is_read', 0)->count();
    }

    public static function countOrderDetailProductTypeUnRead($fees_price = 'accept') {
        return static::where('fees_price', $fees_price)->where('is_read', 0)->count();
    }

    public static function CountOrderDetailProduct($price, $stateOrderDetailProduct, $fees_price, $is_active, $is_share) {
        $count = OrderDetailProduct::where('price', $stateOrderDetailProduct, $price)->where('fees_price', $fees_price)->where('is_active', $is_active)->where('is_share', $is_share)->count();
        return $count;
    }

    public static function lastMonth($month, $date, $price, $stateOrderDetailProduct, $fees_price, $is_active, $is_share) {
        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$month, $date])->where('price', $stateOrderDetailProduct, $price)->where('fees_price', $fees_price)->where('is_active', $is_active)->where('is_share', $is_share)->get();
        return $count[0]->count;
    }

    public static function lastWeek($week, $date, $price, $stateOrderDetailProduct, $fees_price, $is_active, $is_share) {

        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$week, $date])->where('price', $stateOrderDetailProduct, $price)->where('fees_price', $fees_price)->where('is_active', $is_active)->where('is_share', $is_share)->get();
        return $count[0]->count;
    }

    public static function lastDay($day, $date, $price, $stateOrderDetailProduct, $fees_price, $is_active, $is_share) {
        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$day, $date])->where('price', $stateOrderDetailProduct, $price)->where('fees_price', $fees_price)->where('is_active', $is_active)->where('is_share', $is_share)->get();
        return $count[0]->count;
    }

}
