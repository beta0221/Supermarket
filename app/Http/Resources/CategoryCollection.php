<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\CategoryImage;
use stdClass;

class CategoryCollection extends ResourceCollection
{
    private $idArray = [];
    private $initColumn = ['id','name','slug','parent_id',];
    private $firstImageDict = null;
    
    public function __construct($resource){
        parent::__construct($resource);
        foreach($this as $model){ $this->idArray[] = $model->id; }
    }

    public function withFirstImage(){
        $this->firstImageDict = [];
        $images = CategoryImage::whereIn('category_id',$this->idArray)->orderBy('id','desc')->get();
        foreach ($images as $image) {
            $this->firstImageDict[$image->category_id] = $image->getStaticUrl();    
        }
        return $this;
    }
    
    

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = null)
    {
        return $this->collection->map(function($model) use($request){
            $resource = new stdClass();
            foreach ($this->initColumn as $column) {
                $resource->{$column} = $model->{$column};
            }

            if(!is_null($this->firstImageDict)){
                $imageUrl = $model->getDefaultImageUrl();
                if(isset($this->firstImageDict[$model->id])){
                    $imageUrl = $this->firstImageDict[$model->id];
                }
                $resource->imageUrl = $imageUrl;
            }

            return $resource;
        });
    }
}
