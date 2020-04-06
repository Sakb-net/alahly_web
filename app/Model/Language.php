<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use Config;
//use App\User;
use Auth;
class Language extends Model {

    protected $table = 'languages';
    protected $fillable = [
        'name', 'lang', 'user_id', 'is_active',
    ];

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function insertLanguage($user_id, $name, $lang, $is_active = 1) {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->lang = $lang;
        $this->is_active = $is_active;
        return $this->save();
    }

    public static function updateLanguage($id, $name, $lang, $is_active = 1) {
        $language = static::findOrFail($id);
        $language->name = $name;
        $language->lang = $lang;
        $language->is_active = $is_active;
        return $language->save();
    }

    public static function foundLink($lang) {
        $lang_found = static::where('lang', $lang)->first();
        if (isset($lang_found)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function updateLanguageLang($id, $lang) {
        $language = static::findOrFail($id);
        $language->lang = $lang;
        return $language->save();
    }

    public static function updateLanguageActive($id, $is_active = 1) {
        $language = static::findOrFail($id);
        $language->is_active = $is_active;
        return $language->save();
    }
    public static function currentLang($ask=1) {
        $cuRRlocal = 'ar';
            if (Auth::user()) {
                $cuRRlocal = Auth::user()->lang;
            } elseif ($cuRRlocal = Session::has('locale')) {
                $cuRRlocal = Session::get('locale');
            } else {
                $cuRRlocal = Config::get('app.locale');
            }
            //***************Note: delete this condition when join post with lang*************
            if($ask==1){
                $cuRRlocal = 'ar';
            }
            //***********************************
        return $cuRRlocal;
    }

    public static function get_Languag($colum, $columValue, $valueArray = '', $is_array = 0) {
        $data = Language::where('lang', '<>', 'ar')->where($colum, $columValue)->get();
        if ($is_array == 1) {
            $language =$data->pluck($valueArray,'id')->toArray();
        } else {
            $language = $data->get();
        }
        return $language;
    }

    public static function SearchLanguage($search, $is_active = '', $limit = 0) {
        $data = static::Where('name', 'like', '%' . $search . '%')
                ->orWhere('lang', 'like', '%' . $search . '%')
                ->orWhere('user_id', 'like', '%' . $search . '%');
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

}
