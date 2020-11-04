<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**首頁 */
    public function index(){
        return view('pages.index');
    }

    /**購物頁面 */
    public function shop(){
        return view('pages.shop');
    }
}
