<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
use App\Country;
use App\Product;
use App\Carrier;
use App\Helpers\CartHandler;
use App\Helpers\Pagination;
use App\Helpers\TaiwanDistrict;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Payment;
use App\Banner;

class PageController extends Controller
{
    /**首頁 */
    public function index(Request $request,$slug = null){
        
        $products = new Product();
        if($slug){
            $category = Category::where('slug',$slug)->firstOrFail();
            $products = $category->products();
        }
        $categoryWithoutSub = Category::all();
        $categoryWithoutSub = new CategoryCollection($categoryWithoutSub);
        if(!$request->has('rows')){$request->merge(['rows'=>10]);}
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

        //取得Banner
        $banners = Banner::all();
        $static_host = config('app.static_host') . '/';
        foreach($banners as $banner){
            $imagesUrl = ['url'=>$static_host . $banner->image_path];
        };

        return view('pages.index',[
            'banner'=>$imagesUrl,
            'categories'=>Category::getNestedCategoryList(),
            'categoryWithoutSub'=> $categoryWithoutSub->withFirstImage()->toArray(),
            'products'=>$productCollection->withFirstImage()->withFirstSpecificPrice()->withCategoryArray()->toArray(),
            'onSaleProducts'=>$onSaleProductCollection->withFirstImage()->withFirstSpecificPrice()->toArray(),
            'pagination'=>$p,
        ]);
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
            'products'=>$productCollection->withFirstImage()->withFirstSpecificPrice()->toArray(),
            'onSaleProducts'=>$onSaleProductCollection->withFirstImage()->withFirstSpecificPrice()->toArray(),
            'pagination'=>$p,
        ]);
    }

    /**購物車頁面 */
    public function cart(){
        return view('pages.cart',[
            'cartHandler' => new CartHandler(),
        ]);
    }

    /**結帳頁面 */
    public function checkout(){

        return view('pages.checkout',[
            'cartHandler' => new CartHandler(),
            'countries'=>Country::all(),
            'counties'=>TaiwanDistrict::COUNTY,
            'cities'=>TaiwanDistrict::CITY,
            'carriers'=>Carrier::all(),
            'payments'=>Payment::all_sortByCarrier(),
        ]);
    }

}
