<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;
use App\Helpers\StorageHelper;
use App\Helpers\StorageType;
use App\Rules\SlugRule;
use App\Traits\CrudTrait;

class BannerController extends Controller
{
    use CrudTrait;

    public function __construct(){
        $this->model = Banner::class;
        $this->storeRule = [
            'slug'=>['required','unique:banners','max:255','string', new SlugRule],
            'key_word' => ['required','max:255','string'],
            'order' => ['integer'],
        ];
        $this->updateRule = [
            'key_word' => ['required','max:255','string'],
            'order' => ['integer'],
        ];
        $this->updateColumns = ['key_word','order'];
    }

    /**刪除 */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $storageHelper = new StorageHelper();
        $storageHelper->delete($banner->image_path);
        $banner->delete();
        return response('success');
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

    //刪掉舊的
    $storageHelper = new StorageHelper();
    $storageHelper->delete($banner->image_path);

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

    $storageHelper = new StorageHelper();
    $storageHelper->delete($banner->image_path);

    $banner->update([
        'image_path'=>null
    ]);
    
    return response($banner);

}
}
