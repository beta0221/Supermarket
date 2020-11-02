<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;


    /**關聯 Permission */
    public function permissions(){
        return $this->belongsToMany('App\Permission','permission_roles','role_id','permission_id');
    }

}
