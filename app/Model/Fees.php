<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fees extends Model {

    protected $table = 'fees';
    protected $fillable = [
        'name', 'link', 'type', 'content', 'price', 'discount', 'user_id', 'type_price',
        'is_active'
    ];

//type_price --> num(value),%(persent)

    public function user() {
        return $this->belongsToMany(\App\User::class);
    }

    public function tags() {
        return $this->morphToMany(\App\Model\Tag::class, 'taggable');
    }

    public static function updateColum($id, $colum, $columValue) {
        $data = static::findOrFail($id);
        $data->$colum = $columValue;
        return $data->save();
    }

    public static function updateOrderColum($colum, $valueColum, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->update([$columUpdate => $valueUpdate]);
    }

    public static function foundLink($link, $type = "main") {
        $link_found = static::where('link', $link)->where('type', $type)->first();
        if (isset($link_found)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function DataLangAR($lang_id) {
        $data = static::where('lang_id', $lang_id)->where('lang', '<>', 'ar')->get();
        return $data;
    }

    public static function get_feesID($id, $colum) {
        $fees = Fees::where('id', $id)->first();
        return $fees->$colum;
    }

    public static function get_feesRow($id, $colum = 'id', $is_active = 1) {
        $fees = Fees::where($colum, $id)->where('is_active', $is_active)->first();
        return $fees;
    }

    public static function feesSelect($price, $type, $colum, $columValue, $is_active = 1, $array = 1, $order_col = 'id', $type_order = 'ASC') {
        $data = Fees::where('type', $type)->where('price', $price)
                ->where('is_active', $is_active);
        if (!empty($colum)) {
            $fees = $data->where($colum, $columValue);
        }
        $fees = $data->orderBy($order_col, $type_order);
        if ($array == 1) {
            $fees = $data->pluck('id', 'name')->toArray();
        } else {
            $fees = $data->get();
        }
        return $fees;
    }

    public static function feesSelectArrayCol($type, $colum, $columValue = [], $is_active = 1, $array = 1) {
        $data = Fees::where('type', $type)->whereIn($colum, $columValue)->where('is_active', $is_active);
        if ($array == 1) {
            $fees = $data->pluck('id', 'name')->toArray();
        } else {
            $fees = $data->get();
        }
        return $fees;
    }

    public static function feesSelectArrayColTWo($type, $colum, $colum2, $columValue = [], $is_active = 1, $array = 1) {
        $data = Fees::where('type', $type)->where('is_active', $is_active)
                        ->whereIn($colum, $columValue)->orwhereIn($colum2, $columValue);
        if ($array == 1) {
            $fees = $data->pluck('id', 'name')->toArray();
        } else {
            $fees = $data->get();
        }
        return $fees;
    }

    public static function get_fees_ISActive($is_active, $array = 0, $no_array_id = [], $yes_array_id = []) {
        $data = Fees::where('is_active', $is_active);
        if (!empty($no_array_id)) {
            $result = $data->wherenotIn('id', $no_array_id);
        }
        if (!empty($yes_array_id)) {
            $result = $data->whereIn('id', $yes_array_id);
        }
        if ($array == 1) {
            $result = $data->pluck('id', 'name')->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_LastRow($type, $price = NULL, $lang = 'ar', $colum, $data_order = 'discount') {
        $fees = Fees::where('lang', $lang)->where('type', $type)->where('price', $price)->orderBy($data_order, 'DESC')->first();
        if (!empty($fees)) {
            return $fees->$colum;
        } else {
            return 0;
        }
    }

    public static function SearchFees($search, $is_active = '', $limit = 0) {
        $data = static::Where('name', 'like', '%' . $search . '%')
                ->orWhere('link', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%')
                ->orWhere('discount', 'like', '%' . $search . '%')
                ->orWhere('user_id', 'like', '%' . $search . '%')
                ->orWhere('discount', 'like', '%' . $search . '%');

        if (!empty($is_active)) {
            $result = $data->where('is_active', $is_active);
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

//***********************************************************************

    public static function dataFees($fees, $api = 0, $total_price_cart = 0, $total_price_fees = 0, $array = 0) {
        $data = [];
        foreach ($fees as $key => $value) {
            $data_fees = static::get_FeesSingle($value, $api, $total_price_cart);
            $total_price_fees += $data_fees['total_price'];
            $data[]=$data_fees;
        }
        if ($array == 1) {
            return array('data' => $data, 'total_price_fees' => $total_price_fees);
        } else {
            return $data;
        }
    }

    public static function get_FeesSingle($value, $api = 0, $total_price_cart = 0) {
        $data_value['id'] = $value->id;
        $data_value['link'] = $value->link;
        $data_value['name'] = $value->name;
        $data_value['type_price'] = $value->type_price;
        $data_value['price'] = $value->price;
        $data_value['total_price'] = $value->price;  //$value->type_price == 'value'
        if ($total_price_cart > 0 && $value->type_price == 'persent') {
            $data_value['total_price'] = round($total_price_cart * ($value->price / 100), 2);
        }
//            $data_value['discount'] =$value->discount;
        return $data_value;
    }

    public static function get_FeesTotalPrice($data, $api = 0, $total_price_cart = 0) {
        foreach ($data as $key_fees => $val_fees) {
            $total_price_fees = $val_fees->price;  //$value->type_price == 'value'
            if ($total_price_cart > 0 && $val_fees->type_price == 'persent') {
                $total_price_fees = round($total_price_cart * ($val_fees->price / 100), 2);
            }
            $total_price_cart += $total_price_fees;
        }
        return $total_price_cart;
    }

}
