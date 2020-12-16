<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;

    public function roles(){
        return $this->belongsToMany('App\Role','permission_roles','permission_id','role_id');
    }

    public function users(){
        return $this->belongsToMany('App\User','permission_users','permission_id','user_id');
    }
}
