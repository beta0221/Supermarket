<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductImage;
use App\Helpers\Pagination;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    /**首頁 */
    public function index(){

        return view('pages.index');
    }

<<<<<<< HEAD
    
    /**購物頁面 */
    public function shop($slug = null){
        $categories = Category::getNestedCategoryList();
        $products = Product::all();
=======
    /**購物頁面 */
    public function shop(){
        $categories = Category::all(); 
        $products = Product::all()->where('active',1)->orderBy('id','desc')->get();
        $query = DB::table('products')
        ->select('*');
        $total = $query->count();
        
>>>>>>> 選擇上架產品
        foreach ($products as $product) {
            $product->setFirstImageUrl();
        }

        return view('pages.shop',[
            'categories'=>$categories,
            'products'=>$products,
<<<<<<< HEAD
=======
            'total'=>$total,
            // 'productImageDict'=>$productImageDict,
>>>>>>> 選擇上架產品
        ]);
    }
}
