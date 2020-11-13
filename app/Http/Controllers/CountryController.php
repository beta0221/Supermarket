<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;

class CountryController extends Controller
{
    use CrudTrait;

    public function __construct(){
        $this->model = Country::class;
        $rules = [
            'name'=>['required','max:255','string'],
            'code'=>['required','max:255','string','unique:countries'],
        ];
        $this->storeRule = $rules;
        $this->updateRule = $rules;
        $this->updateColumns = ['name','code'];
    }
    
}
