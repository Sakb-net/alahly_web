<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model {

    protected $table = 'social_providers';
//    public $timestamps = false;

    protected $fillable = ['provider_id', 'provider','user_id','is_active'];

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

}
