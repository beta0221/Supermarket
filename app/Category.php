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

}
