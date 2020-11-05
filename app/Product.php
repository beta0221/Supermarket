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
    public $firstImageUrl;

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
    /**關聯 SpecificPrice */
    public function specificPrices(){
        return $this->hasMany('App\SpecificPrice');
    }
    /**關聯 Attribute */
    public function attributes(){
        return $this->belongsToMany('App\Attribute','attribute_products','product_id','attribute_id');
    }
    /**關聯 Category */
    public function categories(){
        return $this->belongsToMany('App\Category','category_products','product_id','category_id');
    }

    /**
     * 取得第一個有效的特價 SpecificPrice 
     * @return SpecificPrice
     * */
    public function getFirstSpecificPrice(){
        $date = date('Y-m-d');
        return $this->specificPrices()
        ->whereDate('start_date', '<=',$date)
        ->whereDate('expiration_date', '>',$date)
        ->orderBy('id','desc')
        ->first();
    }

    public function setFirstImageUrl(){
        $static_host = config('app.static_host') . '/';

        if(!$image = $this->images()->first()){
            $this->firstImageUrl = $static_host . 'default_product_image.png';    
            return;
        }

        $imageUrl =  $static_host . $image->name;    
        $this->firstImageUrl = $imageUrl;
        
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
