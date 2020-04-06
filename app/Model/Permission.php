<?php

namespace App\Model;

use Zizaco\Entrust\EntrustPermission;
//use Carbon\Carbon;
//use DB;

class Permission extends EntrustPermission {
     protected $fillable = ['parent_id','name','display_name','description'];
     
     
    public function childrens() {
        return $this->hasMany(\App\Model\Permission::class, 'parent_id');
    }
     
}
