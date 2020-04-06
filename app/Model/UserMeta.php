<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model {

    protected $table = 'user_meta';
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'meta_type', 'meta_value'
    ];

    public function user() {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function insertMeta($user_id, $meta_type = 'data', $meta_value = NULL) {

        $this->user_id = $user_id;
        $this->meta_type = $meta_type;
        $this->meta_value = $meta_value;
        return $this->save();
    }

    public function updateMeta($user_id, $meta_value = NULL, $meta_type = 'data') {
        $user_meta = static::where('user_id', $user_id)->where('meta_type', $meta_type)->first();
        if (isset($user_meta)) {
            $user_meta->meta_value = $meta_value;
            return $user_meta->save();
        } else {
            return $this->insertMeta($user_id, $meta_type, $meta_value);
        }
    }

    public function updateMetaType($user_id, $meta_type = 'data', $meta_value = NULL) {
        $user_meta = static::where('user_id', $user_id)->where('meta_type', $meta_type)->first();
        if (isset($user_meta)) {
            $user_meta->meta_value = $meta_value;
            return $user_meta->save();
        } else {
            return $this->insertMeta($user_id, $meta_type, $meta_value);
        }
    }

    public function deleteMeta($user_id) {
        return static::where('user_id', $user_id)->delete();
    }

    public static function deleteMetaType($user_id, $meta_type) {
        return static::where('user_id', $user_id)->where('meta_type', $meta_type)->delete();
    }

    public static function DataType($meta_type = 'data', $colum_name = '') {
        $data = static::where('meta_type', $meta_type)->get();
        return $data;
    }

    public static function DataUser($user_id, $meta_type = 'data', $colum_name = '') {
        $data = static::where('user_id', $user_id)->where('meta_type', $meta_type)->first();
        if (!empty($colum_name)) {
            if (isset($data->id)) {
                return json_decode($data->$colum_name);
            } else {
                return [];
            }
        } else {
            return $data;
        }
    }

//***********************************************************************************************************
    public static function AddMetaValueInstructor($user_id, $input) {
        foreach ($input as $key => $value) {
            if ($key != 'lang_programs') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        if (!isset($input['lang_programs']) || empty($input['lang_programs'])) {
            $lang_programs = $input['lang_programs'] = [];
        }
        foreach ($input['lang_programs'] as $key => $value_program) {
            $lang_programs[] = stripslashes(trim(filter_var($value_program, FILTER_SANITIZE_STRING)));
        }
        $array_meta = array('linkedin' => $input['linkedin'], 'github' => $input['github'],
            'speak_en' => $input['speak_en'], 'project' => $input['project'], 'address' => $input['address'],
            'lang_programs' => $lang_programs);
        $meta_value = json_encode($array_meta);
        $meta = new UserMeta();
        $update_meta = $meta->updateMeta($user_id, $meta_value, 'instructor');
        return $update_meta;
    }

    public static function DataUserMetaValue($user_id, $meta_type = 'data', $colum_name = '') {
        $facebook = $twitter = $instagram = $youtube = '';
        $birth_day = '0000-00-00';
        $data_meta_value = UserMeta::DataUser($user_id, $meta_type, $colum_name);
        foreach ($data_meta_value as $key_meta => $val_meta) {
            if ($key_meta == 'social') {
                foreach ($val_meta as $key_social => $val_social) {
                    $$key_social = $val_social;
                }
            } else {
                $$key_meta = $val_meta;
            }
        }
        if (!isset($stateSend) || empty($stateSend)) {
            $stateSend = [];
        }
        return array(
            'stateSend' => $stateSend, 'birth_day' => $birth_day, 'youtube' => $youtube,
            'facebook' => $facebook, 'twitter' => $twitter, 'instagram' => $instagram
        );
    }

    public static function DataMetaValueDecode($value_meta, $langsprograms,$colum_value='') {
        $data_meta = json_decode($value_meta);
        foreach ($data_meta as $key_data => $val_data) {
            if ($key_data == $colum_value) {
                foreach ($val_data as $key_prog => $val_prog) {
                    $langsprograms[$val_prog] = $val_prog;
                }
            }
        }
        return $langsprograms;
    }

    public static function DataMetaValueColum($meta_type = 'instructor', $colum_name = '', $colum_value = '') {
        $langsprograms = [];
        $data_meta_value = UserMeta::DataType($meta_type);
        foreach ($data_meta_value as $key => $value_meta) {
            $langsprograms = UserMeta::DataMetaValueDecode($value_meta->$colum_name, $langsprograms,$colum_value);
        }
        return $langsprograms;
    }

    public static function DataUserMetaValueInstructor($user_id, $meta_type = 'instructor', $colum_name = '') {
        $linkedin = $github = $project = $address = $speak_en = '';
        $my_lang_programs = [];
        $data_meta_value = UserMeta::DataUser($user_id, $meta_type, $colum_name);
        foreach ($data_meta_value as $key_meta => $val_meta) {
            if ($key_meta == 'lang_programs') {
                foreach ($val_meta as $key_prog => $val_prog) {
                    $my_lang_programs[$val_prog] = $val_prog;
                }
            } else {
                $$key_meta = $val_meta;
            }
        }
        $langsprograms = UserMeta::DataMetaValueColum($meta_type, $colum_name, 'lang_programs');
        return array(
            'lang_programs' => $my_lang_programs, 'langsprograms' => $langsprograms, 'linkedin' => $linkedin, 'github' => $github,
            'project' => $project, 'address' => $address, 'speak_en' => $speak_en
        );
    }

}
