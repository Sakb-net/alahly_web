<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Taggable extends Model {

    protected $table = 'taggables';
    public $timestamps = false;
    protected $fillable = [
         'tag_id','taggable_id','taggable_type','is_search'
    ];

    public function insertTaggable($tag_id, $taggable_id, $taggable_type,$is_search=1) {

        $this->tag_id = $tag_id;
        $this->taggable_id = $taggable_id;
        $this->taggable_type = $taggable_type;
        $this->is_search = $is_search;
        return $this->save();
    }
    
    public static function foundTaggable($tag_id, $taggable_id, $taggable_type,$is_search=1) {
        $tag  = static::where('tag_id', $tag_id)->where('taggable_id', $taggable_id)->where('is_search', $is_search)->where('taggable_type', $taggable_type)->first();
        if (isset($tag)) {
            return 1;
        }  else {
            return 0;
        }
    }
    
    public static function deleteTaggableType($taggable_id, $taggable_type,$is_search=1) {
        return static::where('taggable_id', $taggable_id)->where('is_search', $is_search)->where('taggable_type', $taggable_type)->delete();
    }
    public static function deleteAllTaggableType($taggable_id, $taggable_type) {
        return static::where('taggable_id', $taggable_id)->where('taggable_type', $taggable_type)->delete();
    }
    
    public static function deleteTag($tag_id) {
        return static::where('tag_id', $tag_id)->delete();
    }
    
    public static function deleteTagType($tag_id,$taggable_type,$is_search=1) {
        return static::where('tag_id', $tag_id)->where('is_search', $is_search)->where('taggable_type', $taggable_type)->delete();
    }
    
    public static function SearchTag($search,$is_search = 1, $array_taggable_type = ['bundle', 'course', 'chapter', 'lecture']) {
        $search = static::whereIn('tag_id', function($query)use ($is_search,$search,$array_taggable_type) {
                    $query->select('id')
                            ->from(with(new Tag)->getTable())
                            ->where('is_search',$is_search)->whereIn('taggable_type',$array_taggable_type)
                            ->where('name', 'like', '%' . $search . '%');
                })->pluck('taggable_type', 'taggable_id')->toArray();
        return $search;
    }
}

