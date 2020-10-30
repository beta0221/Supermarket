<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeSet extends Model
{
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;


    /**
     * 關聯
     */

    public function attributes(){
        return $this->belongsToMany('App\Attribute','attribute_attribute_sets','attribute_set_id','attribute_id');
    }

    public function products(){
        return $this->hasMany('App\Product','attribute_set_id');
    }



}
