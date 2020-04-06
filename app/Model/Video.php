<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Video extends Model {

    protected $table = 'videos';
    protected $fillable = [
        'table_id', 'table_name', 'user_id', 'video',
        'name', 'link', 'is_active', 'time', 'extension',
        'image', 'content', 'view_count'
    ];// 'upload_id',

//    public function posts() {
//        return $this->belongsTo(\App\Model\Post::class, 'table_id');
//    }

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function watches() {
        return $this->hasMany(\App\Model\Watche::class);
    }

    public function comments() {
        return $this->hasMany(\App\Model\CommentVideo::class);
    }

    public static function updateVideoLink($id, $link) {

        $video = static::findOrFail($id);
        $video->link = $link;
        return $video->save();
    }

    public static function updateVideoActive($id, $is_active = 1) {

        $video = static::findOrFail($id);
        $video->is_active = $is_active;
        return $video->save();
    }

    public static function deletedataTable($colum, $value) {
        return static::where($colum, $value)->delete();
    }

    public static function deleteVideo($id) {
        return static::where('id', $id)->delete();
    }

    public static function deleteArrayVideo($array_id) {
        $all_array_id = array_values($array_id);
        $result = Video::whereIn('id', $all_array_id)->delete();
        return $result;
    }

    public static function FoundVideo($video) {
        $link_found = static::where('video', $video)->first();
        if (isset($link_found)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function foundLink($link) {
        $link_found = static::where('link', $link)->first();
        if (isset($link_found)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function updateVideoViewCount($id) {
        return static::where('id', $id)->increment('view_count');
    }

    public static function get_videoColum($colum, $val_col, $is_active = -1) {
        $data = static::where($colum, $val_col);
        if ($is_active != -1) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->first();
        return $result;
    }

    public static function get_ALLVideoData($id, $colum = 'id', $valueColume = 'DESC', $limit = 0, $offset = -1) {
        $data = static::where('table_id', $id)->where('is_active', 1)->with('user')->orderBy($colum, $valueColume);
        if ($limit > 0 && $offset > -1) {
            $result = $data->limit($limit)->offset($offset)->get();
        } elseif ($limit > 0 && $offset == -1) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_ALLVideoID($id, $colum = '', $valueColume = '') {
        $data = Video::where('id', $id);
        if (!empty($colum)) {
            $video = $data->where($colum, $valueColume);
        }
        $video = $data->first();
        return $video;
    }

    public static function get_videoID($id, $colum) {
        $video = Video::where('id', $id)->first();
        if (isset($video->$colum)) {
            return $video->$colum;
        } else {
            if ($colum == 'time') {
                return '00:00';
            } else {
                return '';
            }
        }
    }

    public static function get_DataType($link, $col_name = 'link', $type = 'video', $is_active = 1, $user_id = NULL) {
        $data = static::where($col_name, $link);
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        if (!empty($user_id)) {
            $result = $data->where('user_id', $user_id);
        }
        $result = $data->first();
        return $result;
    }

    public static function get_ArrayIdVideo($chapters, $videos) {
        $array_video_id = [];
        $total_count = 0; // 1; for video intro of course
        $total_time = '00:00' . ' ' . ' دقيقة';
        foreach ($chapters as $key => $valueCh) {
            $lectures = $valueCh->childrens;
            foreach ($lectures as $keyLect => $valueLect) {
                if ($valueLect->video_id > 0) {
                    $array_video_id[] = $valueLect->video_id;
                }
            }
        }
        $total_count += count($array_video_id);
        $hours = 0;
        $mins = 0;
        $secs = 0;
        $sum_time = 0;
        $array_num = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        foreach ($videos as $keyVd => $valueVd) {
            if (in_array($valueVd->id, $array_video_id)) {
                $time = $valueVd->time;
                $divie_time = explode(':', $time);
                $count_time = count($divie_time);
                if ($count_time == 1) {
                    $hours += 0;
                    $mins += 0;
                    $secs += $divie_time[0];
                } elseif ($count_time == 2) {
                    $hours += 0;
                    $mins += $divie_time[0];
                    $secs += $divie_time[1];
                } else {
                    $hours += $divie_time[0];
                    $mins += $divie_time[1];
                    $secs += $divie_time[2];
                }
            }
        }
        $sum_time = $secs + ($mins * 60) + ($hours * 60 * 60);
        $final = gmdate("H:i:s", $sum_time);
        $valueCount_time = explode(':', $final);
        $numCount_time = count($valueCount_time);
        if ($numCount_time == 2) {
            $total_time = $valueCount_time[0] . ":" . $valueCount_time[1] . ' ' . ' دقيقة';
        } else {
            if ($valueCount_time[0] == "00") {
                $total_time = $valueCount_time[1] . ":" . $valueCount_time[2] . ' ' . ' دقيقة';
            } else {
                $part_final = explode(':', $final);
                //without seconds
                $total_time = $part_final[0] . ":" . $part_final[1] . ' ' . ' ساعة';
            }
        }
        $array_data['count_videos'] = $total_count;
        $array_data['time_videos'] = $total_time;
        return $array_data;
    }

    public static function get_ArrayIdVideo_test($chapters, $videos) {
        $array_video_id = [];
        $total_count = 0; // 1; for video intro of course
        $total_time = '00:00' . ' ' . ' دقيقة';
        foreach ($chapters as $key => $valueCh) {
            $lectures = $valueCh->childrens;
            foreach ($lectures as $keyLect => $valueLect) {
                if ($valueLect->video_id > 0) {
                    $array_video_id[] = $valueLect->video_id;
                }
            }
        }
        $total_count += count($array_video_id);
        $hours = 0;
        $mins = 0;
        $secs = 0;
        $sum_time = 0;
        $array_num = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        print_r($array_video_id);
        print_r($videos);
        foreach ($videos as $keyVd => $valueVd) {
            if (in_array($valueVd->id, $array_video_id)) {
                $time = $valueVd->time;
                $divie_time = explode(':', $time);
                $count_time = count($divie_time);
                if ($count_time == 1) {
                    $hours += 0;
                    $mins += 0;
                    $secs += $divie_time[0];
                } elseif ($count_time == 2) {
                    $hours += 0;
                    $mins += $divie_time[0];
                    $secs += $divie_time[1];
                } else {
                    $hours += $divie_time[0];
                    $mins += $divie_time[1];
                    $secs += $divie_time[2];
                }
            }
        }
        $sum_time = $secs + ($mins * 60) + ($hours * 60 * 60);
        $final = gmdate("H:i:s", $sum_time);
        $valueCount_time = explode(':', $final);
        $numCount_time = count($valueCount_time);
        if ($numCount_time == 2) {
            $total_time = $valueCount_time[0] . ":" . $valueCount_time[1] . ' ' . ' دقيقة';
        } else {
            if ($valueCount_time[0] == "00") {
                $total_time = $valueCount_time[1] . ":" . $valueCount_time[2] . ' ' . ' دقيقة';
            } else {
                $part_final = explode(':', $final);
                //without seconds
                $total_time = $part_final[0] . ":" . $part_final[1] . ' ' . ' ساعة';
            }
        }
        $array_data['count_videos'] = $total_count;
        $array_data['time_videos'] = $total_time;
        return $array_data;
    }

    public static function datavideos($get_data = [], $api = 0) {
        $lang = 'ar';
        $all_data = [];
        foreach ($get_data as $key_vid => $val_video) {
            $all_data[] = Video::datavideos_single($val_video, $api);
        }
        return $all_data;
    }

    public static function datavideos_single($videos, $api = 0) {
        $lang = 'ar';
        $data_videos['name'] = $videos->name;
        $data_videos['link'] = $videos->link;
        $data_videos['extension'] = $videos->extension;
        $data_videos['video'] = $videos->video;
        $data_videos['image'] = $videos->image;
        $data_videos['upload'] = 0;
        $data_videos['upload_id'] = ''; // $videos->upload_id;
        $array_upload = explode('uploads', $videos->video);
        if (count($array_upload) >= 2) {
            $data_videos['upload'] = 1;
        } else {
            $array_upload = explode('youtube.com/v/', $videos->video);
            if (count($array_upload) >= 2) {
                $data_videos['upload_id'] = $array_upload[1];
            }
        }
        $data_videos['content'] = strip_tags($videos->content);
        $data_videos['date'] = $videos->created_at->format('Y-m-d'); //arabic_date_number($videos->created_at->format('Y-m-d'), '-');
        $data_videos['created_at'] = Time_Elapsed_String('@' . strtotime($videos->created_at), $videos->lang);
//            $data_videos['user_name'] = $videos->user['display_name'];
//            $data_videos['user_image'] = $videos->user['image'];

        return $data_videos;
    }

//**********************************************
    public function insertVideo($user_id, $table_id, $name, $link, $video, $time, $vimeo_link, $extension, $video_sd, $video_mob, $is_active = 1) {
        $this->user_id = $user_id;
        $this->table_id = $table_id;
        $this->name = $name;
        $this->link = $link;
        $this->video = $video;
        $this->time = $time;
        $this->vimeo_link = $vimeo_link;
        $this->extension = $extension;
        $this->video_sd = $video_sd;
        $this->video_mob = $video_mob;
        $this->is_active = $is_active;
        return $this->save();
    }

    public static function updateVideo($id, $user_id, $table_id, $name, $link, $video, $time, $vimeo_link, $extension, $video_sd, $video_mob, $is_active) {
        $video = static::findOrFail($id);
        $video->user_id = $user_id;
        $video->table_id = $table_id;
        $video->name = $name;
        $video->video = $video;
        $video->link = $link;
        $this->time = $time;
        $this->vimeo_link = $vimeo_link;
        $this->extension = $extension;
        $this->video_sd = $video_sd;
        $this->video_mob = $video_mob;
        $video->is_active = $is_active;
        return $video->save();
    }

}
