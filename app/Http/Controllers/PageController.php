<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
use App\Country;
use App\Product;
use App\Carrier;
use App\Helpers\Pagination;
use App\Helpers\TaiwanDistrict;
use App\Http\Resources\ProductCollection;
use App\Payment;

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

    /**結帳頁面 */
    public function checkout(){

        return view('pages.checkout',[
            'countries'=>Country::all(),
            'counties'=>TaiwanDistrict::COUNTY,
            'cities'=>TaiwanDistrict::CITY,
            'carriers'=>Carrier::all(),
            'payments'=>Payment::all(),
        ]);
    }

}
