<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_ADMIN = "Admin";
    const ROLE_EMPLOYEE = "Employee";
    const ROLE_VIP = "Vip";

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

    /**
     * 有沒有這些角色
     * @param array $roles
     * @return bool
     */
    public function hasRoles(array $roles)
    {
        $userRoles = $this->roles()->get();
        foreach ($userRoles as $userRole) {   
            if(in_array($userRole->name,$roles)){
                return true;
            }
        }
        return false;
    }

    /**override 傳送重設密碼連結 */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * 更新使用者的紅利點數 
     * @param int $amount
     * @param bool $decrease true減少 false增加
     * */
    public function updateBonus($amount,$decrease = true){
        if($decrease){
            $this->bonus -= $amount;
        }else{
            $this->bonus += $amount;
        }
        $this->save();
    }
}
