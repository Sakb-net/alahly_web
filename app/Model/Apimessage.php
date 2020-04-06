<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Apimessage extends Model {

    protected $table = 'messages';
    protected $fillable = [
        'ar_message', 'en_message', 'type'
    ];

//type_price --> num,%

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

    public static function foundtype($en_message, $type = "main") {
        $en_message_found = static::where('type', $type)->first();
        if (isset($en_message_found)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function DataLangAR($lang_id) {
        $data = static::where('lang_id', $lang_id)->where('lang', '<>', 'ar')->get();
        return $data;
    }

    public static function get_messageID($id, $colum) {
        $message = Apimessage::where('id', $id)->first();
        return $message->$colum;
    }

    public static function get_messageData($val_col, $colum = 'id') {
        $message = Apimessage::where($colum, $val_col)->first();
        return $message;
    }

    public static function messageSelect($price, $type, $colum, $columValue, $is_active = 1, $array = 1, $order_col = 'id', $type_order = 'ASC') {
        $data = Apimessage::where('type', $type)->where('price', $price)
                ->where('is_active', $is_active);
        if (!empty($colum)) {
            $message = $data->where($colum, $columValue);
        }
        $message = $data->orderBy($order_col, $type_order);
        if ($array == 1) {
            $message = $data->pluck('id', 'ar_message')->toArray();
        } else {
            $message = $data->get();
        }
        return $message;
    }

    public static function messageSelectArrayCol($type, $colum, $columValue = [], $is_active = 1, $array = 1) {
        $data = Apimessage::where('type', $type)->whereIn($colum, $columValue)->where('is_active', $is_active);
        if ($array == 1) {
            $message = $data->pluck('id', 'ar_message')->toArray();
        } else {
            $message = $data->get();
        }
        return $message;
    }

    public static function get_message_ISActive($is_active, $array = 0) {
        $data = Apimessage::where('is_active', $is_active);
        if ($array == 1) {
            $result = $data->pluck('id', 'ar_message')->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_LastRow($type, $price = NULL, $lang = 'ar', $colum, $data_order = 'discount') {
        $message = Apimessage::where('lang', $lang)->where('type', $type)->where('price', $price)->orderBy($data_order, 'DESC')->first();
        if (!empty($message)) {
            return $message->$colum;
        } else {
            return 0;
        }
    }

    public static function SearchApimessage($search, $is_active = '', $limit = 0) {
        $data = static::Where('ar_message', 'like', '%' . $search . '%')
                ->orWhere('en_message', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%');
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

    public static function dataApimessage($message, $api = 0) {
        $data = [];
        foreach ($message as $key => $value) {
            $data[] = static::get_ApimessageSingle($value, $api);
        }
        return $data;
    }

    public static function get_ApimessageSingle($value, $api = 0) {
//            $data_value['id'] =$value->id;
        $data_value['en_message'] = $value->en_message;
        $data_value['ar_message'] = $value->ar_message;
        $data_value['type'] = $value->type;
        return $data_value;
    }

}
