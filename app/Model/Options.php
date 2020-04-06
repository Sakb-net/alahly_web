<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;

class Options extends Model {

    protected $table = 'options';
    public $timestamps = false;
    protected $fillable = [
        'option_type', 'option_key', 'option_value', 'option_etc', 'option_group', 'autoload'
    ];

    public static function insertOption($option_type, $option_key, $option_value, $autoload = 1, $option_group = NULL, $option_etc = NULL) {
        $input['option_type'] = $option_type;
        $input['option_key'] = $option_key;
        $input['option_value'] = $option_value;
        $input['option_etc'] = $option_etc;
        $input['option_group'] = $option_group;
        $input['autoload'] = $autoload;
        return Options::create($input);
    }

    public static function updateOption($option_key, $option_value, $autoload = 1, $option_group = NULL, $option_etc = NULL) {
        $option = static::where('option_type', $option_key)->where('option_key', $option_key)->first();
        $input['option_type'] = $option_key;
        $input['option_key'] = $option_key;
        $input['option_value'] = $option_value;
        $input['option_etc'] = $option_etc;
        $input['option_group'] = $option_group;
        $input['autoload'] = $autoload;
        if (isset($option->option_value)) {
            return $option->update($input);
        } else {
            return Options::create($input);
        }
    }

    public function deleteOption($option_type) {
        return static::where('option_type', $option_type)->delete();
    }

    public function deleteOptionGroup($option_group) {
        return Options::where('option_group', $option_group)->delete();
    }

    public static function Site_Option() {
        $pagi_limit = 15;
        $data_site = [
            'limit' => $pagi_limit,
            'site_title' => '',
            'site_url' => '',
            'site_open' => 0,
            'logo_image' => '',
            'current_id' => 0,
            'admin_panel' => 0,
            'user_key' => '',
            'user_email' => '',
            'lang' => 'ar', // Language::currentLang(), //Language::currentLang(0)
        ];
        $array_option_key = ['pagi_limit', 'site_title', 'site_url', 'site_open'];
        $All_options = Options::get_Option('setting', $array_option_key, 1);
        foreach ($All_options as $key => $value) {
            $data_site[$key] = $value;
        }
        $data_site['limit'] = is_numeric($data_site['pagi_limit']) ? $data_site['pagi_limit'] : 15;
//        $user_account = Auth::user();
//        if (!empty($user_account)) {
//            $data_site['current_id'] = $user_account->id;
//            $data_site['user_key'] = $user_account->name;
//            $data_site['user_email'] = $user_account->email;
//            if ($user_account->can(['access-all', 'post-type-all', 'post-all'])) {
//                $data_site['admin_panel'] = 1;
//            }
//            $get_session = session()->get('session_user');
//            if ($user_account->is_active == 0 || $user_account->session != $get_session) {
//                Auth::logout();
//                return redirect(route('home'));
//            }
//        }
        return $data_site;
    }

    public static function get_Option($option_group, $array_option_key, $array = 0) {
        if ($array == 1) {
            $options = Options::whereIn('option_key', $array_option_key)->pluck('option_value', 'option_key')->toArray();
        } else {
            $options = Options::whereIn('option_key', $array_option_key)->get();
        }
        return $options;
    }

    public static function Allget_Option($option_group, $array_option_key) {
//         whereIn('option_group', $option_group)->
        $options = Options::whereIn('option_key', $array_option_key)->get();
        return $options;
    }

}
