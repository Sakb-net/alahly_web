<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model {

    protected $table = 'category_product';
    protected $fillable = [
        'name', 'link', 'type', 'content', 'parent_id', 'order_id', 'user_id', 'type_state',
        'is_active', 'icon_image', 'icon', 'update_by', 'lang_id', 'lang'
    ];

//    public function category_products() {
//         return $this->belongsTo(\App\Model\CategoryProductProduct::class);
//    }
    public function tags() {
        return $this->morphToMany(\App\Model\Tag::class, 'taggable');
    }

    public function products() {
        return $this->belongsToMany(\App\Model\Product::class);
    }

    public function user() {
        return $this->belongsToMany(\App\User::class);
    }

    public function childrens() {
        return $this->hasMany(\App\Model\CategoryProduct::class, 'parent_id');
    }

    public function parentID() {
        return $this->belongsTo(\App\Model\CategoryProduct::class, 'parent_id');
    }

    public function langID() {
        return $this->belongsTo(\App\Model\CategoryProduct::class, 'lang_id');
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

    public static function get_categoryID($id, $colum) {
        $category = CategoryProduct::where('id', $id)->first();
        return $category->$colum;
    }

    public static function get_categoryRow($id, $colum = 'id', $is_active = 1) {
        $category = CategoryProduct::where($colum, $id)->where('is_active', $is_active)->first();
        return $category;
    }

    public static function cateorySelect($parent_id, $type, $colum, $columValue, $is_active = 1, $array = 1, $limit = 0, $offset = -1) {
        $data = CategoryProduct::where('type', $type)->where('parent_id', $parent_id)->where('is_active', $is_active)
                        ->with(['childrens' => function($query) use($is_active) {
                                $query->where('is_active', $is_active)->withCount(['products' => function($query) use ($is_active) {
                                        $query->where('is_active', $is_active);
                                    }])->orderBy('products_count', 'DESC');
                            }])
                        ->withCount(['products' => function($query) use ($is_active) {
                                $query->where('is_active', $is_active);
                            }])->orderBy('products_count', 'DESC');
        if (!empty($colum)) {
            $category = $data->where($colum, $columValue);
        }
        if ($array == 1) {
            $category = $data->pluck('id', 'name')->toArray();
        } elseif ($limit > 0 && $offset == -1) {
            $category = $data->paginate($limit);
        } elseif ($limit > 0 && $offset >= 0) {
            $category = $data->offset($offset)->limit($limit)->get();
        } else {
            $category = $data->get();
        }
        return $category;
    }

    public static function cateorySelectArrayCol($parent_id, $type, $colum, $columValue = [], $is_active = 1, $array = 1) {
        $data = CategoryProduct::where('type', $type)->where('parent_id', $parent_id)
                        ->whereIn($colum, $columValue)->where('is_active', $is_active);
        if ($array == 1) {
            $category = $data->pluck('id', 'name')->toArray();
        } else {
            $category = $data->get();
        }
        return $category;
    }

    public static function get_category($parent_id, $type, $colum, $columValue, $limit, $colum_two = '', $columValue_two = '') {
        $data = CategoryProduct::where('type', $type)->where($colum, $columValue)->orderBy('order_id', 'ASC');
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
        $subcategories = CategoryProduct::where('parent_id', $id)->get();
        return $subcategories;
    }

    public static function get_LastRow($type, $parent_id = NULL, $lang = 'ar', $colum, $data_order = 'order_id') {
        $category = CategoryProduct::where('lang', $lang)->where('type', $type)->where('parent_id', $parent_id)->orderBy($data_order, 'DESC')->first();
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

    public static function get_categoryOrdrMoreData($parent_categry_id, $parent_id, $type, $colum, $columValue, $limit, $colum_two = '', $columValue_two = '', $order_col = 'childrens_count') {
        $data = static::where('type', $type)->withCount(['products' => function($query) use ($colum_two, $columValue_two) {
                                $query->where($colum_two, $columValue_two);
                            }])
                        ->withCount(['childrens' => function($query) use ($colum_two, $columValue_two) {
                                $query->where($colum_two, $columValue_two);
                            }])
//                        ->whereHas('products', function($query) use ($colum_two, $columValue_two) {
//                            $query->where($colum_two, $columValue_two);
//                        })
                        ->has('childrens')->with(['childrens' => function($query) use($colum_two, $columValue_two) {
                $query->where($colum_two, $columValue_two)->withCount(['products' => function($query) use ($colum_two, $columValue_two) {
                        $query->where($colum_two, $columValue_two);
                    }])->orderBy('products_count', 'DESC');
            }]);

        if (!empty($parent_categry_id)) {
            $result = $data->whereIn('id', $parent_categry_id);
        }
        if ($parent_id == -1) {
            $parent_id = NULL;
            $result = $data->where('parent_id', '<>', $parent_id);
        } else {
            $result = $data->where('parent_id', $parent_id);
        }
        $result = $data->where($colum_two, $columValue_two);
        $result = $data->orderBy($order_col, 'DESC'); //childrens_count
//        $result = $data->orderBy('products_count', 'DESC');
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }

        return $result;
    }

//***********************************************************************
    public static function getData_cateorySelect($parent_id, $type, $colum, $columValue, $is_active = 1, $array = 1, $api = 0, $limit = 0, $offset = -1) {
//        $data_categories = CategoryProduct::get_categoryOrdrMoreData([], 0, 'product', 'lang', $lang, $limit, 'is_active', 1);
        $data_categories = CategoryProduct::cateorySelect($parent_id, $type, $colum, $columValue, $is_active, $array,$limit,$offset);
        $array_categories = CategoryProduct::SelectDataCategory($data_categories); //SelectDataCategoryMore
        $categories = $array_categories['all_data'];
        return $categories;
    }

    public static function SelectDataCategory($categories, $parent_id = NUll, $products_count = 0) {
        $all_data = [];
        foreach ($categories as $key => $val_cat) {
            $array_data['name'] = $val_cat->name;
            $array_data['content'] = $val_cat->content;
            $array_data['link'] = $val_cat->link;
            $array_data['products_count'] = $val_cat->products_count;
            $products_count += $val_cat->products_count;
            $array_data['image'] = $val_cat->icon_image;
            if ($parent_id == NULL || $parent_id == 0) {
                $sub_data = CategoryProduct::SelectDataCategory($val_cat->childrens, $val_cat->id, $products_count);
                $array_data['subcategories'] = $sub_data['all_data'];
                $array_data['products_count'] = $sub_data['products_count'];
                $products_count = 0;
            } else {
//                $array_data['parent_id'] = $parent_id;
            }
            $all_data[] = $array_data;
        }
        return array('all_data' => $all_data, 'products_count' => $products_count);
    }

    public static function SelectDataCategoryMore($categories, $array_categry_id = [], $type_api = '', $parent_id = NUll, $products_count = 0, $lang = 'ar', $api = 0) {
        $all_data = [];
        foreach ($categories as $key => $val_cat) {
            $array_data['name'] = $val_cat->name;
            $array_data['content'] = $val_cat->content;
            $array_data['link'] = $val_cat->link;
//            $array_data['products_count'] = $val_cat->products_count;
//            $cat_count = $val_cat->childrens_count;
//            if (empty($cat_count)) {
//                $cat_count = 0;
//            }
//            $array_data['count_cat'] = $cat_count;
            $array_data['image'] = $val_cat->icon_image;
            if ($parent_id == NULL || $parent_id == 0) {
//                $array_data['icon'] = $val_cat->icon;
                $subcategories = static::SelectDataCategoryMore($val_cat->childrens, $array_categry_id, $type_api, $val_cat->id, $val_cat->products_count);
                $array_data['count_cat'] = count($subcategories);
                if ($array_data['count_cat'] == 0) {
                    $array_data = [];
                } else {
                    $array_data['subcategories'] = $subcategories;
                }
            } else {
                if (!empty($array_categry_id) && in_array($val_cat->id, $array_categry_id)) {
                    $ok = 1;
                } elseif (empty($array_categry_id)) {
                    $ok = 1;
                } else {
                    $ok = 0;
                }
                if ($ok == 1) {
                    if ($val_cat->products_count > 0) {
                        if ($type_api == 'home') {
                            $array_catgeory_id = [$val_cat->lang_id];
                            foreach ($val_cat->childrens as $key_ch => $val_ch) {
                                $array_catgeory_id[] = $val_ch->lang_id;
                            }
                            $products = Product::Category_product($lang, $array_catgeory_id, [], 'id', 'DESC', 1, 0, $api);
                            $array_data['count_products'] = count($products);
                            $array_data['products'] = $products;
                        }
                    } else {
                        $array_data = [];
                    }
                }
            }
            if (!empty($array_data)) {
                $all_data[] = $array_data;
            }
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
