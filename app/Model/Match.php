<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use App\Model\Video;

class Match extends Model {

    protected $table = 'matches';
    protected $fillable = [
        'user_id', 'update_by', 'parent_id', 'name', 'link', 'type', 'first_image', 'second_image',
        'view_count', 'description', 'content', 'start_booking', 'end_booking', 'date', 'time', 'result', 'second_team', 'first_team',
        'comment_count', 'video_id', 'file_id', 'is_comment', 'is_read',
        'is_active', 'lang', 'lang_id', 'first_goal', 'second_goal'
    ];

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function childrens() {
        return $this->hasMany(\App\Model\Match::class, 'parent_id');
    }

    public function grandchildren() {
        return $this->hasMany(\App\Model\Match::class, 'parent_id');
    }

    public function categories() {
        return $this->belongsToMany(\App\Model\Category::class);
    }

//    public function category_match() {
//             return $this->belongsTo(\App\Model\CategoryMatch::class);
//        }
    public function actions() {
        return $this->morphMany(\App\Model\Action::class, 'actionable');
    }

    public function comments() {
        return $this->morphMany(\App\Model\Comment::class, 'match_id');
    }

    public function matchMeta() {
        return $this->hasMany(\App\Model\MatchMeta::class);
    }

    public function tags() {
        return $this->morphToMany(\App\Model\Tag::class, 'taggable');
    }

    public static function Addanotherlang($old_id, $new_id, $user_id, $video_id) {
        $lang_anothers = Match::DataLangAR($old_id);
        foreach ($lang_anothers as $keyLang => $valueLang) {
            $input = [];
            $old_match_lang = $valueLang->toArray();
            foreach ($old_match_lang as $key => $val_Lang) {
                if ($key != "id") {
                    $input[$key] = $val_Lang;
                }
            }
            if ($video_id != -1) {
                $input['video_id'] = $video_id + 1;
            }
            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
            $input['file_id'] = 1;
            $input['lang_id'] = $new_id;
            $input['update_by'] = $user_id;
            $new_match = Match::create($input);
        }
    }

    public static function updateColum($id, $colum, $columValue) {
        $data = static::findOrFail($id);
        $data->$colum = $columValue;
        return $data->save();
    }

    public static function updateOrderColum($colum, $valueColum, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->update([$columUpdate => $valueUpdate]);
    }

    public static function updateMatchTime($id, $user_id) {
        $match = static::findOrFail($id);
        $match->updateMatch_at = new Carbon();
        $match->updateMatch_by = $user_id;
        return $match->save();
    }

    public static function updateMatchViewCount($id) {
        return static::where('id', $id)->increment('view_count');
    }

    public static function countMatchUnRead() {
        return static::where('is_read', 0)->count();
    }

    public static function countMatchTypeUnRead($type = 'chair') {
        return static::where('type', $type)->where('is_read', 0)->count();
    }

    public static function deleteMatchParent($parent_id, $type) {
        if ($type == 'match') {
            $matchs = static::where('parent_id', $parent_id)->get();
            foreach ($matchs as $key => $match) {
                if (isset($match->id)) {
                    static::deleteMatchParent($match->id, $match->type);
                    static::find($match->id)->delete();
                }
            }
            Feature::deleteMatchBundle($parent_id, 0);
            return 1;
        } else {
            return self::where('parent_id', $parent_id)->delete();
        }
    }

    public static function get_LastRow($type, $lang, $parent_id = NULL, $colum, $data_order = 'video_id') {
        $match = Match::where('type', $type)->where('lang', $lang)->where('parent_id', $parent_id)->orderBy($data_order, 'DESC')->first();
        if (!empty($match)) {
            return $match->$colum;
        } else {
            return 0;
        }
    }

    public static function DataLangAR($lang_id, $all_lang = '', $limit = 0) {
        $data = static::where('lang_id', $lang_id);
        if (empty($all_lang)) {
            $result = $data->where('lang', '<>', 'ar');
        }
        $result = $data->orderBy('id', 'DESC');
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } elseif ($limit == -1) {
            $result = $data->pluck('id', 'id')->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_matchLink($col_name, $col_val, $is_active = 1) {
        $data = static::with(['childrens' => function ($q) {
                        $q->orderBy('id', 'asc');
                    }])->where($col_name, $col_val);
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->first();
        return $result;
    }

    public static function get_matchType($link, $type = 'chair', $is_active = 1) {
        $data = static::with(['childrens' => function ($q) {
                        $q->orderBy('id', 'asc');
                    }])->where('link', $link)->where('type', $type);
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->first();
        return $result;
    }

    public static function get_match($colum, $valColum, $lang = 'ar', $is_active = 1) {
        $data_one = static::where($colum, $valColum)->where('is_active', $is_active)->first();
        if (isset($data_one->lang_id)) {
            $data = static::where('lang_id', $data_one->lang_id)->where('is_active', $is_active)->where('lang', $lang)->first();
        } else {
            $data = [];
        }
        return $data;
    }

    public static function getMatchType($colum, $columvalue, $type = 'match', $lang = 'ar', $columOrder = 'video_id', $columvalueOrder = 'ASC', $is_active = 1, $limit = 0) {
        $data = static::where($colum, $columvalue)->where('is_active', $is_active);
        $data->where('type', $type)->orderBy($columOrder, $columvalueOrder); //with('user')->  //orderBy('id', 'DESC')->  
        if ($limit > 6) {
            $result = $data->paginate($limit);
        } elseif ($limit <= 0) {
            $result = $data->get();
        } else {
            $result = $data->limit($limit)->get();
        }

        return $result;
    }

    public static function getMatchs($colum, $columvalue, $type, $parent_id = NULL, $parent_state = '=', $limit = 0) {
        $data = static::where($colum, $columvalue)
                ->where('type', $type);
        if ($parent_id != -1) {
            $result = $data->where('parent_id', $parent_state, $parent_id);
        }
        $result = $data->orderBy('id', 'asc'); //with('user')->  //orderBy('id', 'DESC')->  
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function getMatchsNotArray($colum, $columvalue, $type = 'match', $limit = 0, $lang, $is_active = '', $col_val = 'lang_id', $offset = 0) {
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

    public static function getMatchsArray($colum, $columvalue, $limit = 0, $lang, $is_active = '') {
        $data = static::whereIn($colum, $columvalue);
        //with('user')->  //orderBy('id', 'DESC')->  
        if (!empty($lang)) {
            $result = $data->where('lang', $lang);
        }
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->orderBy('id', 'asc');
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } elseif ($limit == -1) {
            $result = $data->pluck($col_val, $col_val)->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function matchData($id, $column = 'name') {
        $match = static::where('id', $id)->first();
        if (isset($match)) {
            return $match->$column;
        } else {
            return '';
        }
    }

    public static function matchDataLang($lang_id, $lang, $column = '') {
        $match = static::where('lang_id', $lang_id)->where('lang', $lang)->first();
        if (!empty($column) && isset($match->$column)) {
            return $match->$column;
        } else {
            return$match;
        }
    }

    public static function matchDataUser($id, $column = '') {
        $match = static::with('user')->where('id', $id)->first();
        if (!empty($column)) {
            return $match->$column;
        } else {
            return $match;
        }
    }

    public static function get_MatchActiveArray($is_active, $type = 'match', $lang = 'ar') {
        $data = Match::where('lang', $lang)->where('type', $type)
                        ->where('is_active', $is_active)->pluck('lang_id', 'name')->toArray();
        return $data;
    }

    public static function get_MatchActiveFirst($is_active, $type_time = 'next', $col_order = 'id', $val_order = 'ASC', $type = 'match', $lang = 'ar') {
        $data = Match::where('lang', $lang)->where('type', $type)
                ->where('is_active', $is_active);
        if (!empty($type_time)) {
            $current_date = date('Y-m-d H:i:s');
            if ($type_time == 'next') {
                $result = $data->where('date', '>=', $current_date);
            } elseif ($type_time == 'prev') {
                $result = $data->where('date', '<', $current_date);
            }
        }
        $result = $data->orderBy($col_order, $val_order)->first();
        return $result;
    }

    public static function get_MatchActive($is_active, $column = '', $columnValue = '', $lang = '', $type_time = '', $array = 0, $limit = 0, $offset = -1) {
        $data = static::with('user');
        if (!empty($type_time)) {
            $current_date = date('Y-m-d H:i:s');
            if ($type_time == 'next') {
                $result = $data->where('date', '>=', $current_date);
            } elseif ($type_time == 'prev') {
                $result = $data->where('date', '<', $current_date);
            }
        }
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        if (!empty($lang)) {
            $result = $data->where('lang', $lang);
        }
        if (!empty($column)) {
            if ($array == 1) {
                $result = $data->whereIn($column, $columnValue);
            } else {
                $result = $data->where($column, $columnValue);
            }
        }
        if ($limit > 0 && $offset > -1) {
            $result = $data->limit($limit)->offset($offset)->get();
        } elseif ($limit > 0 && $offset == -1) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function SearchMatch($search, $type = 'match', $is_active = '', $limit = 0) {
        $data = static::with('user')->Where('name', 'like', '%' . $search . '%')
                ->orWhere('link', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('image', 'like', '%' . $search . '%')
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

    public static function lastMonth($month, $date, $type = 'match') {

        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$month, $date])->get();
        return $count[0]->count;
    }

    public static function lastWeek($week, $date, $type = 'match') {

        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$week, $date])->get();
        return $count[0]->count;
    }

    public static function lastDay($day, $date, $type = 'match') {
        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$day, $date])->get();
        return $count[0]->count;
    }

    public static function MatchOrderUserView($lang, $user_id, $type = 'match', $is_active = 1) {
        $data = Match::select(DB::raw('sum(matchs.view_count) AS view_count'))
                ->where('type', $type)->where('user_id', $user_id)
                ->where('is_active', $is_active)
                //->where('lang', $lang)
                ->get();
        if (empty($data[0]->view_count)) {
            $data_view_count = 0;
        } else {
            $data_view_count = $data[0]->view_count;
        }
        return $data_view_count;
    }

    public static function MatchUser($lang, $user_id, $type = 'match', $is_active = 1, $count = 1) {
        $data = Match::where('type', $type)->where('user_id', $user_id)
                ->where('lang', $lang);
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->get();
        if ($count == -1) {
            return $result->pluck('id', 'id')->toArray();
        } elseif ($count == 1) {
            return count($result);
        } else {
            return $result;
        }
    }

    public static function get_StateBooking($match) {
        $ok_booking = 0;
        $msg_booking = trans('app.finish_ticket_booking');
        $start_booking = get_date($match['start_booking']);
        $end_booking = get_date($match['end_booking']);
        $current_date = get_date(date("Y-m-d"));
        if ($start_booking <= $current_date && $current_date <= $end_booking) {
            $ok_booking = 1;
            $msg_booking = '';
        } elseif ($start_booking > $current_date) {
            $ok_booking = 2;
            $msg_booking = trans('app.notstart_ticket_booking');
        }
        return array('ok_booking' => $ok_booking, 'msg_booking' => $msg_booking);
    }

    public static function get_DateTime($date, $time) {
        $type_time = 'prev';
        if (!empty($date) && !empty($time)) {
            $current_date = date('Y-m-d H:i:s');
            if ($date >= $current_date) {
                $type_time = 'next';
            }
            $date_time = explode(' ', $date);
            $date = $date_time[0];
            $time = substr($date_time[1], 0, -3) . $time;
        }
        return array('date' => $date, 'time' => $time, 'type_time' => $type_time);
    }

    public static function get_DateTimeReult($result, $video_id, $date, $time) {
        $data_value = static::get_DateTime($date, $time);
        $result = json_decode($result, true);
        foreach ($result as $key => $val_res) {
            $data_value[$key] = $val_res;
        }
        $data_value['video'] = '';
        $data_value['upload'] = 0;
        if (!empty($video_id)) {
            $video = Video::get_ALLVideoID($video_id, 'is_active', 1);
            if (isset($video->id)) {
                $data_value['video'] = $video->video;
                $array_upload = explode('uploads', $video->video);
                if (count($array_upload) >= 2) {
                    $data_value['upload'] = 1;
                }
            }
        }
        return $data_value;
    }

    public static function dataMatch($matchs, $api = 0) {
        $data = [];
        foreach ($matchs as $key => $value) {
            $data[] = static::get_MatchSingle($value, $api);
        }
        return $data;
    }

    public static function get_MatchSingle($value, $api = 0) {
        $data_value = [];
        if (isset($value->id)) {
            $data_value['link'] = $value->link;
            $data_value['link_ticket'] = route('tickets.index.match', $value->link);
            $data_value['name'] = $value->name;
            $data_value['date'] = $value->date;
            $data_value['time'] = $value->time;
            if (!empty($value->date) && !empty($value->time)) {
                $date_time = explode(' ', $value->date);
                $data_value['time'] = $date_time[1] . $value->time;
                $data_value['date'] = $date_time[0];
            }
            $data_value['start_booking'] = get_date($value->start_booking);
            $data_value['end_booking'] = get_date($value->end_booking);
            $data_value['first_team'] = $value->first_team;
            $data_value['second_team'] = $value->second_team;
            $data_value['first_goal'] = $value->first_goal;
            $data_value['second_goal'] = $value->second_goal;
            $data_value['first_image'] = $value->first_image;
            $data_value['second_image'] = $value->second_image;
            if ($api == 0) {
                $data_value['id'] = $value->id;
//            $data_value['content'] = $value->content;
                $data_value['description'] = $value->description;
            } else {
//            $data_value['content'] = strip_tags($value->content);
                $data_value['description'] = strip_tags($value->description);
            }
            $result = json_decode($value->result, true);
            foreach ($result as $key => $val_res) {
                $data_value[$key] = $val_res;
            }
            $date_time = static::get_DateTimeReult($value->result, $value->video_id, $value->date, $value->time);
            $data_value = array_merge($data_value, $date_time);
        }
        return $data_value;
    }

}
