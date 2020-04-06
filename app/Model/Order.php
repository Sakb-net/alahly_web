<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Model\Post;
use DB;

class Order extends Model {

    protected $fillable = [
        'user_id', 'add_by', 'post_id', 'match_id', 'name', 'link', 'type', 'source_share', 'type_request',
        'checkoutId', 'transactionId', 'discount', 'price', 'is_share', 'is_bill',
        'is_read', 'is_active', 'code'
    ];

    //type_request-->accept,request,....
    //type-->hyper , free
    //source_share-->site /app  (site_pay - site_free - apple - app_free- app_pay)
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

    public function posts() {
        return $this->belongsTo(\App\Model\Post::class, 'post_id');
    }
    public function match() {
        return $this->belongsTo(\App\Model\Match::class, 'match_id');
    }

    public static function Make_order_link($name_post) {
        $name_post = str_limit($name_post, 20);
        $order_time = str_replace(' ', '_', $name_post . str_random(8));
        $order_link = rand(5, 90) . substr(md5($order_time), 3, 20);
        return $order_link;
    }

    public static function insertOrder($user_id, $post, $add_by = NULL, $type = 'hyperpay', $source_share = 'site_pay', $type_request = 'request', $discount = 0, $is_active = 0, $is_bill = 0, $price = '', $transactionId = NULL) {
        $input['user_id'] = $user_id;
        $input['add_by'] = $add_by;
        $input['post_id'] = $post->lang_id;
        $input['name'] = $post->name;
        $input['link'] = Order::Make_order_link($post->name); //str_replace(' ', '_', $post->name . str_random(8));
        $input['type'] = $type;
        $input['type_request'] = $type_request;
        $input['source_share'] = $source_share;
        if (!empty($price)) {
            $input['price'] = conditionPrice($price);
        } else {
            $input['price'] = Post::totalPrice($post->price, $discount);
        }
        $input['discount'] = conditionDiscount($discount);
        $input['is_active'] = $is_active;
        $input['is_bill'] = $is_bill;
        $input['transactionId'] = $transactionId;
        $order = Order::create($input);
        return $order;
    }

    public static function insertOrderCart($user_id, $post, $add_by = NULL, $type = 'hyperpay', $source_share = 'site_pay', $type_request = 'request', $discount = 0, $is_active = 0, $is_bill = 1, $price = '', $transactionId = NULL, $checkoutId = NULL) {
        $input['user_id'] = $user_id;
        $input['add_by'] = $add_by;
        $input['post_id'] = $post['id'];
        $input['match_id'] = $post['match_id'];
        $input['name'] = $post['name'];
        $input['link'] = Order::Make_order_link($post['name']); //str_replace(' ', '_', $post['name'] . str_random(8));
        $input['type'] = $type;
        $input['type_request'] = $type_request;
        $input['source_share'] = $source_share;
        if (!empty($price)) {
            $input['price'] = conditionPrice($price);
        } else {
            $input['price'] = Post::totalPrice($post['price'], $post['discount']);
        }
        $input['discount'] = conditionDiscount($post['discount']);
        $input['is_active'] = $is_active;
        $input['is_bill'] = $is_bill;
        $input['transactionId'] = $transactionId;
        $input['checkoutId'] = $checkoutId;
        $order = Order::create($input);
        return $order;
    }

    public static function updateOrderBuy($id, $user_id, $total_price, $discount, $is_active = 1, $type_request = 'accept', $type = 'hyperpay', $source_share = 'site_pay') {
        $order = static::findOrFail($id);
        $input['user_id'] = $user_id;
        $input['type'] = $type;
        $input['type_request'] = $type_request;
        $input['source_share'] = $source_share;
        $input['is_active'] = $is_active;
        $input['price'] = $total_price;
        $input['discount'] = $discount;
        $order_update = $order->update($input);
        return $order_update;
    }

    public static function checkout_UpdatePayment($user_id, $checkout_id, $val_order, $is_active, $type, $type_request) {
        // $order = static::where('checkoutId',$checkout_id)->get();
        // 'price' => $val_order['price'],'discount'=>$val_order['discount']
        return static::where('checkoutId', $checkout_id)->where('user_id', $user_id)
                        ->update(['type_request' => $type_request, 'type' => $type, 'is_active' => $is_active]);
    }

    public static function All_checkout_UpdatePayment($user_id, $checkout_id, $array_order, $is_active, $type, $type_request, $code = null) {
        return static::where('checkoutId', $checkout_id)->where('user_id', $user_id)
                        ->update(['type_request' => $type_request, 'type' => $type, 'is_active' => $is_active, 'code' => $code]);
    }

    public static function All_checkout_UpdateFailPayment($user_id, $array_id, $is_bill = 0, $is_active = 0, $is_share = 1) {
        return static::whereIn('id', $array_id)->where('user_id', $user_id)
                        ->update(['is_bill' => $is_bill, 'is_active' => $is_active, 'is_share' => $is_share]);
    }

    public static function updateOrderColumnID($id, $column, $column_value) {
        $order = static::findOrFail($id);
        $order->$column = $column_value;
        return $order->save();
    }

    public static function updateOrderColum($colum, $valueColum, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->update([$columUpdate => $valueUpdate]);
    }

    public static function updateOrderTwoColum($colum, $valueColum, $columTwo, $valueColumTwo, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->where($columTwo, $valueColumTwo)->update([$columUpdate => $valueUpdate]);
    }

    public static function updateOrder($colum, $arrayOrder_id, $columUpdate, $valueUpdate) {
        $result = Order::where($colum, $all_array_id)->update([$columUpdate => $valueUpdate]);
        return $result;
    }

    public static function updateArrayOrder($colum, $arrayOrder_id, $columUpdate, $valueUpdate) {
        $all_array_id = array_values($arrayOrder_id);
        $result = Order::whereIn($colum, $all_array_id)->update([$columUpdate => $valueUpdate]);
        return $result;
    }

    public static function deleteOrderUser($user_id, $post_id = 0) {
        if ($post_id == 0) {
            return self::where('user_id', $user_id)->delete();
        } else {
            return self::where('post_id', $post_id)->where('user_id', $user_id)->delete();
        }
    }

    public static function deleteArrayOrder($colum, $arrayOrder_id) {
        $all_array_id = array_values($arrayOrder_id);
        $result = Order::whereIn($colum, $all_array_id)->delete();
        return $result;
    }

    public static function Check_buy_set($post_id, $is_active = 0, $is_share = 1, $is_bill = 1, $check = 0) {
        $order = Order::where('post_id', $post_id)
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
    public static function Check_buy_setMatch($post_id,$match_id, $is_active = 0, $is_share = 1, $is_bill = 1, $check = 0) {
        $order = Order::where('post_id', $post_id)->where('match_id', $match_id)
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

    public static function get_LastRowShare($user_id, $post_id, $data_order = 'id') {
        $order = Order::where('user_id', $user_id)->where('post_id', $post_id)->orderBy($data_order, 'DESC')->first();
        return $order;
    }

    public static function Check_NOTComplete_BuyCourse($post_id, $user_id, $is_active = 0, $is_share = 1, $type_request = 'request', $colum_name = '') {
        $data = static::where('post_id', '=', $post_id)
                ->where('user_id', '=', $user_id)
                ->where('is_active', '=', $is_active)
                ->where('type_request', $type_request)
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

    public static function CheckFoundOrderACtiveShare($user_id, $post_id, $is_share = 1, $is_active = 1, $arrayColume = []) {
        if (!empty($user_id)) {
            $order = static::where('user_id', $user_id);
        } else {
            $order = static::with('user');
        }
        $data = $order->where('post_id', $post_id)->where('is_share', $is_share)->where('is_active', $is_active);
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

    public static function Order_BuyLink($post_id, $user_id, $order_link, $is_active = 1) {
        $data = static::where('post_id', '=', $post_id)->where('user_id', '=', $user_id)
                ->Where('link', $order_link);
        $result = $data->first();
        return $result;
    }

    public static function CheckBuyCart($post_id, $user_id, $is_active = 1, $is_share = 1, $check_share = 1) {
        $data = static::where('post_id', '=', $post_id)->where('user_id', '=', $user_id)->where('is_active', '=', $is_active);
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

    public static function CheckShare($id, $post_id, $user_id) {
        return static::where('id', '>', $id)->where('post_id', '=', $post_id)->where('user_id', '=', $user_id)->get();
    }

    public static function get_UserOrderShareActive($user_id, $is_active = 1, $is_share = 1, $type_request = '', $limit = 0) {
        $data = Order::where('user_id', $user_id)->where('is_active', $is_active)->where('is_share', $is_share);
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

    public static function get_OrderShareActive($is_active = 1, $is_share = 1, $type_request = '', $limit = 0) {
        $data = Order::with('user')->where('is_active', $is_active)->where('is_share', $is_share);
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

    public static function get_OrderRangeDate($start_date = '', $end_date = '', $post_id = -1, $is_active = '') {
        $data = Order::with('posts')->whereBetween('created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
        if (!empty($is_active)) {
            $result = $data->where('is_active', $is_active);
        }
        if ($post_id > 0) {
            $result = $data->where('post_id', $post_id);
        }
        $result = $data->get();
        return $result;
    }

    public static function get_OrderPostActive($post_id, $is_active = '') {
        $data = Order::where('post_id', $post_id);
        if (!empty($is_active)) {
            $count = $data->where('is_active', $is_active);
        }
        $count = $data->count();
        return $count;
    }

    public static function get_orderChairCategory($user_id, $category_id, $is_active = '', $is_share = '', $limit = 0) {
//                ->select('orders.id', 'orders.name','orders.user_id','orders.post_id', 'orders.is_share', 'posts.type_cost')
        $data = Order::with('user')->leftJoin('posts', 'posts.id', '=', 'orders.post_id')
                ->leftJoin('category_post', 'posts.id', '=', 'category_post.post_id')
                ->select('orders.*', 'posts.*')
                ->where('category_post.category_id', $category_id);
        if (!empty($user_id)) {
            $result = $data->where('orders.user_id', $user_id);
        }
        if (!empty($is_active)) {
            $result = $data->where('orders.is_active', $is_active);
        }
        if (!empty($is_share)) {
            $result = $data->where('orders.is_share', $is_share);
        }
        if ($limit == -1) {
            $result = $data->pluck('orders.post_id', 'orders.post_id')->toArray();
        } elseif ($limit == -2) {
            $result = $data->count();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_orderChairCategoryMatch($user_id, $category_id, $match_id, $is_active = '', $is_share = '', $limit = 0) {
//                ->select('orders.id', 'orders.name','orders.user_id','orders.post_id', 'orders.is_share', 'posts.type_cost')
        $data = Order::with('user')->leftJoin('posts', 'posts.id', '=', 'orders.post_id')
                ->leftJoin('category_post', 'posts.id', '=', 'category_post.post_id')
                ->select('orders.*', 'posts.*')
                ->where('category_post.category_id', $category_id);
        if (!empty($user_id)) {
            $result = $data->where('orders.user_id', $user_id);
        }
        if (!empty($is_active)) {
            $result = $data->where('orders.is_active', $is_active);
        }
        if (!empty($is_share)) {
            $result = $data->where('orders.is_share', $is_share);
        }
        $result = $data->where('orders.match_id', $match_id);
        if ($limit == -1) {
            $result = $data->pluck('orders.post_id', 'orders.post_id')->toArray();
        } elseif ($limit == -2) {
            $result = $data->count();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_OrderRangeDatePost($start_date = '', $end_date = '', $post_id, $is_active = '') {
//                ->select('orders.id', 'orders.name','orders.user_id','orders.post_id', 'orders.is_share', 'posts.type_cost')
        $data = Order::with('user')->leftJoin('posts', 'posts.id', '=', 'orders.post_id')
                ->select('orders.*', 'posts.*')
                ->whereBetween('orders.created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
//        $data = Order::with('user')->with('posts')
//                ->whereBetween('orders.created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
        if ($post_id == -1 || in_array(-1, $post_id)) {
            //get all order for courses
            $post_id = -1;
        } elseif ($post_id == -2 || in_array(-2, $post_id)) {
            $post_id = -2;
            $result = $data->where('posts.type_cost', 'free');
        } elseif ($post_id == -3 || in_array(-3, $post_id)) {
            $post_id = -3;
            $result = $data->where('posts.type_cost', '<>', 'free');
        } else { //if ($post_id > 0)
            $result = $data->whereIn('orders.post_id', $post_id);
        }
        if (!empty($is_active)) {
            $result = $data->where('orders.is_active', $is_active);
        }
        $result = $data->get();
        return $result;
    }

    public static function get_BestOrderRangeDate($start_date = '', $end_date = '', $limit = 0, $is_active = '', $is_share = '', $user = '') {
        $data = Order::with('posts')
                        ->whereBetween('created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"])
                        ->groupBy('post_id')->select('post_id', DB::raw('count(*) as total_post_id'));
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

    public static function SearchOrder($search, $is_share = '', $is_active = '', $limit = 0) {
        $data = static::Where('name', 'like', '%' . $search . '%')
                ->orWhere('link', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%')
                ->orWhere('post_id', 'like', '%' . $search . '%')
                ->orWhere('add_by', 'like', '%' . $search . '%')
                ->orWhere('user_id', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%')
                ->orWhere('discount', 'like', '%' . $search . '%')
                ->orWhere('type_request', 'like', '%' . $search . '%')
                ->orWhere('source_share', 'like', '%' . $search . '%')
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
        $order = Order::where($colum_value, $colum_value)->orderBy($data_order, 'DESC')->first();
        if (!empty($order)) {
            return $order->$colum;
        } else {
            return 0;
        }
    }

    public static function CountOrderMore() {
        $data = Order::with('posts')->select(DB::raw('orders.post_id, count(orders.post_id) AS count_post'))
                ->groupBy('orders.post_id')
                ->get();
        return $data;
    }

    public static function countOrderUserShare($user_id, $is_share = 1, $is_active = 1, $limit = 0, $is_bill = -1) {
        $data = static::where('user_id', $user_id)->where('is_share', $is_share)->where('is_active', $is_active);
        if ($is_bill != -1) {
            $result = $data->where('is_bill', $is_bill);
        }
        if ($limit == -1) {
            $result = $data->pluck('post_id', 'post_id')->toArray();
        } elseif ($limit == -2) {
            $result = $data->count();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function countOrderUnRead() {
        return static::where('is_read', 0)->count();
    }

    public static function countOrderTypeUnRead($type_request = 'accept') {
        return static::where('type_request', $type_request)->where('is_read', 0)->count();
    }

    public static function CountOrder($price, $stateOrder, $type_request, $is_active, $is_share) {
        $count = Order::where('price', $stateOrder, $price)->where('type_request', $type_request)->where('is_active', $is_active)->where('is_share', $is_share)->count();
        return $count;
    }

    public static function lastMonth($month, $date, $price, $stateOrder, $type_request, $is_active, $is_share) {
        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$month, $date])->where('price', $stateOrder, $price)->where('type_request', $type_request)->where('is_active', $is_active)->where('is_share', $is_share)->get();
        return $count[0]->count;
    }

    public static function lastWeek($week, $date, $price, $stateOrder, $type_request, $is_active, $is_share) {

        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$week, $date])->where('price', $stateOrder, $price)->where('type_request', $type_request)->where('is_active', $is_active)->where('is_share', $is_share)->get();
        return $count[0]->count;
    }

    public static function lastDay($day, $date, $price, $stateOrder, $type_request, $is_active, $is_share) {
        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$day, $date])->where('price', $stateOrder, $price)->where('type_request', $type_request)->where('is_active', $is_active)->where('is_share', $is_share)->get();
        return $count[0]->count;
    }

}
