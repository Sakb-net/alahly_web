<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

//use Carbon\Carbon;
class Page extends Model {

    protected $table = 'pages';
    protected $fillable = [
        'name', 'type', 'title', 'description', 'lang_id', 'lang', 'view_count', 'image'
    ];

    public function langID() {
        return $this->belongsTo(\App\Model\Post::class, 'lang_id');
    }

    public static function updatePage($type, $name, $lang = 'ar', $title = NULL, $description = NULL, $image = NULL) {
        $page = static::where('type', $type)->where('lang', $lang)->first();
        $input['name'] = $name;
        $input['title'] = $title;
        $input['description'] = $description;
//        $input['lang_id'] = $lang_id;
        $input['lang'] = $lang;
        $input['image'] = $image;
        if (isset($page->id)) {
            $page->update($input);
            return $page->id;
        } else {
            $page_new = Page::create($input);
            return $page_new['id'];
        }
    }

    public static function updateColum($id, $colum, $value) {
        $name = static::findOrFail($id);
        $name->$colum = $value;
        return $name->save();
    }

    public static function updateColumWhere($col, $val, $colum, $value, $lang = 'ar') {
        $lang = $name = static::where($col, $val)->where('lang', $lang)->first();
        if ($colum == 'view_count') {
            $value = $name->view_count + 1;
        }
        $name->$colum = $value;
        return $name->save();
    }

    public static function foundPageValue($colum, $value) {
        $link_found = static::where($colum, $value)->first();
        if (isset($link_found)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function DataLangAR($lang_id, $state_lang = 1, $limit = 0) {
        $data = static::where('lang_id', $lang_id);
        if ($state_lang == 1) {
            $result = $data->where('lang', '<>', 'ar');
        }
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } elseif ($limit == -1) {
            $result = $data->pluck('lang', 'id')->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_typeColum($type, $lang = 'ar', $colum = '') {
        $name = static::where('type', $type)->where('lang', $lang)->first();
        if (!empty($colum)) {
            return $name->$colum;
        } else {
            return $name;
        }
    }

    public static function get_nameColum($name, $colum = '') {
        $name = static::where('name', $name)->first();
        if (!empty($colum)) {
            return $name->$colum;
        } else {
            return $name;
        }
    }

    public static function get_nameID($id, $colum) {
        $name = static::where('id', $id)->first();
        return $name->$colum;
    }

    public static function get_PageLangId($lang_id, $lang) {
        $data = static::where('lang_id', $lang_id)->where('lang', $lang)->first();
        return $data;
    }

    public static function get_AllPageLangId($lang_id, $lang, $limit = 0) {
        $data = static::where('lang_id', $lang_id)->where('lang', '<>', $lang);
        if (!empty($limit > 0)) {
            $retult = $data->paginate($limit);
        } else {
            $retult = $data->get();
        }
        return $retult;
    }

    public static function get_Pages($lang = 'ar', $limit = 0) {
        $data = static::where('lang', $lang);
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } elseif ($limit == -1) {
            $result = $data->pluck('id', 'id')->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_PageType($type, $limit = 0) {
        $data = static::where('type', $type);
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } elseif ($limit == -1) {
            $result = $data->pluck('id', 'id')->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function get_PageLang($type, $lang) {
        $data = static::where('type', $type)->where('lang', $lang)->first();
        return $data;
    }

    public static function get_PageTypeLang($array_type, $lang, $limit = 0) {
        $data = static::wherenotIn('type', $array_type)->where('lang', $lang);
        if (!empty($limit > 0)) {
            $retult = $data->paginate($limit);
        } else {
            $retult = $data->get();
        }
        return $retult;
    }

}
