<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryMatch extends Model {

    protected $table = 'category_match';
    public $timestamps = false;
    protected $fillable = [
        'category_id', 'match_id'
    ];

//public function matchs() {
//         return $this->hasMany(\App\Model\Match::class);
//    }
//    public function categories() {
//         return $this->hasMany(\App\Model\Category::class);
//    }
    public function insertCategoryMatch($category_id, $match_id) {
        $this->category_id = $category_id;
        $this->match_id = $match_id;
        return $this->save();
    }

    public static function deleteCategoryMatch($match_id, $category_id) {
        return self::where('match_id', $match_id)->where('category_id', $category_id)->delete();
    }

    public static function deleteMatch($match_id) {
        return self::where('match_id', $match_id)->delete();
    }

    public static function deleteCategory($category_id) {
        return self::where('category_id', $category_id)->delete();
    }

    public static function foundCategoryMatch($match_id, $category_id) {

        $category = self::where('match_id', $match_id)->where('category_id', $category_id)->first();
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
