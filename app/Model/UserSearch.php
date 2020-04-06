<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserSearch extends Model {

    protected $table = 'user_search';
    protected $fillable = [
        'search_id', 'user_id', 'visitor', 'country_name', 'region_name', 'city', 'latitude', 'longitude', 'result_count'
    ];

    public function search() {
        return $this->belongsTo(\App\Model\Search::class);
    }

    public function insertSearch($search_id, $user_id, $visitor, $country_name = NULL, $region_name = NULL, $city = NULL, $latitude = NULL, $longitude = NULL, $result_count = 1) {
        if (empty($user_id) || $user_id == 0) {
            $user_id = NULL;
        }
        $this->search_id = $search_id;
        $this->user_id = $user_id;
        $this->visitor = $visitor;
        $this->country_name = $country_name;
        $this->region_name = $region_name;
        $this->city = $city;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->result_count = $result_count;
        return $this->save();
    }

    public static function updateSearch($visitor, $user_id) {
        if (empty($user_id) || $user_id == 0) {
            $user_id = NULL;
        }
        return static::where('visitor', $visitor)->where('user_id', NULL)->update(['user_id' => $user_id]);
    }

    public static function updateSearchCount($id, $column = 'result_count') {
        return static::where('id', $id)->increment($column);
    }

    public static function foundSearch($search_id, $user_id) {
        if (empty($user_id) || $user_id == 0) {
            $user_id = NULL;
        }
        $search = static::where('user_id', $user_id)->where('search_id', $search_id)->first();
        if (isset($search)) {
            return $search->id;
        } else {
            return 0;
        }
    }

}
