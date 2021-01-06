<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryImage extends Model
{
    protected $fillable = [
        'name',
    ];

    public $timestamps = false;



    public function getStaticUrl(){
        return config('app.static_host') . '/' . $this->name;
    }
}
