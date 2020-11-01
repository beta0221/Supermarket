<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'group_id',
        'attribute_set_id',
        'sku',
        'name',
        'description',
        'tax_id',
        'price',
        'stock',
        'active',
    ];

    public static $key = 'sku';

    /**關聯 ProductGroup */
    public function group(){
        return $this->belongsTo('App\ProductGroup');
    }
    /**關聯 AttributeSet */
    public function attributeSet(){
        return $this->belongsTo('App\AttributeSet');
    }
    /**關聯 ProdcutImage */
    public function images(){
        return $this->hasMany('App\ProductImage');
    }
    /**關聯 Attribute */
    public function attributes(){
        return $this->belongsToMany('App\Attribute','attribute_products','product_id','attribute_id');
    }
    /**關聯 Category */
    public function categories(){
        return $this->belongsToMany('App\Category','category_products','product_id','category_id');
    }

    public function imagesUrl(){
        $images = $this->images()->get();
        $static_host = config('app.static_host') . '/';
        $imagesUrl = [];
        foreach ($images as $image) {
            $imagesUrl[] = [
                'id'=>$image->id,
                'url'=>$static_host . $image->name,
            ];
        }
        return $imagesUrl;
    }

}
