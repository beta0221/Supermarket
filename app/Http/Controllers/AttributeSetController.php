<?php

namespace App\Http\Controllers;

use App\AttributeSet;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;

class AttributeSetController extends Controller
{
    use CrudTrait;

    public function __construct(){
        
        $this->model = AttributeSet::class;
        $rule = ['name'=>['required','max:255','string'],];
        $this->storeRule = $rule;
        $this->updateRule = $rule;
        $this->updateColumns = ['name'];
    }
}
