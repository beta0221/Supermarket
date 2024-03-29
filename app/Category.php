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


    public $subCategoryList;

    /**關聯 Product */
    public function products(){
        return $this->belongsToMany('App\Product','category_products','category_id','product_id');
    }
    /**關聯 cart_rules */
    public function cartRules(){
        return $this->belongsToMany('App\CartRule','cart_rule_categories','category_id','cart_rule_id');
    }
    public function images(){
        return $this->hasMany('App\CategoryImage');
    }

    /**取得巢狀階層的 Category List */
    public static function getNestedCategoryList(){
        $categoryList = Category::orderBy('parent_id','asc')->get();
        $indexDict=[];
        $list = [];
        foreach ($categoryList as $category) {
            if(is_null($category->parent_id)){
                $indexDict[$category->id] = count($list);
                $list[] = $category;
                continue;
            }
            $parentIndex = $indexDict[$category->parent_id];
            if(!isset($list[$parentIndex]->subCategoryList)){
                $list[$parentIndex]->subCategoryList = [];
            }
            $list[$parentIndex]->subCategoryList = array_merge($list[$parentIndex]->subCategoryList,[$category]);
        }
        return $list;
    }    

    public function getDefaultImageUrl(){
        return config('app.static_host') . '/default_product_image.png';
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
