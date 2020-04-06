<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Post extends Model {

    protected $fillable = [
        'user_id', 'update_by', 'parent_id', 'name', 'link', 'type', 'image',
        'view_count', 'description', 'content', 'price', 'discount', 'row', 'type_row',
        'comment_count', 'order_id', 'is_share', 'is_comment', 'is_read',
        'is_active', 'lang', 'lang_id'
    ];

//type_row --> front,back,right,left
    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function langID() {
        return $this->belongsTo(\App\Model\Post::class, 'lang_id');
    }

    public function childrens() {
        return $this->hasMany(\App\Model\Post::class, 'parent_id');
    }

    public function grandchildren() {
        return $this->hasMany(\App\Model\Post::class, 'parent_id');
    }

    public function categories() {
        return $this->belongsToMany(\App\Model\Category::class);
    }

//    public function category_post() {
//             return $this->belongsTo(\App\Model\CategoryPost::class);
//        }
    public function actions() {
        return $this->morphMany(\App\Model\Action::class, 'actionable');
    }

    public function comments() {
        return $this->hasMany(\App\Model\Comment::class);
    }

    public function postMeta() {
        return $this->hasMany(\App\Model\PostMeta::class);
    }

    public function tags() {
        return $this->morphToMany(\App\Model\Tag::class, 'taggable');
    }

    public static function Addanotherlang($old_id, $new_id, $user_id, $order_id) {
        $lang_anothers = Post::DataLangAR($old_id);
        foreach ($lang_anothers as $keyLang => $valueLang) {
            $input = [];
            $old_post_lang = $valueLang->toArray();
            foreach ($old_post_lang as $key => $val_Lang) {
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
            $new_post = Post::create($input);
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

    public static function updatePostTime($id, $user_id) {
        $post = static::findOrFail($id);
        $post->updatePost_at = new Carbon();
        $post->updatePost_by = $user_id;
        return $post->save();
    }

    public static function updatePostViewCount($id) {
        return static::where('id', $id)->increment('view_count');
    }

    public static function countPostUnRead() {
        return static::where('is_read', 0)->count();
    }

    public static function countPostTypeUnRead($type = 'chair') {
        return static::where('type', $type)->where('is_read', 0)->count();
    }

    public static function deletePostParent($parent_id, $type) {
        if ($type == 'post') {
            $posts = static::where('parent_id', $parent_id)->get();
            foreach ($posts as $key => $post) {
                if (isset($post->id)) {
                    static::deletePostParent($post->id, $post->type);
                    static::find($post->id)->delete();
                }
            }
            Feature::deletePostBundle($parent_id, 0);
            return 1;
        } else {
            return self::where('parent_id', $parent_id)->delete();
        }
    }

    public static function get_LastRow($type, $lang, $parent_id = NULL, $colum, $data_order = 'order_id') {
        $post = Post::where('type', $type)->where('lang', $lang)->where('parent_id', $parent_id)->orderBy($data_order, 'DESC')->first();
        if (!empty($post)) {
            return $post->$colum;
        } else {
            return 0;
        }
    }

    public static function get_LastChairRow($type, $category_id, $row, $col_order) {
        $post = Post::whereHas('categories', function ($q) use($category_id) {
                    $q->where('id', $category_id);
                })->where('type', $type)->where('row', $row)->first();  //orderBy($col_order, 'DESC')->
        if (isset($post->id)) {
            $row += 1;
            if ($row <= 100) {
                $row = Post::get_LastChairRow($type, $category_id, $row, $col_order);
                return $row;
            } else {
                return 0;
            }
        } else {
            return $row;
        }
    }

    public static function check_LastChairRow($type, $category_id, $row, $col_order) {
        $post = Post::whereHas('categories', function ($q) use($category_id) {
                    $q->where('id', $category_id);
                })->where('type', $type)->where('row', $row)->first();  //orderBy($col_order, 'DESC')->
        if (isset($post->id)) {
            return 0;
        } else {
            return $row;
        }
    }

    public static function get_categoryChairRow($type, $category_id, $row, $col_order, $limit = 0) {
        $data = Post::whereHas('categories', function ($q) use($category_id) {
                    $q->where('id', $category_id);
                })->where('type', $type);  //orderBy($col_order, 'DESC')->
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } elseif ($limit == -1) {
            $result = $data->pluck('id', 'id')->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
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

    public static function get_postCageorty($link, $is_active = 1) {
        $data = Post::whereHas('categories', function ($q)use($is_active, $link) {
                    $q->where('is_active', $is_active)->where('link', $link);
                })->where('is_active', $is_active)->get();
        return $data;
    }

    public static function get_postLink($col_name, $col_val, $is_active = 1) {
        $data = static::with(['childrens' => function ($q) {
                        $q->orderBy('order_id', 'asc');
                    }])->where($col_name, $col_val);
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->first();
        return $result;
    }

    public static function get_postType($link, $type = 'chair', $is_active = 1) {
        $data = static::with(['childrens' => function ($q) {
                        $q->orderBy('order_id', 'asc');
                    }])->where('link', $link)->where('type', $type);
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->first();
        return $result;
    }

    public static function get_post($colum, $valColum, $lang = 'ar', $is_active = 1) {
        $data_one = static::where($colum, $valColum)->where('is_active', $is_active)->first();
        if (isset($data_one->lang_id)) {
            $data = static::where('lang_id', $data_one->lang_id)->where('is_active', $is_active)->where('lang', $lang)->first();
        } else {
            $data = [];
        }
        return $data;
    }

    public static function getPostType($colum, $columvalue, $type = 'post', $lang = 'ar', $columOrder = 'order_id', $columvalueOrder = 'ASC', $is_active = 1, $limit = 0) {
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

    public static function getPosts($colum, $columvalue, $type, $parent_id = NULL, $parent_state = '=', $limit = 0) {
        $data = static::with('categories')->where($colum, $columvalue)
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

    public static function getPostsNotArray($colum, $columvalue, $type = 'post', $limit = 0, $lang, $is_active = '', $col_val = 'lang_id', $offset = 0) {
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

    public static function getPostsArray($colum, $columvalue, $limit = 0, $lang, $is_active = '') {
        $data = static::with('categories')->whereIn($colum, $columvalue);
        //with('user')->  //orderBy('id', 'DESC')->  
        if (!empty($lang)) {
            $result = $data->where('lang', $lang);
        }
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->orderBy('order_id', 'ASC');
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } elseif ($limit == -1) {
            $result = $data->pluck($col_val, $col_val)->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function postData($id, $column = 'name') {
        $post = static::where('id', $id)->first();
        if (isset($post)) {
            return $post->$column;
        } else {
            return '';
        }
    }

    public static function postDataLang($lang_id, $lang, $column = '') {
        $post = static::where('lang_id', $lang_id)->where('lang', $lang)->first();
        if (!empty($column) && isset($post->$column)) {
            return $post->$column;
        } else {
            return$post;
        }
    }

    public static function postDataUser($id, $column = '') {
        $post = static::with('user')->where('id', $id)->first();
        if (!empty($column)) {
            return $post->$column;
        } else {
            return $post;
        }
    }

    public static function postDataCategory($lang, $array_category_id, $array_chair_id, $colum_order, $val_order, $is_active, $limit) {
        $data = static::with('user')->whereHas('categories', function ($q) use ($array_category_id, $lang) {
                    $q->whereIn('category_id', $array_category_id)->where('lang', $lang);
                })->wherenotIn('id', $array_chair_id)->where('is_active', $is_active)->where('lang', $lang);
        $data->orderBy($colum_order, $val_order);
        if ($limit > 0) {
            $posts = $data->paginate($limit);
        } else {
            $posts = $data->get();
        }
        return $posts;
    }

    public static function get_PostActiveArray($is_active, $type = 'post', $lang = 'ar') {
        $data = Post::where('lang', $lang)->where('type', $type)
                        ->where('is_active', $is_active)->pluck('lang_id', 'name')->toArray();
        return $data;
    }

    public static function get_PostActive($is_active, $column = '', $columnValue = '', $lang = '', $array = 0, $limit = 0, $offset = -1) {
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
        if ($limit > 0 && $offset > -1) {
            $result = $data->limit($limit)->offset($offset)->get();
        } elseif ($limit > 0 && $offset == -1) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function SearchPost($search, $type = 'post', $is_active = '', $limit = 0) {
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

    public static function totalPrice($price, $discount) {
        return conditionPrice(round($price - (($price * $discount) / 100), 2));
    }

    public static function lastMonth($month, $date, $type = 'post') {

        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$month, $date])->get();
        return $count[0]->count;
    }

    public static function lastWeek($week, $date, $type = 'post') {

        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$week, $date])->get();
        return $count[0]->count;
    }

    public static function lastDay($day, $date, $type = 'post') {
        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$day, $date])->get();
        return $count[0]->count;
    }

    public static function PostOrderUserView($lang, $user_id, $type = 'post', $is_active = 1) {
        $data = Post::select(DB::raw('sum(posts.view_count) AS view_count'))
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

    public static function PostUser($lang, $user_id, $type = 'post', $is_active = 1, $count = 1) {
        $data = Post::where('type', $type)->where('user_id', $user_id)
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

    public static function get_postCageortyRow($posts, $api = 0) {
        $data = [];
        foreach ($posts as $key => $value) {
            $data_value['link'] = $value->link;
            $data_value['name'] = $value->name;
            $data_value['discount'] = $value->discount;
            $data_value['price'] = $value->price;
            $data_value['row'] = $value->row;
            $data_value['id'] = $value->id;
            $data[$value->row] = $data_value;
        }
        return $data;
    }

}
