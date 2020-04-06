<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Calendar extends Model {

    protected $fillable = [
        'user_id', 'update_by', 'parent_id', 'name', 'link', 'type', 'image', 'view_count', 'description', 'content',
        'lang', 'lang_id', 'date', 'order_id', 'is_share', 'is_delete', 'is_read', 'is_active'
    ];

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function tags() {
        return $this->morphToMany(\App\Model\Tag::class, 'taggable');
    }

    public function childrens() {
        return $this->hasMany(\App\Model\Category::class, 'parent_id');
    }

    public function parentID() {
        return $this->belongsTo(\App\Model\Category::class, 'parent_id');
    }

    public function langID() {
        return $this->belongsTo(\App\Model\Category::class, 'lang_id');
    }

    public static function deleteParent($id) {
        return static::where('parent_id', $id)->delete();
    }

    public static function Addanotherlang($old_id, $new_id, $user_id, $order_id) {
        $lang_anothers = Calendar::DataLangAR($old_id);
        foreach ($lang_anothers as $keyLang => $valueLang) {
            $input = [];
            $old_Calendar_lang = $valueLang->toArray();
            foreach ($old_Calendar_lang as $key => $val_Lang) {
                if ($key != "id") {
                    $input[$key] = $val_Lang;
                }
            }
            if ($order_id != -1) {
                $input['order_id'] = $order_id + 1;
            }
            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
            $input['is_share'] = 1;
            $input['lang_id'] = $new_id;
            $input['update_by'] = $user_id;
            $new_Calendar = Calendar::create($input);
        }
    }

    public static function updateVideoFile($id, $main_video, $main_file) {
        $data = static::findOrFail($id);
        $data->video = $main_video;
        $data->file = $main_file;
        return $data->save();
    }

    public static function updateColum($id, $colum, $columValue) {
        $data = static::findOrFail($id);
        $data->$colum = $columValue;
        return $data->save();
    }

    public static function updateOrderColum($colum, $valueColum, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->update([$columUpdate => $valueUpdate]);
    }

    public static function updateCalendarTime($id, $user_id) {
        $Calendar = static::findOrFail($id);
        $Calendar->update_at = new Carbon();
        $Calendar->update_by = $user_id;
        return $Calendar->save();
    }

    public static function updateCalendarViewCount($id) {
        return static::where('id', $id)->increment('view_count');
    }

    public static function countCalendarUnRead() {
        return static::where('is_read', 0)->count();
    }

    public static function countCalendarTypeUnRead($type = 'Calendar') {
        return static::where('type', $type)->where('is_read', 0)->count();
    }

    public static function get_LastRow($lang, $colum, $data_order = 'order_id') {
        $bundle = Calendar::where('lang', $lang)->orderBy($data_order, 'DESC')->first();
        if (!empty($bundle)) {
            return $bundle->$colum;
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

    public static function get_CalendarType($link, $type = 'Calendar', $is_active = 1) {
        $data = static::with(['childrens' => function ($q) {
                        $q->orderBy('order_id', 'asc');
                    }])->where('link', $link)->where('type', $type);
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->first();
        return $result;
    }

    public static function get_Calendar($colum, $valColum, $lang = 'ar', $is_active = 1) {
        $data_one = static::where($colum, $valColum)->where('is_active', $is_active)->first();
        if (isset($data_one->lang_id)) {
            $data = static::where('lang_id', $data_one->lang_id)->where('is_active', $is_active)->where('lang', $lang)->first();
        } else {
            $data = [];
        }
        return $data;
    }

    public static function get_DataType($link, $col_name = 'link', $type = 'Calendar', $is_active = 1, $user_id = NULL) {
        $data = static::where($col_name, $link)->where('type', $type);
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        if (!empty($user_id)) {
            $result = $data->where('user_id', $user_id);
        }
        $result = $data->first();
        return $result;
    }

    public static function getCalendarType($colum, $columvalue, $type = 'Calendar', $lang = 'ar', $columOrder = 'order_id', $columvalueOrder = 'ASC', $is_active = 1, $limit = 0) {
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

    public static function getCalendars($colum, $columvalue, $type, $parent_id = NULL, $parent_state = '=', $limit = 0) {
        $data = static::where($colum, $columvalue)
                ->where('type', $type);
        if ($parent_id != -1) {
            $result = $data->where('parent_id', $parent_state, $parent_id);
        }
        $result = $data->orderBy('order_id', 'ASC'); //with('user')->  //orderBy('id', 'DESC')->  
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function getCalendarsNotArray($colum, $columvalue, $type = 'Calendar', $limit = 0, $lang, $is_active = '', $col_val = 'lang_id', $offset = 0) {
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

    public static function CalendarData($id, $column = 'name') {
        $Calendar = static::where('id', $id)->first();
        if (isset($Calendar)) {
            return $Calendar->$column;
        } else {
            return '';
        }
    }

    public static function CalendarDataLang($lang_id, $lang, $column = '') {
        $Calendar = static::where('lang_id', $lang_id)->where('lang', $lang)->first();
        if (!empty($column) && isset($Calendar->$column)) {
            return $Calendar->$column;
        } else {
            return$Calendar;
        }
    }

    public static function CalendarDataUser($id, $column = '') {
        $Calendar = static::with('user')->where('id', $id)->first();
        if (!empty($column)) {
            return $Calendar->$column;
        } else {
            return $Calendar;
        }
    }

    public static function get_CalendarActive($is_active, $column = '', $columnValue = '', $lang = '', $array = 0, $limit = 0, $offset = -1) {
        $data = static::with('user');
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
        $result = $data->orderBy('id', 'DESC');
        if ($limit > 0 && $offset > -1) {
            $result = $data->limit($limit)->offset($offset)->get();
        } elseif ($limit > 0 && $offset == -1) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function SearchCalendar($search, $type = 'Calendar', $is_active = '', $limit = 0) {
        $data = static::with('user')->Where('name', 'like', '%' . $search . '%')
                ->orWhere('link', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('image', 'like', '%' . $search . '%')
                ->orWhere('date', 'like', '%' . $search . '%')
                ->orWhere('user_id', 'like', '%' . $search . '%');
        if (!empty($type)) {
            $result = $data->where('type', $type);
        }
        if (!empty($is_active)) {
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

    public static function lastMonth($month, $date, $type = 'Calendar') {

        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$month, $date])->get();
        return $count[0]->count;
    }

    public static function lastWeek($week, $date, $type = 'Calendar') {

        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$week, $date])->get();
        return $count[0]->count;
    }

    public static function lastDay($day, $date, $type = 'Calendar') {
        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$day, $date])->get();
        return $count[0]->count;
    }

    public static function CalendarOrderUserView($lang, $user_id, $type = 'Calendar', $is_active = 1) {
        $data = Calendar::select(DB::raw('sum(Calendars.view_count) AS view_count'))
                ->where('type', $type)->where('user_id', $user_id)
                ->where('lang', $lang)->where('is_active', $is_active)
                ->get();
        if (empty($data[0]->view_count)) {
            $data_view_count = 0;
        } else {
            $data_view_count = $data[0]->view_count;
        }
        return $data_view_count;
    }

    public static function CalendarUser($lang, $user_id, $type = 'Calendar', $is_active = 1, $count = 1) {
        $data = Calendar::where('type', $type)->where('user_id', $user_id)
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

    public static function get_DataCalendar($all_calendar = [], $api = 0) {
        $lang = 'ar';
        $all_data = [];
        foreach ($all_calendar as $key_ne => $valcalendar) {
            $all_data[] = Calendar::dataCalendar_single($valcalendar, $api);
        }
        return $all_data;
    }

    public static function dataCalendar_single($valcalendar, $api = 0) {
        $lang = 'ar';
        $data['name'] = $valcalendar->name;
        $data['link'] = $valcalendar->link;
        $data['image'] = $valcalendar->image;
        $data['date'] = $valcalendar->date;
        $data['date'] = $valcalendar->date;
        $data['content'] = strip_tags($valcalendar->content);
        if ($api == 0) {
            //**** current date of calender ****  //2019-10-30
            $data['url_link'] = '';
            $current_date = date("Y-m-d");
            $date1 = date_create($current_date);
            $date2 = date_create($valcalendar->date);
            $differnt = date_diff($date1, $date2);
            $num_day = 0;
            $signal = '+';
            if (isset($differnt->days)) {
                if ($differnt->days > 0) {
                    $num_day = $differnt->days;
                }
            }
            if ($current_date > $valcalendar->date) {
                $signal = '-';
            }
            if ($num_day <= 0) {
                $signal = '';
            }
            $data['signal'] = $signal;
            $data['num_day'] = $num_day;
            //***** end date of calender *****
//            $data['string_date'] = strtotime($valcalendar->date);
        }
//        $data['description'] = strip_tags($valcalendar->description);
//        $data['date_created'] = $valcalendar->created_at->format('Y-m-d');
//        $data['created_at'] = Time_Elapsed_String('@' . strtotime($valcalendar->created_at), $valcalendar->lang);
//        $data['user_name'] = $valcalendar->user['display_name'];
//        $data['user_image'] = $valcalendar->user['image'];
        return $data;
    }

}
