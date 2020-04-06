<?php

namespace App\Model;

use Zizaco\Entrust\EntrustRole;
use DB;

class Role extends EntrustRole

{

    public function permissions()
   {
        return $this->belongsToMany(\App\Model\Permission::class);
   }
   
   public static function getRoleCount($role_id = 1) {
        return DB::table('users')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->where('role_user.role_id',$role_id)
        ->groupBy('role_user.role_id')
        ->count();
    }
   public static function CheckRole($role_name = 'admin',$type='member') {
        $allRole= Role::pluck('name', 'id')->toArray();
        $result=0;
        if (in_array($role_name, $allRole) && $role_name !=$type) {
            $result=1;
        }
        return $result;
    }
}