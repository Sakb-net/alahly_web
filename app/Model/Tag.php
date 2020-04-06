<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    protected $table = 'tags';
    public $fillable = ['id', 'name'];

    public function posts() {
        return $this->morphedByMany(\App\Model\Post::class, 'taggable');
    }

    public function categories() {
        return $this->morphedByMany(\App\Model\Category::class, 'taggable');
    }

    public function searches() {
        return $this->morphedByMany(\App\Model\Search::class, 'taggable');
    }

    public function insertTag($name) {
        $this->name = $name;
        return $this->save();
    }

    public static function updateTag($id, $name) {
        $tag = static::findOrFail($id);
        $tag->name = $name;
        return $tag->save();
    }

    public static function foundTag($name) {
        $tag = static::where('name', $name)->first();
        if (isset($tag)) {
            return $tag->id;
        } else {
            return 0;
        }
    }

    public static function ChapterTag($id, $type = 'course', $is_search = 0, $api = 0) {
        $data = static::whereIn('id', function($query)use ($id, $type, $is_search) {
                    $query->select('tag_id')
                            ->from(with(new Taggable)->getTable())
                            ->where('is_search', $is_search)->where('taggable_id', '=', $id)->where('taggable_type', '=', $type);
                });
        if ($api == 1) {
            $tagdata = $data->get();
            $tag=[];
            foreach ($tagdata as $key => $val) {
                $t_data['name']=$val->name;
                $tag[]=$t_data;
            }
        } else {
            $tag = $data->pluck('name', 'name')->toArray();
        }
        return $tag;
    }

    public static function deleteTag($id) {
        return static::where('id', $id)->delete();
    }

}
