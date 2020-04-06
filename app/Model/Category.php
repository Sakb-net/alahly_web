<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'categories';
    protected $fillable = [
        'name', 'link', 'type', 'content', 'description', 'parent_id', 'order_id', 'user_id', 'type_state',
        'is_active', 'icon_image', 'icon', 'update_by', 'lang_id', 'lang'
    ]; //, 'lang_id', 'lang'

//type_state --> normal,best,special,complete,not_valid

    public function categoryMeta() {
        return $this->hasMany(\App\Model\CategoryMeta::class);
    }

//    public function category_post() {
//         return $this->belongsTo(\App\Model\CategoryPost::class);
//    }
    public function tags() {
        return $this->morphToMany(\App\Model\Tag::class, 'taggable');
    }

    public function posts() {
        return $this->belongsToMany(\App\Model\Post::class);
    }

    public function user() {
        return $this->belongsToMany(\App\User::class);
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

    public static function updateColum($id, $colum, $columValue) {
        $data = static::findOrFail($id);
        $data->$colum = $columValue;
        return $data->save();
    }

    public static function updateOrderColum($colum, $valueColum, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->update([$columUpdate => $valueUpdate]);
    }

    public static function foundLink($link, $type = "main") {
        $link_found = static::where('link', $link)->where('type', $type)->first();
        if (isset($link_found)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function DataLangAR($lang_id) {
        $data = static::where('lang_id', $lang_id)->where('lang', '<>', 'ar')->get();
        return $data;
    }

    public static function categoryDataLang($lang_id, $lang, $column = '') {
        $data = static::where('lang_id', $lang_id)->where('lang', $lang)->first();
        if (isset($data->id) && !empty($column)) {
            return $data->$column;
        } else {
            $data;
        }
    }

    public static function get_categoryID($id, $colum, $all = 0) {
        $category = Category::where('id', $id)->first();
        if ($all == 0) {
            return $category->$colum;
        } else {
            return $category;
        }
    }

    public static function get_categoryRow($id, $colum = 'id', $is_active = 1) {
        $category = Category::where($colum, $id)->where('is_active', $is_active)->first();
        return $category;
    }

    public static function get_categoryCloum($colum = 'id', $val = '', $is_active = 1) {
        $category = Category::where($colum, $val)->where('is_active', $is_active)->orderBy('id', 'DESC')->first();
        return $category;
    }

    public static function LastRowActiveParent($colum = 'id', $val = '', $parent_id = 0, $is_active = 1) {
        $category = Category::where($colum, $val)->where('parent_id', $parent_id)->where('is_active', $is_active)->orderBy('id', 'DESC')->first();
        return $category;
    }

    public static function cateorySelect($parent_id, $type, $colum, $columValue, $is_active = 1, $array = 1, $order_col = 'id', $type_order = 'DESC') {
        $data = Category::where('type', $type)->where('parent_id', $parent_id)
                ->where('is_active', $is_active);
        if (!empty($colum)) {
            $category = $data->where($colum, $columValue);
        }
        $category = $data->orderBy($order_col, $type_order);
        if ($array == 1) {
            $category = $data->pluck('id', 'name')->toArray();
        } else {
            $category = $data->get();
        }
        return $category;
    }

    public static function cateorySelectArrayCol($parent_id, $type, $colum, $columValue = [], $is_active = 1, $array = 1) {
        $data = Category::where('type', $type)->where('parent_id', $parent_id)
                        ->whereIn($colum, $columValue)->where('is_active', $is_active);
        if ($array == 1) {
            $category = $data->pluck('id', 'name')->toArray();
        } else {
            $category = $data->get();
        }
        return $category;
    }

    public static function cateoryArrayCol($type, $colum, $columValue = [], $is_active = 1, $array = 1) {
        $data = Category::where('type', $type)->whereIn($colum, $columValue)
                        ->where('is_active', $is_active)->orderBy('id', 'DESC');
        if ($array == 1) {
            $category = $data->pluck('id', 'name')->toArray();
        } else {
            $category = $data->get();
        }
        return $category;
    }

    public static function get_category($parent_id, $type, $colum, $columValue, $limit, $colum_two = '', $columValue_two = '') {
        $data = Category::where('type', $type)->where($colum, $columValue)->orderBy('order_id', 'ASC');
        if (!empty($colum_two)) {
            if ($colum_two == 'is_active') {
                $result = $data->has('childrens')->with(['childrens' => function($query) use($colum_two, $columValue_two) {
                        $query->where($colum_two, $columValue_two);
                    }]);
            }
            $result = $data->where($colum_two, $columValue_two);
        }
        if ($parent_id == -1) {
            $parent_id = NULL;
            $result = $data->where('parent_id', '<>', $parent_id);
        } else {
            $result = $data->where('parent_id', $parent_id);
        }
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_category_ParentID($id) {
        $subcategories = Category::where('parent_id', $id)->get();
        return $subcategories;
    }

    public static function get_LastRow($type, $parent_id = NULL, $lang = 'ar', $colum, $data_order = 'order_id') {
        $category = Category::where('lang', $lang)->where('type', $type)->where('parent_id', $parent_id)->orderBy($data_order, 'DESC')->first();
        if (!empty($category)) {
            return $category->$colum;
        } else {
            return 0;
        }
    }

    public static function SearchCategory($search, $is_active = '', $limit = 0) {
        $data = static::Where('name', 'like', '%' . $search . '%')
                ->orWhere('lang', 'like', '%' . $search . '%')
                ->orWhere('link', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('icon_image', 'like', '%' . $search . '%')
                ->orWhere('icon', 'like', '%' . $search . '%')
                ->orWhere('user_id', 'like', '%' . $search . '%')
                ->orWhere('order_id', 'like', '%' . $search . '%');

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

//***********************************************************************
    public static function getData_cateorySelect($parent_id, $type, $colum, $columValue, $is_active = 1, $array = 1, $api = 0) {
        $data_categories = Category::cateorySelect($parent_id, $type, $colum, $columValue, $is_active, $array);
        $array_categories = Category::get_DataTeamUser($data_categories); //SelectDataCategoryMore
        $categories = $array_categories;
        return $categories;
    }

    public static function get_DataChild_child($parent_id, $categories, $type, $api = 0) {
        $all_cat_id = [$parent_id];
        foreach ($categories as $key => $val_cat) {
            $all_cat_id[] = $val_cat->id;
        }
        $data = static::cateoryArrayCol($type, 'parent_id', $all_cat_id, 1, 0);
        return $data;
    }

//********************teams & sport ************************
    public static function SelectDataTeam($categories, $parent_id = NUll) {
        $all_data = [];
        foreach ($categories as $key => $val_cat) {
            $array_data['name'] = $val_cat->name;
            $array_data['content'] = $val_cat->content;
            $array_data['link'] = $val_cat->link;
            $array_data['type'] = $val_cat->type;
            $subteam = $val_cat->childrens->where('type', 'subteam');
            $array_data['count_subteam'] = count($subteam);
            $array_data['subteams'] = [];
            if ($array_data['count_subteam'] > 0) {
//                $array_data['icon_image'] = $val_cat->icon_image;
                $array_data['subteams'] = Category::SelectDataTeam($subteam, $val_cat->id);
            }
            $all_data[] = $array_data;
        }
        return $all_data;
    }

    public static function get_DataTeamUser($categories, $api = 0) {
        $all_data = [];
        foreach ($categories as $key => $val_cat) {
            $all_data[] = static::single_DataTeamUser($val_cat, $api);
        }
        return $all_data;
    }

    public static function single_DataTeamUser($val_cat, $api = 0) {
        $array_data['type'] = $val_cat->type;
        $array_data['link'] = $val_cat->link;
        $array_data['name'] = $val_cat->name;
        $array_data['user_image'] = $val_cat->icon_image;
        $array_data['user_type'] = $val_cat->type_state;
        $array_data['content'] = $val_cat->content;
        $array_data['created_at'] = $val_cat->created_at->format('Y-m-d');
        $array_data['sport'] = $array_data['num_sport'] = $array_data['height'] = $array_data['weight'] = $array_data['location'] = $array_data['birthdate'] = $array_data['age'] = $array_data['national'] = null;
        $description = json_decode($val_cat->description, true);
        if (empty($description)) {
            $description = [];
        }
        foreach ($description as $key => $val_res) {
            $array_data[$key] = $val_res;
        }
        if (!empty($array_data['birthdate'])) {
            $array_data['age'] = cal_age_birthdate($array_data['birthdate']);
        }
        return $array_data;
    }

//********************audiences************************
    public static function get_DataAudiences($categories, $api = 0) {
        $all_data = [];
        foreach ($categories as $key => $val_cat) {
//            $array_data['type'] = $val_cat->type;
            $array_data['link'] = $val_cat->link;
            $array_data['name'] = $val_cat->name;
//            $array_data['content'] = $val_cat->content;
            $array_data['rate'] = 6 * ( ++$key);
            $array_data['created_at'] = $val_cat->created_at->format('Y-m-d');
            $all_data[] = $array_data;
        }
        return $all_data;
    }

//********************Master************************
    public static function SelectDataMaster($categories, $api = 0) {
        $all_data = [];
        foreach ($categories as $key => $val_cat) {
            $array_data['type'] = $val_cat->type;
            $array_data['link'] = $val_cat->link;
            $array_data['name'] = $val_cat->name;
            $array_data['type_state'] = $val_cat->type_state;
            $array_data['color'] = '#ccc';
            if ($val_cat->type_state != 'not_valid') {
                $array_data['color'] = '#999';
            } elseif ($val_cat->type_state != 'best') {
                $array_data['color'] = '#0156b2';
            } elseif ($val_cat->type_state != 'normal') {
                $array_data['color'] = '#9fc5ef';
//            } elseif ($val_cat->type_state != 'special') {
//                $array_data['color'] = '';
//            } elseif ($val_cat->type_state != 'complete') {
//                $array_data['color'] = '';
            }
            $array_data['content'] = $val_cat->content;
            $array_data['created_at'] = $val_cat->created_at->format('Y-m-d');

            $all_data[] = $array_data;
        }
        return $all_data;
    }

    public static function SelectDataCategory($categories, $parent_id = NUll) {
        $all_data = [];
        foreach ($categories as $key => $val_cat) {
            $array_data['name'] = $val_cat->name;
            $array_data['content'] = $val_cat->content;
            $array_data['link'] = $val_cat->link;
            $array_data['icon_image'] = $val_cat->icon_image;
            if ($parent_id == NULL || $parent_id == 0) {
                $array_data['subcategories'] = Category::SelectDataCategory($val_cat->childrens, $val_cat->id);
            } else {
//                $array_data['parent_id'] = $parent_id;
            }
            $all_data[] = $array_data;
        }
        return $all_data;
    }

//***************************************************************************************

    public function insertCategory($user_id, $name, $link, $content, $type = "main", $parent_id = NULL, $order_id = 1, $icon = NULL, $icon_image = NUll, $is_active = 1, $updated_by = 0) {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->link = $link;
        $this->type = $type;
        $this->content = $content;
        $this->is_active = $is_active;
        $this->parent_id = $parent_id;
        $this->order_id = $order_id;
        $this->icon = $icon;
        $this->icon_image = $icon_image;
        $this->updated_by = $updated_by;
        return $this->save();
    }

    public static function updateCategory($id, $name, $content, $icon = NULL, $icon_image = NUll, $is_active = 1, $parent_id = NULL) {
        $category = static::findOrFail($id);
        $category->name = $name;
        $category->content = $content;
        $category->icon = $icon;
        $category->icon_image = $icon_image;
        $category->is_active = $is_active;
        $category->parent_id = $parent_id;
        return $category->save();
    }

}
