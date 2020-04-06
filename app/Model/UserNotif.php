<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Emoji;

class UserNotif extends Model {

    protected $table = 'notifications';
    protected $fillable = [
        'from_id', 'to_id', 'type_id', 'type', 'notif_id', 'is_active',
        'notif_type', 'data', 'is_read', 'state_hiden', 'display_name', 'emoji'
    ];

//type_id --->  $post->id -->according state notif_type
//type ---> $post->type--> (course,chapter,lecture)
//notif_id ---> according state notif_type
//notif_type ---> comment,question,note,add_course,add_chapter,add_lecture

    public function user() {
        return $this->belongsTo(\App\User::class, 'from_id');
    }

    public function Touser() {
        return $this->belongsTo(\App\User::class, 'to_id');
    }

    public function posts() {
        return $this->belongsTo(\App\Model\Post::class, 'type_id');
    }

    public function postNotif() {
        return $this->belongsTo(\App\Model\Post::class, 'notif_id');
    }

    public function commentNotif() {
        return $this->belongsTo(\App\Model\Comment::class, 'notif_id');
    }

    public static function deleteDataTable($type_id, $type) {
        return static::where('type_id', $type_id)->where('type', $type)->delete();
    }

    public static function deleteDataTableNotif($notif_id, $notif_type) {
        return static::where('notif_id', $notif_id)->where('notif_type', $notif_type)->delete();
    }

    public static function insert_SendNotification($all_user, $table, $from_user_id, $type_id, $type, $notif_type, $notif_id, $data, $is_read, $is_active) {
        $responsefirbase = 0;
        if (isset($value_user[0]->id)) {
            foreach ($all_user as $value_user) {
                $to_user_id = $value_user->id;
                if ($from_user_id != $to_user_id) {
                    $insert_notif = UserNotif::AddNotification($from_user_id, $to_user_id, $type_id, $type, $notif_type, $notif_id, $data, $is_read, $is_active);
                    $message = Emoji::Decode($data);
                    $title = $table->user->display_name . ' : ' . $table->name;
                    $responsefirbase = UserNotif::SendNotiFSubscribe($value_user, $title, $message, $table->id, $table->name);
                }
            }
        }
        return $responsefirbase;
    }

    public static function AddNotification($from_user_id, $to_user_id, $type_id, $type, $notif_type, $notif_id, $data, $is_read, $is_active) {
        if (empty($from_user_id) || $from_user_id == 0) {
            $from_user_id = NULL;
        }
        $inputNotif['from_id'] = $from_user_id;
        $inputNotif['to_id'] = $to_user_id;
        $inputNotif['type_id'] = $type_id;
        $inputNotif['type'] = $type;
        $inputNotif['notif_type'] = $notif_type;
        $inputNotif['notif_id'] = $notif_id;
        $inputNotif['data'] = $data;
        $inputNotif['is_read'] = $is_read;
        $inputNotif['is_active'] = $is_active;
        $insert_notif = UserNotif::create($inputNotif);
        return $insert_notif;
    }

    public static function updateUserNotifActive($id, $colum = 'is_active', $col_val = 1) {
        $data = static::findOrFail($id);
        $data->$colum = $col_val;
        return $data->save();
    }

    public static function updateOrderColum($colum, $valueColum, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->update([$columUpdate => $valueUpdate]);
    }

    public static function updateOrderColumTwo($colum, $valueColum, $colum2, $valueColum2, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->whereIn($colum2, $valueColum2)->update([$columUpdate => $valueUpdate]);
    }

    public static function SendNotiFSubscribe($user, $title, $message, $array_action, $name) {
        $responsefirbase = 0;
        $found_token = $user->fcm_token;
        if (!empty($found_token) && $user->state_fcm_token == 1) {
            //send notification
            $responsefirbase = sendPushNotification($found_token, $array_action, $message, $title);
        }
        return $responsefirbase;
    }

    public static function foundLink($type = "post") {
        $type_found = static::where('type', $type)->first();
        if (isset($type_found)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function get_LastRow($colum, $data_order = 'notif_type') {
        $data = UserNotif::orderBy($data_order, 'DESC')->first();
        if (!empty($bundle)) {
            return $data->$colum;
        } else {
            return 0;
        }
    }

    public static function get_UserNotifID($id, $to_id, $is_active = 1, $is_read = -1, $type = '') {
        $data = UserNotif::Where('id', $id)->Where('to_id', $to_id)->Where('is_active', $is_active)->
                orderBy('id', 'DESC');
        if ($is_read != -1) {
            $data->Where('is_read', $is_read);
        }
        if (!empty($type)) {
            $data->Where('type', $type);
        }
        $result = $data->first();
        return $result;
    }

    public static function get_UserNotif($to_id, $is_active = 1, $is_read = -1, $type = '') {
        $data = UserNotif::Where('to_id', $to_id)->Where('is_active', $is_active)->
                orderBy('id', 'DESC');
        if ($is_read != -1) {
            $data->Where('is_read', $is_read);
        }
        if (!empty($type)) {
            $data->Where('type', $type);
        }
        $result = $data->get();
        return $result;
    }

    public static function SearchUserNotif($search, $is_active = '', $limit = 0) {
        $data = static::Where('from_id', 'like', '%' . $search . '%')
                ->orWhere('to_id', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%')
                ->orWhere('notif_id', 'like', '%' . $search . '%')
                ->orWhere('notif_type', 'like', '%' . $search . '%');
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

//*****************************************************************
    public static function SelectDataNotif($get_notif, $api = 0) {
        $all_data = [];
        foreach ($get_notif as $key => $val_notif) {
            if ($val_notif->to_id > 0) {
                $array_data['id'] = $val_notif->id;
                $array_data['from_id'] = $val_notif->from_id;
                if ($val_notif->from_id > 0) {
                    $array_data['from_user_name'] = $val_notif->user->display_name;
                    $array_data['from_user_image'] = $val_notif->user->image;
                    $array_data['from_state_hiden'] = $val_notif->state_hiden;
                    if ($val_notif->state_hiden == 1) {
                        $array_data['from_user_name'] = generateFilterEmoji($val_notif->display_name);
                        $array_data['from_user_image'] = generateFilterEmoji($val_notif->emoji);
                    }
                } else {
                    $array_data['from_user_name'] = 'Guest';
                    $array_data['from_user_image'] = '/images/baims/member.png';
                }
                $array_data['to_id'] = $val_notif->to_id;
                $array_data['to_user_name'] = $val_notif->Touser->display_name;
                $array_data['to_user_image'] = $val_notif->Touser->image;
                $array_data['name_course'] = '';
                if (in_array($val_notif->type, ['course', 'chapter', 'lecture'])) {
                    if ($api == 0) {
                        $array_data['link_notif'] = $val_notif->posts->link;
                        if ($val_notif->type == 'lecture') {
                            $get_course = new \App\Http\Controllers\ClassSiteApi\Class_CourseController;
                            $array_data['link_notif'] = [$get_course->get_courseType($val_notif->posts, [], 'link'), $array_data['link_notif']];
                        }
                    }
                    $array_data['name_course'] = $val_notif->posts->name;
                }
                //if ($api == 0) {
                $array_data['created_at'] = $val_notif->created_at->format('Y-m-d');
                //}
                $array_data['data'] = generateFilterEmoji($val_notif->data);
                $array_data['type'] = $val_notif->type;
                $array_data['is_read'] = $val_notif->is_read;
                $all_data[] = $array_data;
            }
        }
        return $all_data;
    }

//*****************************************************************

    public function insertUserNotif($notif_id, $from_id, $type, $to_id, $is_active = 1) {
        $this->notif_id = $notif_id;
        $this->from_id = $from_id;
        $this->type = $type;
        $this->to_id = $to_id;
        $this->is_active = $is_active;
        return $this->save();
    }

    public static function updateUserNotif($id, $from_id, $to_id, $is_active = 1) {
        $data = static::findOrFail($id);
        $data->from_id = $from_id;
        $data->to_id = $to_id;
        $data->is_active = $is_active;
        return $data->save();
    }

}
