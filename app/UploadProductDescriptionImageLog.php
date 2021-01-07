<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadProductDescriptionImageLog extends Model
{
    protected $guarded = [];

    public static function log($sku,$imageUrl,$imagePath){
        static::create([
            'sku'=>$sku,
            'imageUrl'=>$imageUrl,
            'imagePath'=>$imagePath,
        ]);
    }
}
