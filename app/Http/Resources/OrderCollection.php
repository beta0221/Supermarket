<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\User;
use stdClass;

/**
 * 訂單列表（後台用）
 */
class OrderCollection extends ResourceCollection
{
    private $idArray = [];
    private $initColumn = ['order_numero','status_id','buyer','created_at'];
    private $userNameDict = [];

    public function __construct($resource){
        parent::__construct($resource);
        foreach($this as $model){ $this->idArray[] = $model->user_id; }
    }

    public function withUserName(){
        $this->userNameDict = [];
        $users = User::whereIn('id',$this->idArray)->orderBy('id','desc')->get();
        foreach ($users as $user){
            $this->userNameDict[$user->id] = $user->name;
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
            if(!is_null($this->userNameDict)){
              $buyer = null ;
              if(isset($this->userNameDict[$model->user_id])){
                  $buyer = $this->userNameDict[$model->user_id];
                }
            }
            $resource->buyer= $buyer;
            return $resource;
        });
    }
}
