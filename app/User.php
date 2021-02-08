<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','birthday','gender','bonus'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    Public function setPasswordAttribute($password) 
    { 
        return $this->attributes['password'] = bcrypt($password); 
    }
    /**關聯 Role */
    public function roles(){
        return $this->belongsToMany('App\Role','role_users','user_id','role_id');
    }
    /**關聯 Permission */
    public function permissions(){
        return $this->belongsToMany('App\Permission','permission_users','user_id','permission_id');
    }
    public function isAdmin()
    {
        $roles = $this->roles()->get();
        foreach ($roles as $role) {   
            if ($role->name=='Admin' or 'Employee') {
                return true;
            }    
        }
        return false;
    }
    public function updateBonus($amount,$decrease = true){
        if($decrease){
            $this->bonus -= $amount;
        }else{
            $this->bonus += $amount;
        }
        $this->save();
    }
}
