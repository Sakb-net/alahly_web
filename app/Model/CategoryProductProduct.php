<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryProductProduct extends Model {

    protected $table = 'category_product_product';
    public $timestamps = false;
    protected $fillable = [
        'category_product_id', 'product_id'
    ];

//public function products() {
//         return $this->hasMany(\App\Model\Product::class);
//    }
//    public function categories() {
//         return $this->hasMany(\App\Model\CategoryProduct::class);
//    }
    public function insertCategoryProductProduct($category_product_id, $product_id) {
        $this->category_product_id = $category_product_id;
        $this->product_id = $product_id;
        return $this->save();
    }

    public static function deleteCategoryProductProduct($product_id, $category_product_id) {
        return self::where('product_id', $product_id)->where('category_product_id', $category_product_id)->delete();
    }

    public static function deleteProduct($product_id) {
        return self::where('product_id', $product_id)->delete();
    }

    public static function deleteCategory($category_product_id) {
        return self::where('category_product_id', $category_product_id)->delete();
    }

    public static function foundCategoryProductProduct($product_id, $category_product_id) {

        $category = self::where('product_id', $product_id)->where('category_product_id', $category_product_id)->first();
        if (isset($category)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function getColume($colum, $columValue, $columReturn) {
        $data = static::where($colum, $columValue)->first();
        if (isset($data->$columReturn)) {
            $result = $data->$columReturn;
        } else {
            $result = '';
        }
        return $result;
    }

}
