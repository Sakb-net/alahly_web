<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use \Illuminate\Support\Facades\View;
use App\Model\Role;
use App\Model\UserMeta;
use App\Model\Options;
use DB;
use Mail;

class User extends Authenticatable {

    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'display_name', 'image', 'access_token', 'address', 'city', 'state',
        'phone', 'is_active','device_id', 'fcm_token', 'state_fcm_token', 'gender',
        'lang', 'reg_site', 'session', 'jop',
    ];
//state_send
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userMeta() {
        return $this->hasMany(\App\Model\UserMeta::class);
    }

    public function categories() {
        return $this->hasMany(\App\Model\Category::class);
    }

    public function posts() {
        return $this->hasMany(\App\Model\Post::class);
    }

    public function actions() {
        return $this->hasMany(\App\Model\Action::class);
    }

    public function comments() {
        return $this->hasMany(\App\Model\Comment::class);
    }

    public function UserNotif() {
        return $this->hasMany(\App\Model\UserNotif::class);
    }

    public static function addCreate($request, $user_role = '', $display_name, $email, $password, $phone,$fcm_token = NULL,$device_id=NULL,$reg_site='site', $address = null, $city = null, $state = null) {
        if (empty($user_role)) {
            $user_role = Options::where('option_key', 'default_role')->value('option_value');
        }
//        $this->validator($request->all())->validate();
        $user = User::insertUser($display_name, $email, $password, $phone, $fcm_token,$device_id,$reg_site, $address, $city, $state);
        $user->attachRole($user_role);
//        $this->guard()->login($user);
        return $user;
    }

    public static function insertUser($display_name, $email, $password, $phone, $fcm_token = NULL,$device_id=NULL,$reg_site='site', $address = null, $city = null, $state = null) {
        $user_active = Options::where('option_key', 'user_active')->value('option_value');
        $is_active = is_numeric($user_active) ? $user_active : 0;
        $user_name = explode('@', $email);
        $user_reg = User::create([
                    'display_name' => $display_name,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'name' => (str_replace(' ', '_', $user_name[0] . time())), //str_random(8)
                    'phone' => $phone,
                    'image' => generateDefaultImage($display_name),
                    'access_token' => generateRandomToken(),
                    'fcm_token' => $fcm_token,
                    'device_id' => $device_id,
                    'reg_site' => $reg_site,
                    'address' => $address,
                    'city' => $city,
                    'state' => $state,
                    'is_active' => $is_active,
        ]);
        return $user_reg;
    }

    public static function updateColum($id, $colum, $columValue) {
        $data = static::findOrFail($id);
        $data->$colum = $columValue;
        return $data->save();
    }

    public static function updateColumTwo($id, $colum, $columValue, $colum2, $columValue2) {
        $data = static::findOrFail($id);
        $data->$colum = $columValue;
        $data->$colum2 = $columValue2;
        return $data->save();
    }

    public static function updateColumThree($id, $colum, $columValue, $colum2, $columValue2, $colum3, $columValue3) {
        $data = static::findOrFail($id);
        $data->$colum = $columValue;
        $data->$colum2 = $columValue2;
        $data->$colum3 = $columValue3;
        return $data->save();
    }

    public function isActive() {
        return Auth::user()->is_active == 1;
    }

    public static function userData($id, $column = '') {
        $user = static::where('id', $id)->first();
        if (!empty($column)) {
            if (isset($user->id)) {
                return $user->$column;
            } else {
                return '';
            }
        } else {
            return $user;
        }
    }

    public static function foundUser($name, $column = 'name', $limit = -1) {
        $user = static::where($column, $name)->first();
        if ($limit == -1) {
            if (isset($user)) {
                return $user->id;
            } else {
                return 0;
            }
        } else {
            return $user;
        }
    }

    public function userID($id, $column = '') {
        $user = static::where('id', $id)->first();
        if (!empty($column)) {
            if (isset($user->id)) {
                return $user->$column;
            } else {
                return '';
            }
        } else {
            return $user;
        }
    }

    public static function GetByColumValue($col_name, $col_val, $api = 0) {
        $data = static::where($col_name, $col_val)->first();
        return $data;
    }

    public static function user_access_token($access_token, $is_active = 1, $column = '') {
        $user = static::where('access_token', $access_token)->where('is_active', $is_active)->first();
        if (!empty($column)) {
            if (isset($user->id)) {
                return $user->$column;
            } else {
                return '';
            }
        } else {
            return $user;
        }
    }

    public static function get_searchUser($search, $is_active = '', $limit = 0, $post = '', $bundle = '') {
        $data = static::Where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('display_name', 'like', '%' . $search . '%')
                ->orWhere('image', 'like', '%' . $search . '%')
                ->orWhere('address', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('gender', 'like', '%' . $search . '%');
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        if (!empty($is_active)) {
            $result = $data->where('is_active', $is_active);
        }
        if (!empty($post)) {
            $result = $data->with('posts');
        }
        if (!empty($bundle)) {
            $result = $data->with('bundles');
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

    public static function lastMonth($month, $date) {

        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$month, $date])->get();
        return $count[0]->count;
    }

    public static function lastWeek($week, $date) {

        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$week, $date])->get();
        return $count[0]->count;
    }

    public static function lastDay($day, $date) {

        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$day, $date])->get();
        return $count[0]->count;
    }

//**********************************send email*****************************************************************
    public static function DeleteImageAWs($data=null) {
        return true;
    }
    public static function SelectCoulumUser($data_user) {
        $user['display_name'] = $data_user->display_name;
        $user['email'] = $data_user->email;
        $user['access_token'] = $data_user->access_token;
        $user['image'] = $data_user->image;
        $user['phone'] = $data_user->phone;
        $user['gender']=$data_user->gender;
        $user['address']=countryName($data_user->address);
        $user['city']=cityName($data_user->city);
        $user['state']=$data_user->state;
        return $user;
    }
    public static function sessionLang($user_id) {
        $get_locale = session()->get('locale');
        if (!empty($get_locale)) {
            User::updateColum($user_id, 'lang', $get_locale);
//            session()->forget('locale');
        }
        return true;
    }

    public static function SendEmailTOUser($user_id, $type, $message_share = '', $array_data = [], $total_price = 0.00, $discount = 0.00, $title_contact = '') {
//        $default_server = 'https://' . $_SERVER['SERVER_NAME'];
//        $site_url = $default_server . route('home');
        //$phone = Options::where('option_key', 'phone')->value('option_value');
        $site_url = $phone = $site_title = $site_open = $site_email = $facebook = $twitter = $google = $linkedin = '';
        $array_option_key = ['facebook', 'twitter', 'googleplus', 'linkedin', 'site_email', 'site_title', 'site_url', 'phone', 'site_open', 'logo_image'];
        $All_options = Options::get_Option('setting', $array_option_key);
        foreach ($All_options as $key => $value) {
            $$key = $value;
        }
        if (empty($site_email)) {
            $site_email = 'social@Site.com';
        }
        $inside = 0;
        //**************************************************
        $user_data = User::userData($user_id);
        if (isset($user_data->id)) {
            $user_name = $user_data->display_name;
            $user_email = $user_data->email;
        } else {
            if ($type == 'contact_form') {
                $user_name = $array_data['name'];
                $user_email = $array_data['email'];
            }
        }
        //**************************************************
        $array_email_data = array(
            'user_name' => $user_name,
            'user_email' => $user_email,
            'site_email' => $site_email,
            'phone' => $phone,
            'type' => $type,
            'site_url' => $site_url,
            'facebook' => $facebook,
            'twitter' => $twitter,
            'google' => $google,
            'linkedin' => $linkedin,
            'message' => ''
        );
        //*************************    
        $subject = 'Master';
        if ($type == 'register') {
            $subject = 'Register In Master';
        } elseif ($type == 'contact_form') {
            $inside = 1;
            $type = 'message';
            $subject = 'Contact Us';
            $array_email_data['message_share'] = $message_share;
            if (!isset($user_data->id)) {
                $array_email_data['user_email'] = $user_email = $array_data['email'];
                $array_email_data['user_name'] = $user_name = $array_data['name'];
            }
        } elseif ($type == 'replay_contact') {
            $type = 'message';
            $subject = 'Contact Us';
            if (!empty($title_contact)) {
                $subject = $title_contact;
            }
            $array_email_data['message_share'] = $message_share;
            $array_email_data['user_email'] = $user_email = $array_data->email;
            $array_email_data['user_name'] = $user_name = $array_data->eman;
        }
        //$array_email_data = [];
        if ($inside == 1) {
            Mail::send('emails.' . $type, $array_email_data, function($message) use ($site_email, $user_email, $site_title, $subject) {
                $message->from($user_email);
                $message->to($site_email, $site_title)->subject($subject);
            });
        } else {
            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL) === false) {
                Mail::send('emails.' . $type, $array_email_data, function($message) use ($site_email, $user_email, $site_title, $subject) {
                    $message->from($site_email);
                    $message->to($user_email, $site_title)->subject($subject);
                });
            }
        }
        return True;
    }

//***************************************************************************************************
//   public function comment()
//   {
//   	return $this->hasMany(App\Model\Comment::class);
//   }
}
