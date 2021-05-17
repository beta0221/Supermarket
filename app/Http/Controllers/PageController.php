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
    public function index(Request $request){
        
        $categoryWithoutSub = Category::all();
        $categoryWithoutSub = new CategoryCollection($categoryWithoutSub);

        $products = Product::where('active',1)
            ->take(10)
            ->orderBy('priority','desc')
            ->get();
        $productCollection = new ProductCollection($products);
        
        $onSaleProducts = Product::getOnSaleProducts();
        $onSaleProductCollection = new ProductCollection($onSaleProducts);

        //取得Banner
        $banners = Banner::whereNotNull('image_path')->orderBy('order','asc')->orderBy('id','desc')->get();

        //  get session
        // $lastSeen = [];
        // if(session('lastSeen')){
        //     $lastSeen = array_reverse(Session::get('lastSeen'));
        //     $lastSeen = new ProductCollection($lastSeen);
        //     $lastSeen = $lastSeen->withFirstImage()->withFirstSpecificPrice()->toArray();
        // }

        //取得最熱銷 top3
        // $topArray = OrderProduct::select('product_id',DB::raw('COUNT(product_id) as count'))
        //     ->groupBy('product_id')
        //     ->orderBy('count', 'desc')
        //     ->take(3)
        //     ->pluck('product_id');
        
        // $popularTop3 = [];
        // if($popular = Product::whereIn('id',$topArray)->get()){
        //     $popular = new ProductCollection($popular);
        //     $popularTop3 = $popular->withFirstImage()->withFirstSpecificPrice()->toArray();
        // }
    
        return view('pages.index',[
            //'popular' => $popularTop3,
            //'lastSeen'=>$lastSeen,
            'banners'=>$banners,
            'categories'=>Category::getNestedCategoryList(),
            'categoryWithoutSub'=> $categoryWithoutSub
                // ->withFirstImage()
                ->toArray(),
            'products'=>$productCollection->withFirstImage()->withFirstSpecificPrice()->withCategoryArray()->toArray(),
            'onSaleProducts'=>$onSaleProductCollection->withFirstImage()->withFirstSpecificPrice()->toArray(),
        ]);
    }
    
    /**購物頁面 */
    public function shop(Request $request,$slug = null){
        
        $products = new Product();
        $catName = null;
        if($slug){
            $category = Category::where('slug',$slug)->firstOrFail();
            $catName = $category->name;
            $products = $category->products();
        }

        if(!$request->has('rows')){$request->merge(['rows'=>9]);}
        $p = new Pagination($request);

        $total = $products->where('active',1)->count();
        $p->cacuTotalPage($total);

        $products = $products->where('active',1)
            ->skip($p->skip)
            ->take($p->rows)
            ->orderBy('priority','desc')
            ->get();

        $productCollection = new ProductCollection($products);
        
        $onSaleProducts = Product::getOnSaleProducts();
        $onSaleProductCollection = new ProductCollection($onSaleProducts);

        return view('pages.shop',[
            'catName'=>$catName,
            'categories'=>Category::getNestedCategoryList(),
            'products'=>$productCollection->withFirstImage()->withFirstSpecificPrice()->toArray(),
            'onSaleProducts'=>$onSaleProductCollection->withFirstImage()->withFirstSpecificPrice()->toArray(),
            'pagination'=>$p,
        ]);
    }

    /** 訂購相關頁面 */
    public function about(){
        return view('pages.about');
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
    public function view_pay($order_numero){
        $order = Order::where('order_numero',$order_numero)->firstOrFail();
        $ecpay = new ECPay($order);

        if(!$token = $ecpay->getToken()){
            return '錯誤頁面';
        }

        return view('pages.pay',[
            'order_numero' => $order_numero,
            'token' => $token,
            'ecpaySDKUrl'=> $ecpay->getEcpaySDKUrl(),
        ]);
    }

    /** 付款請求 */
    public function pay(Request $request,$order_numero){
        $order = Order::where('order_numero',$order_numero)->firstOrFail();
        if(!$request->has('PayToken')){ return '錯誤頁面'; }

        $ecpay = new ECPay($order);
        $resultUrl = $ecpay->createPayment($request->PayToken);

        if(!$resultUrl){ return '錯誤頁面'; }
        return redirect($resultUrl);

    }

    /** 聯絡我們 */
    public function contact(){
        return view('pages.contact');
    }

}
