<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use App\Model\Product;

class CartProduct extends Model {

    protected $table = 'cart_products';
    protected $fillable = [
        'user_id', 'update_by', 'product_id', 'type', 'quantity', 'price', 'discount',
        'description', 'is_read', 'is_active'
    ];

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function product() {
        return $this->belongsTo(\App\Model\Product::class, 'product_id');
    }

    public static function emptySessionproduct_cart() {
        session()->put('session_product_cart', '');
        session()->put('price_product_cart', 0);
    }

    public static function InsertColums($user_id, $data, $type = 'product', $chang_quant = 0) {
        $cart = static::where('user_id', $user_id)->where('product_id', $data['id'])->first();
        $input['quantity'] = $data['quantity'];
        if (isset($data['description'])) {
            $input['description'] = $data['description'];
        }
        if (isset($cart->id)) {
            if ($chang_quant == 0) {
                $input['quantity'] += $cart->quantity;
            }
            $cart->update($input);
            $cart_id = $cart->id;
        } else {
            $input['user_id'] = $user_id;
            $input['update_by'] = $user_id;
            $input['product_id'] = $data['id'];
            $input['type'] = $type;
            $input['price'] = $data['price'];
            $input['discount'] = $data['discount'];
            $input['is_read'] = 0;
            $input['is_active'] = 1;
            $cart = CartProduct::create($input);
            $cart_id = $cart['id'];
        }
        return $cart_id;
    }

    public static function updateColum($id, $colum, $columValue) {
        $data = static::findOrFail($id);
        $data->$colum = $columValue;
        return $data->save();
    }

    public static function updateOrderColum($colum, $valueColum, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->update([$columUpdate => $valueUpdate]);
    }

    public static function countCartProductUnRead() {
        return static::where('is_read', 0)->count();
    }

    public static function countCartProductTypeUnRead($type = 'product') {
        return static::where('type', $type)->where('is_read', 0)->count();
    }

    public static function deleteCartProduct($user_id, $product_id) {
        return self::where('user_id', $user_id)->where('product_id', $product_id)->delete();
    }

    public static function deleteCartUser($user_id) {
        return self::where('user_id', $user_id)->delete();
    }

    public static function getCartProductTypeCount($colum, $columvalue, $type = 'product', $columOrder = 'id', $columvalueOrder = 'DESC', $is_active = 1, $limit = 0) {
        $data = static::where($colum, $columvalue)->where('is_active', $is_active)
                        ->where('type', $type)->orderBy($columOrder, $columvalueOrder)->count();
        return $data;
    }

    public static function getCartProductType($colum, $columvalue, $type = 'product', $columOrder = 'id', $columvalueOrder = 'DESC', $is_active = 1, $limit = 0) {
        $data = static::where($colum, $columvalue)->where('is_active', $is_active);
        $data->where('type', $type)->orderBy($columOrder, $columvalueOrder);
        if ($limit > 6) {
            $result = $data->paginate($limit);
        } elseif ($limit <= 0) {
            $result = $data->get();
        } else {
            $result = $data->limit($limit)->get();
        }

        return $result;
    }

    public static function getCartProductsNotArray($colum, $columvalue, $type = 'product', $limit = 0, $lang, $is_active = '', $col_val = 'lang_id', $offset = 0) {
        $data = static::whereNotIn($colum, $columvalue)->where('type', $type);
        if (!empty($lang)) {
            $result = $data->where('lang', $lang);
        }
        if (!empty($is_active)) {
            $result = $data->where('is_active', $is_active);
        }
        if ($limit > 15) {
            $result = $data->paginate($limit);
        } elseif ($limit > 0) {
            $result = $data->limit($limit)->offset($offset)->pluck($col_val, $col_val)->toArray();
        } elseif ($limit == -1) {
            $result = $data->pluck($col_val, $col_val)->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function productData($id, $column = 'name') {
        $product = static::where('id', $id)->first();
        if (isset($product)) {
            return $product->$column;
        } else {
            return '';
        }
    }

    public static function productDataLang($lang_id, $lang, $column = '') {
        $product = static::where('lang_id', $lang_id)->where('lang', $lang)->first();
        if (!empty($column) && isset($product->$column)) {
            return $product->$column;
        } else {
            return$product;
        }
    }

    public static function productDataUser($id, $column = '') {
        $product = static::with('user')->where('id', $id)->first();
        if (!empty($column)) {
            return $product->$column;
        } else {
            return $product;
        }
    }

    public static function SearchCartProduct($search, $type = 'product', $is_active = '', $limit = 0) {
        $data = static::with('user')->Where('type', 'like', '%' . $search . '%')
                ->orWhere('quantity', 'like', '%' . $search . '%')
                ->orWhere('product_id', 'like', '%' . $search . '%')
                ->orWhere('user_id', 'like', '%' . $search . '%');
        if (!empty($type)) {
            $result = $data->where('type', $type);
        }
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->orderBy('id', 'DESC');
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } elseif ($limit == -1) {
            $result = $data->pluck('id', 'id')->toArray();
        } elseif ($limit == -2) {
            $result = $data->pluck('type', 'id')->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function totalPrice($price, $discount) {
        return conditionPrice(round($price - (($price * $discount) / 100), 2));
    }
    public static function totalPrice_addDiscount($price, $discount) {
        return conditionPrice(round($price + (($price * $discount) / 100), 2));
    }

    public static function lastMonth($month, $date, $type = 'product') {

        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$month, $date])->get();
        return $count[0]->count;
    }

    public static function lastWeek($week, $date, $type = 'product') {

        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$week, $date])->get();
        return $count[0]->count;
    }

    public static function lastDay($day, $date, $type = 'product') {
        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$day, $date])->get();
        return $count[0]->count;
    }

    public static function dataCartProduct($products, $api = 0) {
        $data = ['product_cart' => [], 'total_price_cart' => 0.00];
        foreach ($products as $key => $value) {
            $all_data = static::get_CartProductSingle($value, $api);
            $data['product_cart'][] = $all_data;
            $data['total_price_cart'] += $all_data['total_price'] * $all_data['quantity'];
        }
        return $data;
    }

    public static function get_CartProductSingle($value, $api = 0) {
        $product = Product::get_product('id', $value->product_id);
        $data_value['id'] = $product->id;
        $data_value['lang_id'] = $product->lang_id;
        $data_value['link'] = $product->link;
        $data_value['cat_link'] = $product->categories[0]->link;
        $data_value['cat_name'] = $product->name;
        $data_value['name'] = $product->name;
        $data_value['quantity'] = $value->quantity;
        $data_value['discount'] = $value->discount;
        $data_value['price'] = static::totalPrice_addDiscount($value->price, $value->discount);//$value->price;
        $data_value['total_price'] = $value->price;//static::totalPrice($value->price, $value->discount);
        $data_value['weight'] = $data_value['color'] = $data_value['name_print'] = '';
        $data_value['fees']=[];
        if (!empty($value->description)) {
            $content = json_decode($value->description, true);
            foreach ($content as $key => $val_res) {
                $data_value[$key] = $val_res;
            }
        }
        $data_fees = Fees::feesSelectArrayColTWo('product', 'id', 'link', $data_value['fees'], 1, 0);
        $data_val_fees = Fees::dataFees($data_fees, $api, $data_value['total_price'], 0, 1);
        if (isset($data_value['fees'])) {
            $data_value['fees'] = $data_val_fees['data'];
            $data_value['total_price'] = $data_value['total_price'] + $data_val_fees['total_price_fees'];
        }
        if ($api == 0) {
            $data_value['description'] = $value->description;
        }
        $data_value['image'] = $product->image;
        return $data_value;
    }

}
