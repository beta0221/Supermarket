<?php

namespace App\Http\Controllers;

use App\Category;
use App\Helpers\Pagination;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;
use App\Rules\SlugRule;

class CategoryController extends Controller
{
    use CrudTrait;

    public function __construct(){


        $this->model = Category::class;
        $this->storeRule = [
            'name'=>['required','max:255','string'],
            'slug'=>['required','unique:categories','max:255','string', new SlugRule],
        ];
        $this->updateRule = [
            'name'=>['required','max:255','string'],
        ];
        $this->updateColumns = ['name'];

    }

    /**Override CrudTrait index() */
    public function index(Request $request){
        $p = new Pagination($request);
        $p->cacuTotalPage(Category::whereNull('parent_id')->count());
        
        $CategoryList = Category::whereNull('parent_id')
            ->skip($p->skip)
            ->take($p->rows)
            ->orderBy($p->orderBy,$p->order)
            ->get();
        
            return response([
            'data'=>$CategoryList,
            'pagination'=>$p,
        ]);
    }
    /**取得所有下階層的 Category */
    public function getSubCategory($slug){
        $category = Category::where('slug',$slug)->firstOrFail();
        $subCategoryList = Category::where('parent_id',$category->id)->get();
        return response($subCategoryList);
    }
    /**新增Category parent_id */
    public function addSubCategory(Request $request,$slug){
        $category = Category::where('slug',$slug)->firstOrFail();
        if(!is_null($category->parent_id)){ return response('此類別為子類別，不可再指派子類別。',500);}
        Category::where('id',$request->id)->update(['parent_id'=>$category->id]);
        return response('success');
    }
    /**移除Category parent_id */
    public function removeFromParentCategory($slug){
        $category = Category::where('slug',$slug)->firstOrFail();
        $category->parent_id = null;
        $category->save();
        return response('success');
    }
    /**取得所有 Category */
    public function all(){
        return response(Category::all());
    }
    //**取得所有父層級 也沒有子層級的 Category */
    public function allParents(){
        $parentIdArray = Category::whereNotNull('parent_id')->groupBy('parent_id')->pluck('parent_id');
        $allParents = Category::whereNull('parent_id')->whereNotIn('id',$parentIdArray)->get();
        return response($allParents);
    }
    /**產品列表 view */
    public function viewProductList($slug){
        $category = Category::where('slug',$slug)->firstOrFail();
        $products = $category->products()->get();
        return response($products);
    }

    /**取得關聯得 CartRule */
    public function getCartRules($slug){
        $category = Category::find($slug);
        $cartRules = $category->cartRules()->get();
        return response($cartRules);
    }
    /**更新關聯的 CartRule */
    public function syncCartRules(Request $request,$slug){
        $category = Category::find($slug);
        $category->cartRules()->sync($request->syncArray);
        $cartRules = $category->cartRules()->get();
        return response($cartRules);
    }



}
