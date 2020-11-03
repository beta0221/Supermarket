<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id','name', 'slug'
    ];

    public static $key = 'slug';
    
    public $timestamps = false;


    /**關聯 Product */
    public function products(){
        return $this->belongsToMany('App\Product','category_products','category_id','product_id');
    }

    

}
