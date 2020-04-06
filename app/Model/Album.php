<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Album extends Model {

    protected $table = 'albums';
//    public $timestamps = false;
    protected $fillable = [
        'user_id', 'parent_id', 'name', 'type', 'image', 'content', 'link', 'is_active','view_count'
    ];

    public function albumable() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function insertAlbum($user_id, $name, $type, $image, $content, $link, $is_active = 1) {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->type = $type;
        $this->image = $image;
        $this->content = $content;
        $this->link = $link;
        $this->is_active = $is_active;
        return $this->save();
    }

    public function updateAlbum($name, $type, $image, $content, $link, $is_active = 1) {
        $post_album = static::where('name', $name)->where('type', $type)->where('image', $image)->first();
        if (isset($post_album)) {
            $post_album->content = $content;
            $post_album->link = $link;
            $post_album->is_active = $is_active;
            return $post_album->save();
        } else {
            return $this->insertAlbum($name, $type, $image, $content, $link, $is_active);
        }
    }

    public static function deleteAlbum($name, $type, $image) {
        return static::where('name', $name)->where('type', $type)->where('image', $image)->delete();
    }

    public static function deleteParent($id) {
        return static::where('parent_id', $id)->delete();
    }

    public static function foundLink($link, $type = "main") {
        $link_found = static::where('link', $link)->where('type', $type)->first();
        if (isset($link_found)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function get_ALLAlbumData($id, $colum = 'id', $valueColume = 'DESC', $limit = 0, $offset = -1) {
        $data = static::where('parent_id', $id)->where('is_active', 1)->with('user')->orderBy($colum, $valueColume);
        if ($limit > 0 && $offset > -1) {
            $result = $data->limit($limit)->offset($offset)->get();
        } elseif ($limit > 0 && $offset == -1) {
            $result = $data->paginate($limit);
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function updateAlbumViewCount($id) {
        return static::where('id', $id)->increment('view_count');
    }
    public static function get_albumColum($colum, $val_col, $is_active = -1) {
        $data = static::where($colum, $val_col);
        if ($is_active != -1) {
            $result = $data->where('is_active', $is_active);
        }
        $result = $data->first();
        return $result;
    }
    public static function dataAlbum($get_data = [],$api=0) {
        $lang = 'ar';
        $all_data = [];
        foreach ($get_data as $key_ne => $valnews) {
            $data['name'] = $valnews->name;
            $data['link'] = $valnews->link;
            $data['image'] = $valnews->image;
//           $allData = explode('-', $valnews->created_at->format('Y-m-d'));                         
            $data['date'] = $valnews->created_at->format('Y-m-d');//arabic_date_number($valnews->created_at->format('Y-m-d'), '-');
            $data['created_at'] = Time_Elapsed_String('@' . strtotime($valnews->created_at), $valnews->lang);
            $all_data[] = $data;
        }
        return $all_data;
    }

}
