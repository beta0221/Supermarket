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


    
    /**購物頁面 */
    public function shop(Request $request,$slug = null){
        
        $products = new Product();
        if($slug){
            $category = Category::where('slug',$slug)->firstOrFail();
            $products = $category->products();
        }
        

        if(!$request->has('rows')){$request->merge(['rows'=>9]);}
        $p = new Pagination($request);

        $total = $products->where('active',1)->count();
        $p->cacuTotalPage($total);


        $products = $products->where('active',1)
            ->skip($p->skip)
            ->take($p->rows)
            ->orderBy($p->orderBy,$p->order)
            ->get();
        

        foreach ($products as $product) {
            $product->setFirstImageUrl();
        }

        return view('pages.shop',[
            'categories'=>Category::getNestedCategoryList(),
            'products'=>$products,
            'pagination'=>$p,
        ]);
    }
}
