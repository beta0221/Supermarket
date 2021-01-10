<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Helpers\Pagination;
use Illuminate\Http\Request;
use App\Helpers\StorageHelper;
use App\Helpers\StorageType;

class BannerController extends Controller
{

    public function index(Request $request){
        $p = new Pagination($request);
        $query = new Banner();

        $p->cacuTotalPage($query->count());

        $banner = $query->skip($p->skip)
            ->take($p->rows)
            ->orderBy($p->orderBy,$p->order)
            ->get();

        return response([
            'data'=>$banner,
            'pagination'=>$p,
        ]);
    }

    public function store(Request $request){
        $model = Banner::create($request->all());
        return response($model);
    }
    public function show($slug){
        $banner = Banner::where('slug',$slug)->firstOrFail();
         $banner = [
             'id'=>$banner->id,
             'key_word'=>$banner->key_word,
             'slug'=>$banner->slug,
             'order'=>$banner->order,];
        return $banner;
    }
   /**取得商品圖片 */
   public function getImages($slug){
    $banner = Banner::where('slug',$slug)->firstOrFail();
    $static_host = config('app.static_host') . '/';
    if(!$banner->image_path){
        return;
    }
    $imagesUrl[] = ['id'=>$banner->id,
                  'url'=>$static_host . $banner->image_path];
    return response($imagesUrl);
}
public function addImage(Request $request,$slug){
    
    if (!$request->has('file')) { return response('Error',400); }
    $banner = Banner::where('slug',$slug)->firstOrFail();

    if(!$path = StorageHelper::path(StorageType::TYPE_BANNER,$banner->slug)->store($request->file('file'))){
        return response('Error',500);
    }
            
    $banner->update(['image_path'=>$path]);

    $imageUrl = config('app.static_host') . '/' . $path;
    return response($imageUrl);
}

public function deleteImage(Request $request,$slug){
    
    if (!$request->has('id')) { return response('Error',400); }
    $banner = Banner::where('slug',$slug)->firstOrFail();
    
    $image = $banner->find($request->id);

    $storageHelper = new StorageHelper();
    $storageHelper->delete($image->image_path);

    $image->forceDelete();
    
    return response($image);

}
}
