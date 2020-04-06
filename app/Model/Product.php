<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use App\Model\Fees;

class Product extends Model {

    protected $table = 'products';
    protected $fillable = [
        'user_id', 'update_by', 'parent_id', 'name', 'link', 'type', 'image', 'another_image',
        'view_count', 'description', 'content', 'price', 'discount', 'fees_id', 'code',
        'comment_count', 'order_id', 'is_share', 'is_comment', 'is_read',
        'is_active', 'lang', 'lang_id', 'number_prod', 'sale_number_prod'
    ];

//'number_prod' ----> all amount product
// 'sale_number_prod' ----> all amount that sale
//content --> all another data for products
    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function langID() {
        return $this->belongsTo(\App\Model\Product::class, 'lang_id');
    }

    public function childrens() {
        return $this->hasMany(\App\Model\Product::class, 'parent_id');
    }

    public function grandchildren() {
        return $this->hasMany(\App\Model\Product::class, 'parent_id');
    }

    public function categories() {
        return $this->belongsToMany(\App\Model\CategoryProduct::class);
    }

//    public function category_product() {
//             return $this->belongsTo(\App\Model\CategoryProduct::class);
//        }
    public function actions() {
        return $this->morphMany(\App\Model\Action::class, 'actionable');
    }

    public function comments() {
        return $this->hasMany(\App\Model\CommentProduct::class);
    }

//    public function productMeta() {
//        return $this->hasMany(\App\Model\ProductMeta::class);
//    }

    public function tags() {
        return $this->morphToMany(\App\Model\Tag::class, 'taggable');
    }

    public static function Addanotherlang($old_id, $new_id, $user_id, $order_id) {
        $lang_anothers = Product::DataLangAR($old_id);
        foreach ($lang_anothers as $keyLang => $valueLang) {
            $input = [];
            $old_product_lang = $valueLang->toArray();
            foreach ($old_product_lang as $key => $val_Lang) {
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
            $new_product = Product::create($input);
        }
    }

    public static function updateColum($id, $colum, $columValue) {
        $data = static::findOrFail($id);
        $data->$colum = $columValue;
        return $data->save();
    }

    public static function updateColumProductCount($product_id, $colum = 'sale_number_prod', $columValue = 0) {
        $data = static::where('id', $product_id)->first();
        if (isset($data->id)) {
            $data->$colum += $columValue;
            return $data->save();
        } else {
            return false;
        }
    }

    public static function updateOrderColum($colum, $valueColum, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->update([$columUpdate => $valueUpdate]);
    }

    public static function updateProductTime($id, $user_id) {
        $product = static::findOrFail($id);
        $product->updateProduct_at = new Carbon();
        $product->updateProduct_by = $user_id;
        return $product->save();
    }

    public static function updateProductViewCount($id) {
        return static::where('id', $id)->increment('view_count');
    }

    public static function countProductUnRead() {
        return static::where('is_read', 0)->count();
    }

    public static function countProductTypeUnRead($type = 'product') {
        return static::where('type', $type)->where('is_read', 0)->count();
    }

    public static function deleteProductParent($parent_id, $type) {
        if ($type == 'product') {
            $products = static::where('parent_id', $parent_id)->get();
            foreach ($products as $key => $product) {
                if (isset($product->id)) {
                    static::deleteProductParent($product->id, $product->type);
                    static::find($product->id)->delete();
                }
            }
            Feature::deleteProductBundle($parent_id, 0);
            return 1;
        } else {
            return self::where('parent_id', $parent_id)->delete();
        }
    }

    public static function get_LastRow($type, $lang, $parent_id = NULL, $colum, $data_order = 'order_id') {
        $product = Product::where('type', $type)->where('lang', $lang)->where('parent_id', $parent_id)->orderBy($data_order, 'DESC')->first();
        if (!empty($product)) {
            return $product->$colum;
        } else {
            return 0;
        }
    }

    public static function get_LastChairRow($type, $category_id, $another_image, $col_order) {
        $product = Product::whereHas('categories', function ($q) use($category_id) {
                    $q->where('id', $category_id);
                })->where('type', $type)->where('another_image', $another_image)->first();  //orderBy($col_order, 'DESC')->
        if (isset($product->id)) {
            $another_image += 1;
            if ($another_image <= 100) {
                $another_image = Product::get_LastChairRow($type, $category_id, $another_image, $col_order);
                return $another_image;
            } else {
                return 0;
            }
        } else {
            return $another_image;
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

    public static function get_productCageorty($link, $is_active = 1) {
        $data = Product::whereHas('categories', function ($q)use($is_active, $link) {
                    $q->where('is_active', $is_active)->where('link', $link);
                })->where('is_active', $is_active)->get();
        return $data;
    }

    public static function get_productLink($col_name, $col_val, $is_active = 1) {
        $data = static::with(['childrens' => function ($q) {
                        $q->orderBy('order_id', 'asc');
                    }])->where($col_name, $col_val);
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->first();
        return $result;
    }

    public static function get_productType($link, $type = 'product', $is_active = 1) {
        $data = static::with(['childrens' => function ($q) {
                        $q->orderBy('order_id', 'asc');
                    }])->where('link', $link)->where('type', $type);
        if ($is_active == 1 || $is_active == 0) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->first();
        return $result;
    }

    public static function get_DataType($link, $col_name = 'link', $type = 'product', $is_active = 1, $user_id = NULL) {
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

    public static function get_product($colum, $valColum, $lang = 'ar', $is_active = 1) {
        $data_one = static::where($colum, $valColum)->where('is_active', $is_active)->first();
        if (isset($data_one->lang_id)) {
            $data = static::where('lang_id', $data_one->lang_id)->where('is_active', $is_active)->where('lang', $lang)->first();
        } else {
            $data = $data_one; //[];
        }
        return $data;
    }

    public static function getProductType($colum, $columvalue, $type = 'product', $lang = 'ar', $columOrder = 'order_id', $columvalueOrder = 'ASC', $is_active = 1, $limit = 0) {
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

    public static function getProducts($colum, $columvalue, $type, $parent_id = NULL, $parent_state = '=', $limit = 0) {
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

    public static function getProductsNotArray($colum, $columvalue, $type = 'product', $limit = 0, $lang, $is_active = '', $col_val = 'lang_id', $offset = 0) {
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

    public static function getProductsArray($colum, $columvalue, $limit = 0, $lang, $is_active = '') {
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

    public static function productData($id, $column = 'name') {
        $product = static::where('id', $id)->first();
        if (isset($product)) {
            return $product->$column;
        } else {
            return '';
        }
    }

    public static function productDataLang($lang_id, $lang, $column = '') {
        $product = static::where('lang_id', $lang_id)->where('lang', $lang)->first();
        if (!empty($column) && isset($product->$column)) {
            return $product->$column;
        } else {
            return$product;
        }
    }

    public static function productDataUser($id, $column = '') {
        $product = static::with('user')->where('id', $id)->first();
        if (!empty($column)) {
            return $product->$column;
        } else {
            return $product;
        }
    }

    public static function productDataCategory($lang, $array_category_id, $array_product_id, $colum_order, $val_order, $is_active, $limit) {
        $data = static::with('user')->whereHas('categories', function ($q) use ($array_category_id, $lang) {
                    $q->whereIn('category_product_id', $array_category_id)->where('lang', $lang);
                })->wherenotIn('id', $array_product_id)->where('is_active', $is_active)->where('lang', $lang);
        $data->orderBy($colum_order, $val_order);
        if ($limit > 0) {
            $products = $data->paginate($limit);
        } else {
            $products = $data->get();
        }
        return $products;
    }

    public static function get_ProductActiveArray($is_active, $type = 'product', $lang = 'ar') {
        $data = Product::where('lang', $lang)->where('type', $type)
                        ->where('is_active', $is_active)->pluck('lang_id', 'name')->toArray();
        return $data;
    }

    public static function get_ProductActive($type, $is_active, $column = '', $columnValue = '', $lang = '', $array = 0, $limit = 0, $offset = -1, $col_order = 'id', $val_order = 'DESC') {
        $data = static::with('user')->with('categories')->where('type', $type);
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
        $result = $data->orderBy($col_order, $val_order);
        if ($limit > 0 && $offset > -1) {
            $result = $data->limit($limit)->offset($offset)->get();
        } elseif ($limit > 0 && $offset == -1) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function SearchProduct($search, $type = 'product', $is_active = '', $limit = 0) {
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

    public static function lastMonth($month, $date, $type = 'product') {

        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$month, $date])->get();
        return $count[0]->count;
    }

    public static function lastWeek($week, $date, $type = 'product') {

        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$week, $date])->get();
        return $count[0]->count;
    }

    public static function lastDay($day, $date, $type = 'product') {
        $count = static::select(DB::raw('COUNT(*)  count'))->where('type', $type)->whereBetween(DB::raw('created_at'), [$day, $date])->get();
        return $count[0]->count;
    }

    public static function ProductOrderUserView($lang, $user_id, $type = 'product', $is_active = 1) {
        $data = Product::select(DB::raw('sum(products.view_count) AS view_count'))
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

    public static function ProductUser($lang, $user_id, $type = 'product', $is_active = 1, $count = 1) {
        $data = Product::where('type', $type)->where('user_id', $user_id)
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

    public static function Category_product($lang, $catgeory, $array_product_id, $colum_order, $val_order, $is_active, $limit, $api = 0) {
        $array_catgeory_id[] = $catgeory->lang_id;
        foreach ($catgeory->childrens as $key_ch => $val_ch) {
            $array_catgeory_id[] = $val_ch->lang_id;
        }
        $all_products = static::productDataCategory($lang, $array_catgeory_id, $array_product_id, $colum_order, $val_order, $is_active, $limit);
        $products = static::dataProduct($all_products, $api);
        return $products;
    }

    public static function all_Category_product($type, $is_active, $column = '', $columnValue = '', $lang = '', $array = 0, $limit = 0, $offset = -1, $api = 0, $col_order = 'id', $val_order = 'DESC') {
        $all_products = Product::get_ProductActive($type, $is_active, $column, $columnValue, $lang, $array, $limit, $offset, $col_order, $val_order);
        $products = static::dataProduct($all_products, $api);
        return $products;
    }

    public static function dataProduct($products, $api = 0) {
        $data = [];
        foreach ($products as $key => $value) {
            $data[] = static::get_ProductSingle($value, $api);
        }
        return $data;
    }

    public static function get_ProductSingle($value, $api = 0) {
//           $data_value['id'] = $value->id;
        $data_value['link'] = $value->link;
        $data_value['cat_link'] = $value->link;
        $data_value['cat_name'] = $value->name;
        if (isset($value->categories[0]->link)) {
            $data_value['cat_link'] = $value->categories[0]->link;
            $data_value['cat_name'] = $value->categories[0]->name;
        }
        $data_value['name'] = $value->name;
        $comment_rate = static::get_RateProduct($value->comments, $api);
        $data_value['star_rate'] = $comment_rate['star_rate'];
        $data_value['rate'] = $comment_rate['rate'];
        $data_value['number_prod'] = $value->number_prod;
        $data_value['sale_number_prod'] = $value->sale_number_prod;
        $data_value['valid_number_prod'] = $value->number_prod - $value->sale_number_prod;
        $data_value['discount'] = $value->discount;
        $data_value['price'] = $value->price;
        $data_value['total_price'] = static::totalPrice($value->price, $value->discount);
        $data_value['image'] = $value->image;
        $data_value['fees'] = $data_value['another_image'] = []; // (object) 
        $data_value['weight'] = $data_value['color'] = $data_value['dec_prod'] = [];
        $data_value['city_made'] = NULL;
        $content = json_decode($value->content, true);
        foreach ($content as $key => $val_res) {
            $data_value[$key] = $val_res;
        }

        if (empty($data_value['dec_prod'])) {
            $data_value['dec_prod'] = [];
        }
        // print_r($data_value['dec_prod']);die;
        foreach ($data_value['dec_prod'] as $key_prod => $val_prod) {
            $data_value['weight'][]['name'] = $val_prod['weight'];
        }
        if (!empty($data_value['color'])) {
            $data_value['color'] = static::ValueKeyArray($data_value['color'], $api);
        } else {
            $data_value['color'] = [];
        }
        $another_image = json_decode($value->another_image, true);
        foreach ($another_image as $key => $val_image) {
            $data_value['another_image'][]['name'] = $val_image;
        }
        $fees_id = json_decode($value->fees_id, true);
        $data_fees = Fees::feesSelectArrayCol('product', 'id', $fees_id, 1, 0);
        $data_value['fees'] = Fees::dataFees($data_fees, $api);
        if ($api == 1) {
            $data_value['description'] = $value->description;
        } else {
            $data_value['description'] = strip_tags($value->description);
        }
        return $data_value;
    }

    public static function fees_stripslashes($fees = [], $api = 0) {
        if (empty($fees)) {
            $fees = [];
        }
        $input_fees = [];
        foreach ($fees as $key => $value) {
            $input_fees[] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
        }
        return $input_fees;
    }

    public static function ValueDec_prod($product, $code_weight = '', $fees = [], $api = 0) {
        $ok_discount = $discount = 0;
        $price = $total_price = $total_price_fees = 0.00;
        $weight = '';
        $content = json_decode($product->content, true);
        foreach ($content as $key => $val_res) {
            $$key = $val_res;
        }
        if (empty($dec_prod)) {
            $dec_prod = [];
        }
        // print_r($dec_prod);die;
        foreach ($dec_prod as $key_prod => $val_prod) {
            if ($code_weight == $val_prod['code']) {
                $price = $total_price = $val_prod['price'];
                $discount = $val_prod['discount'];
                $weight = $val_prod['weight'];
                if ($val_prod['discount'] > 0) {
                    $ok_discount = 1;
                    $total_price = Product::totalPrice($val_prod['price'], $val_prod['discount']);
                }
                break;
            }
        }
        //add price fees to total price
        $data_fees = Fees::feesSelectArrayColTWo('product', 'id', 'link', $fees, 1, 0);
        $data_val_fees = Fees::dataFees($data_fees, 0, $total_price, 0, 1);
        if (isset($data_val_fees['total_price_fees'])) {
            $total_price_fees = $data_val_fees['total_price_fees'];
            $total_price += $data_val_fees['total_price_fees'];
        }
        return array('weight' => $weight, 'price' => $price, 'total_price_fees' => $total_price_fees, 'discount' => $discount, 'ok_discount' => $ok_discount, 'total_price' => $total_price);
    }

    public static function ValueKeyArray($array_data, $api = 0) {
        $data = [];
        foreach ($array_data as $key => $value) {
            $data[]['name'] = $value;
        }
        return $data;
    }

    public static function get_RateProduct($comments, $api = 0) {
        $comment_rate = ['star_rate' => 0, 'rate' => 0];
        foreach ($comments as $key => $value) {
            $comment_rate['rate'] += $value->rate;
        }
        if (isset($key)) {
            $key += 1;
            $comment_rate['star_rate'] = round($comment_rate['rate'] / $key);
        }
        return $comment_rate;
    }

}
