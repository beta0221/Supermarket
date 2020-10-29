<?php

namespace App\Http\Controllers;

use App\ProductGroup;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;

class ProductGroupController extends Controller
{
    use CrudTrait;

    public function __construct(){
        
        $this->model = ProductGroup::class;
        $rule = ['name'=>['required','max:255','string'],];
        $this->storeRule = $rule;
        $this->updateRule = $rule;
        $this->updateColumns = ['name'];
    }
}
