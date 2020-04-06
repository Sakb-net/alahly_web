<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Search extends Model {

    protected $table = 'searches';
    protected $fillable = [
        'name','search_count','login_count','guest_count','is_active'
    ];


    public function tags() {
         return $this->morphToMany(\App\Model\Tag::class, 'taggable');
    }
    
    public function userSearch() {
        return $this->hasMany(\App\Model\UserSearch::class);
    }
    
    public function insertSearch($name,$search_count = 1,$login_count = 0,$guest_count = 0,$is_active = 1) {
        $this->name = $name;
        $this->search_count = $search_count;
        $this->login_count = $login_count;
        $this->guest_count = $guest_count;
        $this->is_active = $is_active;
        return $this->save();
    }
    
    public static function foundSearch($name) {
        $search  = static::where('name', $name)->first();
        if (isset($search)) {
            return $search->id;
        }  else {
            return 0;
        }
    }
    
    public static function updateSearch($id, $name,$is_active) {
        $post = static::findOrFail($id);
        $post->name = $name;
        $post->is_active = $is_active;
        return $post->save();
    }
    
    public static function updateSearchActive($id, $is_active) {
        $post = static::findOrFail($id);
        $post->is_active = $is_active;
        return $post->save();
    }
    
    public static function updateSearchTime($id) {
        return static::where('id', $id)->update(['updated_at'=>new Carbon()]);
    }
    
    public static function updateSearchCount($id,$column = 'search_count') {
        return static::where('id', $id)->increment($column);
    }
    
    public static function updateSearchCountLogin($id,$search_count,$login_count) {
        return static::where('id', $id)->update(['search_count' => $search_count,'login_count' => $login_count]);
    }
    
    public static function updateSearchCountGuest($id,$search_count,$guest_count) {
        return static::where('id', $id)->update(['search_count' => $search_count,'guest_count' => $guest_count]);
    }

}
