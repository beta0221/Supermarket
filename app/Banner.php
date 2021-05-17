<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'key_word','image_path','slug','order'
    ];

    public $timestamps = false;

    public static $key = 'slug';

    public function getStaticUrl(){
        return config('app.static_host') . '/' . $this->name;
    }

    public function getDefaultImageUrl(){
        return config('app.static_host') . '/default_product_image.png';
    }

    public function imagesUrl(){
        $images = $this->get();
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
