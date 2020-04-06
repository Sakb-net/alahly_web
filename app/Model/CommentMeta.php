<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CommentMeta extends Model {

    protected $table = 'comment_meta';
  //  public $timestamps = false;
    protected $fillable = [
        'comment_id', 'meta_type', 'meta_key', 'meta_value'
    ];

    public function comment() {
        return $this->belongsTo(\App\Model\Comment::class);
    }

    public function insertMeta($comment_id, $meta_type, $meta_key, $meta_value) {

        $this->comment_id = $comment_id;
        $this->meta_type = $meta_type;
        $this->meta_key = $meta_key;
        $this->meta_value = $meta_value;
        return $this->save();
    }


    public function updateMeta($comment_id, $meta_type, $meta_key, $meta_value) {
        $comment_meta = static::where('comment_id', $comment_id)->where('meta_type', $meta_type)->first();
        if (isset($comment_meta)) {
            $comment_meta->meta_key = $meta_key;
            $comment_meta->meta_value = $meta_value;
            return $comment_meta->save();
        } else {
            return $this->insertMeta($comment_id, $meta_type, $meta_key, $meta_value);
        }
    }

    public static function deleteMeta($comment_id, $meta_type) {
        return static::where('comment_id', $comment_id)->where('meta_type', $meta_type)->delete();
    }

}
