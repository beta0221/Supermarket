<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
use App\Country;
use App\Product;
use App\Carrier;
use App\Order;
use App\Helpers\CartHandler;
use App\Helpers\Pagination;
use App\Helpers\TaiwanDistrict;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Payment;
use App\Banner;
use App\Helpers\ECPay;
use App\OrderProduct;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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
        $banners = Banner::orderBy('id','desc')->get();
        $static_host = config('app.static_host') . '/';
        $imagesUrl = [];
        foreach($banners as $banner){
            if($banner->image_path){ $imagesUrl[] = ['url'=>$static_host . $banner->image_path]; }    
        };

        //  get session
        $lastSeen = [];
        if(session('lastSeen')){
            $lastSeen = array_reverse(Session::get('lastSeen'));
            $lastSeen = new ProductCollection($lastSeen);
            $lastSeen = $lastSeen->withFirstImage()->withFirstSpecificPrice()->toArray();
        }else{
            
        }

        //取得最熱銷 top3
        $topArray = OrderProduct::select('product_id',DB::raw('COUNT(product_id) as count'))
            ->groupBy('product_id')
            ->orderBy('count', 'desc')
            ->take(3)
            ->pluck('product_id');
        
        $popularTop3 = [];
        if($popular = Product::whereIn('id',$topArray)->get()){
            $popular = new ProductCollection($popular);
            $popularTop3 = $popular->withFirstImage()->withFirstSpecificPrice()->toArray();
        }
    
        return view('pages.index',[
            'popular' => $popularTop3,
            'lastSeen'=>$lastSeen,
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

        $user = auth()->user();
        if($user){
            //抓取過去訂單的Address紀錄
        }

        return view('pages.checkout',[
            'user' =>  $user,
            'cartHandler' => new CartHandler(),
            'countries'=>Country::all(),
            'counties'=>TaiwanDistrict::COUNTY,
            'cities'=>TaiwanDistrict::CITY,
            'carriers'=>Carrier::all(),
            'payments'=>Payment::all_sortByCarrier(),
        ]);
    }

    /**付款頁面 */
    public function pay($order_numero){
        $order = Order::where('order_numero',$order_numero)->firstOrFail();
        $ecpay = new ECPay($order);

        // $body = $ecpay->getRequestBody();
        // echo $body;

        $token = $ecpay->getToken();
        return view('pages.pay',[
            'token'=>$token
        ]);
    }

}
