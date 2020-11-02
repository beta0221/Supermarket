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
            'name'=>['required','max:255','string'],
            'slug'=>['required','unique:categories','max:255','string', new SlugRule],
        ];
        $this->updateRule = [
            'name'=>['required','max:255','string'],
        ];
        $this->updateColumns = ['name'];

    }

    /**取得所有 Category */
    public function all(){
        return response(Category::all());
    }
    /**取得關聯的 Products */
    public function getProducts($id){
        $category = Category::find($id);
        $products = $category->products()->get();
        return response($products);
    }




}
