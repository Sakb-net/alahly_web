<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Blog extends Model {

    protected $fillable = [
        'user_id', 'update_by', 'parent_id', 'name', 'link', 'type', 'image', 'view_count', 'description', 'content',
        'color', 'tags', 'video', 'file', 'lang', 'lang_id',
        'comment_count', 'order_id', 'is_share', 'is_comment', 'is_read', 'is_active'
    ];

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function comments() {
        return $this->hasMany(\App\Model\CommentBlog::class);
    }
    public static function Addanotherlang($old_id, $new_id, $user_id, $order_id) {
        $lang_anothers = Blog::DataLangAR($old_id);
        foreach ($lang_anothers as $keyLang => $valueLang) {
            $input = [];
            $old_blog_lang = $valueLang->toArray();
            foreach ($old_blog_lang as $key => $val_Lang) {
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
            $new_blog = Blog::create($input);
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

    public static function updateBlogTime($id, $user_id) {
        $blog = static::findOrFail($id);
        $blog->update_at = new Carbon();
        $blog->update_by = $user_id;
        return $blog->save();
    }

    public static function updateBlogViewCount($id) {
        return static::where('id', $id)->increment('view_count');
    }

    public static function countBlogUnRead() {
        return static::where('is_read', 0)->count();
    }

    public static function countBlogTypeUnRead($type = 'blog') {
        return static::where('type', $type)->where('is_read', 0)->count();
    }

    public static function get_LastRow($lang, $colum, $data_order = 'order_id') {
        $bundle = Blog::where('lang', $lang)->orderBy($data_order, 'DESC')->first();
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

    public static function get_blogType($link, $type = 'blog', $is_active = 1) {
        $data = static::with(['childrens' => function ($q) {
                        $q->orderBy('order_id', 'asc');
                    }])->where('link', $link)->where('type', $type);
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->first();
        return $result;
    }

    public static function get_blog($colum, $valColum, $lang = 'ar', $is_active = 1) {
        $data_one = static::where($colum, $valColum)->where('is_active', $is_active)->first();
        if (isset($data_one->lang_id)) {
            $data = static::where('lang_id', $data_one->lang_id)->where('is_active', $is_active)->where('lang', $lang)->first();
        } else {
            $data = [];
        }
        return $data;
    }

    public static function get_DataType($link, $col_name = 'link', $type = 'blog', $is_active = 1, $user_id = NULL) {
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

    public static function getBlogType($colum, $columvalue, $type = 'blog', $lang = 'ar', $columOrder = 'order_id', $columvalueOrder = 'ASC', $is_active = 1, $limit = 0) {
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

    public static function getBlogs($colum, $columvalue, $type, $parent_id = NULL, $parent_state = '=', $limit = 0) {
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

    public static function getBlogsNotArray($colum, $columvalue, $type = 'blog', $limit = 0, $lang, $is_active = '', $col_val = 'lang_id', $offset = 0) {
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

    public static function blogData($id, $column = 'name') {
        $blog = static::where('id', $id)->first();
        if (isset($blog)) {
            return $blog->$column;
        } else {
            return '';
        }
    }

    public static function blogDataLang($lang_id, $lang, $column = '') {
        $blog = static::where('lang_id', $lang_id)->where('lang', $lang)->first();
        if (!empty($column) && isset($blog->$column)) {
            return $blog->$column;
        } else {
            return$blog;
        }
    }

    public static function blogDataUser($id, $column = '') {
        $blog = static::with('user')->where('id', $id)->first();
        if (!empty($column)) {
            return $blog->$column;
        } else {
            return $blog;
        }
    }

    public static function get_BlogActive($is_active, $column = '', $columnValue = '', $lang = '', $array = 0, $limit = 0, $offset = -1) {
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

    public static function SearchBlog($search, $type = 'blog', $is_active = '', $limit = 0) {
        $data = static::with('user')->Where('name', 'like', '%' . $search . '%')
                ->orWhere('link', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('image', 'like', '%' . $search . '%')
                ->orWhere('video', 'like', '%' . $search . '%')
                ->orWhere('user_id', 'like', '%' . $search . '%')
                ->orWhere('file', 'like', '%' . $search . '%')
                ->orWhere('color', 'like', '%' . $search . '%')
                ->orWhere('tags', 'like', '%' . $search . '%');
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

    public static function lastMonth($month, $date, $type = 'blog') {

        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$month, $date])->get();
        return $count[0]->count;
    }

    public static function lastWeek($week, $date, $type = 'blog') {

        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$week, $date])->get();
        return $count[0]->count;
    }

    public static function lastDay($day, $date, $type = 'blog') {
        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$day, $date])->get();
        return $count[0]->count;
    }

    public static function BlogOrderUserView($lang, $user_id, $type = 'blog', $is_active = 1) {
        $data = Blog::select(DB::raw('sum(blogs.view_count) AS view_count'))
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

    public static function BlogUser($lang, $user_id, $type = 'blog', $is_active = 1, $count = 1) {
        $data = Blog::where('type', $type)->where('user_id', $user_id)
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

    public static function dataNews($all_news = [], $api = 0) {
        $lang = 'ar';
        $all_data = [];
        foreach ($all_news as $key_ne => $valnews) {
            $all_data[] = Blog::dataNews_single($valnews, $api);
        }
        return $all_data;
    }

    public static function dataNews_single($valnews, $api = 0) {
        $lang = 'ar';
        $data['name'] = $valnews->name;
        $data['link'] = $valnews->link;
        $data['tags'] = json_decode($valnews->tags);
        $data['image'] = $valnews->image;
        $data['content'] = strip_tags($valnews->content);
        $data['description'] = strip_tags($valnews->description);
//           $allData = explode('-', $valnews->created_at->format('Y-m-d'));                         
        $data['date'] = $valnews->created_at->format('Y-m-d'); //arabic_date_number($valnews->created_at->format('Y-m-d'),'-');
        $data['created_at'] = Time_Elapsed_String('@' . strtotime($valnews->created_at), $valnews->lang);
        $data['user_name'] = $valnews->user['display_name'];
        $data['user_image'] = $valnews->user['image'];

        return $data;
    }

//****************************************************************
    public static function BlogSubscribe($colum = 'id', $columtwo = 'name', $limit = -1) {
        $data = Blog::leftJoin('subscribes', 'blogs.id', '=', 'subscribes.type_id')
                        ->select('blogs.id', 'blogs.name')
                        ->where('subscribes.type', '=', 'blog')
                        ->where('blogs.type', '=', 'blog')->distinct()
                        ->where('blogs.is_active', 1)->where('blogs.type', 'blog');
        if ($limit == -1) {
            $result = $data->pluck($colum, $columtwo)->toArray();
        } elseif ($limit > 0) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

}
