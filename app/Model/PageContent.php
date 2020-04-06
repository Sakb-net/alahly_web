<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model {

    protected $table = 'page_content';
    public $timestamps = false;
    protected $fillable = [
        'page_id', 'content_type', 'content_key', 'content_value', 'content_etc', 'content_other'
    ];

    public function page() {
        return $this->belongsTo(\App\Model\Page::class);
    }

    public static function deletePageType($page_id, $content_type) {
        return static::where('page_id', $page_id)->where('content_type', $content_type)->delete();
    }

//************************************************

    public static function insertContent($content_type, $content_key, $content_value, $content_etc = NULL, $content_other = NULL) {
        $input['content_type'] = $content_type;
        $input['content_key'] = $content_key;
        $input['content_value'] = $content_value;
        $input['content_etc'] = $content_etc;
        $input['content_other'] = $content_other;
        $input['autoload'] = $autoload;
        return PageContent::create($input);
    }

    public static function updateContent($page_id, $content_type, $content_key, $content_value, $content_etc = NULL, $content_other = NULL) {
        $content = static::where('page_id', $page_id)->where('content_type', $content_type)->first();
        $input['page_id'] = $page_id;
        $input['content_type'] = $content_type;
        $input['content_key'] = $content_key;
        $input['content_value'] = $content_value;
        $input['content_etc'] = $content_etc;
        $input['content_other'] = $content_other;
        if (isset($content->content_value)) {
            return $content->update($input);
        } else {
            return PageContent::create($input);
        }
    }

    public static function updateContentKey($page_id, $content_type, $content_key, $content_value, $content_etc = NULL, $content_other = NULL) {
        $content = static::where('page_id', $page_id)->where('content_key', $content_key)->first();
        $input['page_id'] = $page_id;
        $input['content_type'] = $content_type;
        $input['content_key'] = $content_key;
        $input['content_value'] = $content_value;
        $input['content_etc'] = $content_etc;
        $input['content_other'] = $content_other;
        if (isset($content->content_value)) {
            return $content->update($input);
        } else {
            return PageContent::create($input);
        }
    }

    public static function updateContentID($id, $page_id, $content_type, $content_key, $content_value, $content_etc = NULL, $content_other = NULL) {
        $content = static::where('id', $id)->first();
        $input['page_id'] = $page_id;
        $input['content_type'] = $content_type;
        $input['content_key'] = $content_key;
        $input['content_value'] = $content_value;
        $input['content_etc'] = $content_etc;
        $input['content_other'] = $content_other;

        if (isset($content->id)) {
            return $content->update($input);
        } else {
            return PageContent::create($input);
        }
    }

    public static function get_Content($page_id, $content_type, $all = 0) {
        $content = static::where('page_id', $page_id)->where('content_type', $content_type);
        if ($all == 0) {
            $data = $content->first();
        } else {
            $data = $content->get();
        }
        return $data;
    }

    public static function get_ContentLink($col_name, $col_value, $content_type) {
        $content = static::where($col_name, $col_value)->where('content_type', $content_type)->first();
        return $content;
    }

    public static function get_ALLContent($page_id) {
        $content = static::where('page_id', $page_id)->get();
        return $content;
    }

    public static function get_ALLContentPage($page_id, $colum, $value_colum, $limit = 0) {
        $data = static::where('page_id', $page_id)->where($colum, $value_colum);
        if ($limit > 0) {
            $content = $data->orderBy('id', 'DESC')->limit($limit)->get();
        } else {
            $content = $data->get();
        }
        return $content;
    }

    public static function get_ALLContentType($content_type, $colum, $value_colum) {
        $content = static::where('content_type', $content_type)->where($colum, $value_colum)->get();
        return $content;
    }

}
