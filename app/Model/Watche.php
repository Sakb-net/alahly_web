<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Watche extends Model {

    protected $table = 'watches';
    protected $fillable = [
        'user_id', 'video_id', 'num_watch', 'is_active'
    ];

    public function user() {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function videos() {
        return $this->belongsTo(\App\Model\Video::class, 'video_id');
    }

    public static function insertWatcheVideoLink($user_id, $video_link, $is_active = 1) {
        $video = Video::get_videoColum('link', $video_link, $is_active);
        if (isset($video->id)) {
            $check_watch = Watche::get_WatcheVideo($user_id, $video->id, 1);
            if (isset($check_watch->id)) {
                $check_watch->num_watch = $check_watch->num_watch + 1;
                $check_watch->save();
                $save_watch = $check_watch->id;
            } else {
                $add_watch = Watche::insertWatche($user_id, $video->id, 1, 1);
                $save_watch = $add_watch['id'];
            }
        } else {
            $save_watch = 0;
        }
        return $save_watch;
    }

    public static function insertWatche($user_id, $video_id, $num_watch = 0, $is_active = 1) {
        $input['user_id'] = $user_id;
        $input['video_id'] = $video_id;
        $input['num_watch'] = $num_watch;
        $input['is_active'] = $is_active;
        $watch = Watche::create($input);
        return $watch;
    }

    public static function updateWatcheActive($id, $is_active = 1) {
        $data_sub = static::findOrFail($id);
        $data_sub->is_active = $is_active;
        return $data_sub->save();
    }

    public static function get_WatcheUser($user_id, $is_active = 1, $count = 0) {
        $data_sub = Watche::where('user_id', $user_id)->where('is_active', $is_active)->get();
        if ($count == 1) {
            $data_sub = count($data_sub);
        }
        return $data_sub;
    }

    public static function get_WatcheVideo($user_id, $video_id, $is_active = 1, $colume = '') {
        $data_sub = Watche::where('user_id', $user_id)->where('video_id', $video_id)
                        ->where('is_active', $is_active)->first();
        if (!empty($colume)) {
            $data_sub = FALSE;
            if (isset($data_sub->id)) {
                $data_sub = TRUE;
            }
        }
        return $data_sub;
    }

    public static function get_LastRow($colum, $data_order = 'id') {
        $data_sub = Watche::orderBy($data_order, 'DESC')->first();
        if (!empty($colum)) {
            return $data_sub->$colum;
        } else {
            return 0;
        }
    }

    public static function SearchWatche($search, $is_active = '', $limit = 0) {
        $data = static::Where('video_id', 'like', '%' . $search . '%')
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

    //************************

    public static function updateWatche($id, $video_id, $is_active = 1) {
        $data_sub = static::findOrFail($id);
        $data_sub->video_id = $video_id;
        $data_sub->is_active = $is_active;
        return $data_sub->save();
    }

}
