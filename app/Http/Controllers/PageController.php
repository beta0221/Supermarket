<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductImage;

class PageController extends Controller
{
    /**首頁 */
    public function index(){

        return view('pages.index');
    }

    /**購物頁面 */
    public function shop(){
        $categories = Category::all();
    
        $products = Product::all();

        
        foreach ($products as $product) {
            $product->setFirstImageUrl();
            //$productImageDict[$product->id] = $product->firstImageUrl();
        }
        

        return view('pages.shop',[
            'categories'=>$categories,
            'products'=>$products,
            // 'productImageDict'=>$productImageDict,
        ]);
    }
}
