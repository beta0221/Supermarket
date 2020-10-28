<?php

namespace App\Http\Controllers;

use App\Attribute;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;

class AttributeController extends Controller
{
    use CrudTrait;

    public function __construct(){
        
        $this->model = Attribute::class;
        $rule = [
            'type'=>['required','max:255','string'],
            'name'=>['required','max:255','string'],
        ];
        $this->storeRule = $rule;
        $this->updateRule = $rule;
        $this->updateColumns = ['type','name'];
    }
}
