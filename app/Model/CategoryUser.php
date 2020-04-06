<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryUser extends Model {

    protected $table = 'category_user';
    public $timestamps = false;
    protected $fillable = [
        'category_id', 'user_id', 'type', 'rate', 'link', 'is_active'
    ];
//type---> audience,vote
//public function users() {
//         return $this->hasMany(\App\User::class);
//    }
//    public function categories() {
//         return $this->hasMany(\App\Model\Category::class);
//    }
    public function insertCategoryUser($category_id, $user_id = null, $type = 'audience', $rate = 0, $is_active = 1) {
        $this->category_id = $category_id;
        $this->user_id = $user_id;
        $this->type = $type;
        $this->rate = $rate;
        $this->link = time();
        $this->is_active = $is_active;
        return $this->save();
    }

    public static function deleteCategoryUser($user_id, $category_id) {
        return self::where('user_id', $user_id)->where('category_id', $category_id)->delete();
    }

    public static function deleteUser($user_id) {
        return self::where('user_id', $user_id)->delete();
    }

    public static function deleteCategory($category_id) {
        return self::where('category_id', $category_id)->delete();
    }

    public static function foundCategoryUser($user_id, $category_id) {

        $category = self::where('user_id', $user_id)->where('category_id', $category_id)->first();
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
