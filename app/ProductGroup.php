<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;





    /**關聯 */
    public function products(){
        return $this->hasMany('App\Product','group_id');
    }

    public function cartRules(){
        return $this->belongsToMany('App\CartRule','cart_rule_product_groups','product_group_id','cart_rule_id');
    }

}
