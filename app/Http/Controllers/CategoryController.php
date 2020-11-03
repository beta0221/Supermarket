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
    /**產品列表 view */
    public function viewProductList($slug){
        $category = Category::where('slug',$slug)->firstOrFail();
        $products = $category->products()->get();
        return response($products);
    }




}
