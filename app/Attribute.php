<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'type','name'
    ];

    public $timestamps = false;


    public function attributeSets(){
        return $this->belongsToMany('App\AttributeSet','attribute_attribute_sets','attribute_id','attribute_set_id');
    }



}
