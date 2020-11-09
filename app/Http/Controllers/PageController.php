<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Helpers\Pagination;
use App\Http\Resources\ProductCollection;
use App\SpecificPrice;
use Gloudemans\Shoppingcart\Facades\Cart;

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

        $productCollection = new ProductCollection($products);
        
        $onSaleProducts = Product::getOnSaleProducts();
        $onSaleProductCollection = new ProductCollection($onSaleProducts);

        // return response($productCollection->withFirstImage());
        return view('pages.shop',[
            'categories'=>Category::getNestedCategoryList(),
            'products'=>$productCollection->withFirstImage()->toArray(),
            'onSaleProducts'=>$onSaleProductCollection->withFirstImage()->withFirstSpecificPrice()->toArray(),
            'pagination'=>$p,
        ]);
    }

    /**購物車頁面 */
    public function cart(){
        return view('pages.cart');
    }

}
