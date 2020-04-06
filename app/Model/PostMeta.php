<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model {

    protected $table = 'post_meta';
    public $timestamps = false;
    protected $fillable = [
        'post_id', 'meta_type', 'meta_key', 'meta_value', 'meta_etc','meta_link'
    ];

    public function post() {
        return $this->belongsTo(\App\Model\Post::class);
    }

    public function insertMeta($post_id, $meta_type, $meta_key, $meta_value,$meta_group = NULL) {

        $this->post_id = $post_id;
        $this->meta_type = $meta_type;
        $this->meta_key = $meta_key;
        $this->meta_value = $meta_value;
        $this->meta_group = $meta_group;
        return $this->save();
    }


    public function updateMeta($post_id, $meta_type, $meta_key, $meta_value,$meta_group = NULL) {
        $post_meta = static::where('post_id', $post_id)->where('meta_type', $meta_type)->first();
        if (isset($post_meta)) {
            $post_meta->meta_key = $meta_key;
            $post_meta->meta_value = $meta_value;
            $post_meta->meta_group = $meta_group;
            return $post_meta->save();
        } else {
            return $this->insertMeta($post_id, $meta_type, $meta_key, $meta_value,$meta_group);
        }
    }

    public static function deleteMeta($post_id, $meta_type) {
        return static::where('post_id', $post_id)->where('meta_type', $meta_type)->delete();
    }
    public static function deleteMetaKey($post_id, $meta_type,$meta_key) {
        return static::where('post_id', $post_id)->where('meta_type', $meta_type)->where('meta_key', $meta_key)->delete();
    }
    public static function deleteMetaTypeValue($post_id, $meta_type,$meta_key,$meta_value) {
        return static::where('post_id', $post_id)->where('meta_type', $meta_type)->where('meta_key', $meta_key)->where('meta_value', $meta_value)->delete();
    }

    public static function deleteArrayPostMeta($array_id) {
        $all_array_id = array_values($array_id);
        $result= PostMeta::whereIn('id', $all_array_id)->delete();
        return $result;
    }
}
