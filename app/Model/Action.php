<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Action extends Model {

    protected $table = 'actions';
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'actionable_id', 'actionable_type', 'action_type', 'action_key', 'action_value', 'action_group'
    ];

    public function actionable() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

//    public function datas() {
//        return $this->belongsTo(\App\Model\Post::class, 'actionable_id');
//    }

    public static function insertAction($user_id, $actionable_id, $actionable_type = 'course', $action_type = 'like', $action_key = NULL, $action_value = NULL, $action_group = NULL) {
        $input['user_id'] = $user_id;
        $input['actionable_id'] = $actionable_id;
        $input['actionable_type'] = $actionable_type;
        $input['action_type'] = $action_type;
        $input['action_key'] = $action_key;
        $input['action_value'] = $action_value;
        $input['action_group'] = $action_group;
        $fav = Action::create($input);
        return $fav;
    }

    public static function deleteAction($actionable_id, $actionable_type, $action_type) {
        return static::where('actionable_id', $actionable_id)->where('actionable_type', $actionable_type)->where('action_type', $action_type)->delete();
    }

    public static function deleteUserAction($user_id, $actionable_id, $actionable_type = 'course', $action_type = 'like') {
        return static::where('user_id', $user_id)->where('actionable_id', $actionable_id)->where('actionable_type', $actionable_type)->where('action_type', $action_type)->delete();
    }

    public static function get_DataAction($actionable_id, $actionable_type = 'course', $action_type = 'like', $count = 0) {
        $data = static::where('actionable_id', $actionable_id)
                ->where('actionable_type', $actionable_type)
                ->where('action_type', $action_type)
                ->get();
        if ($count == 1) {
            return count($data);
        } else {
            return $data;
        }
    }

    public static function actionCheckUserId($user_id, $actionable_id, $actionable_type = 'course', $action_type = 'like') {
        $data = static::where('user_id', $user_id)
                ->where('actionable_id', $actionable_id)
                ->where('actionable_type', $actionable_type)
                ->where('action_type', $action_type)
                ->first();
        if (isset($data->id)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function get_actionUserId($user_id, $actionable_type = 'course', $action_type = 'like', $limit = 0) {
        $data = static::where('user_id', $user_id)
                ->where('actionable_type', $actionable_type)
                ->where('action_type', $action_type);
        if ($limit == -1) {
            $result = $data->pluck('actionable_id', 'actionable_id')->toArray();
        } elseif ($limit > 0) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    //*******************************************************


    public function updateAction($actionable_id, $actionable_type, $action_type, $action_key, $action_value, $action_group = NULL) {
        $data_action = static::where('actionable_id', $actionable_id)->where('actionable_type', $actionable_type)->where('action_type', $action_type)->first();
        if (isset($data_action)) {
            $data_action->action_key = $action_key;
            $data_action->action_value = $action_value;
            $data_action->action_group = $action_group;
            return $data_action->save();
        } else {
            return $this->insertAction($actionable_id, $actionable_type, $action_type, $action_key, $action_value, $action_group);
        }
    }

}
