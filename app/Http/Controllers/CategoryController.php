<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;
use App\Rules\SlugRule;

class CategoryController extends Controller
{
    use CrudTrait;

    public function __construct(){


        $this->model = Category::class;
        $this->storeRule = [
            'name'=>['required','max:255'],
            'slug'=>['required','unique:categories','max:255', new SlugRule],
        ];
        $this->updateRule = [
            'name'=>['required','max:255'],
        ];
        $this->updateColumns = ['name'];

    }






}
