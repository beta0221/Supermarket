<?php

namespace App\Http\Resources;

use App\CartRule;
use stdClass;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartRuleCollection extends ResourceCollection
{


    private $initColumn = ['id','name','priority'];
    private $typeDict = [];

    public function __construct($resource){
        parent::__construct($resource);
        $this->setDict();
    }

    private function setDict(){
        $ruleTypes = CartRule::getRuleTypes();
        foreach ($ruleTypes as $type) {
            $this->typeDict[$type['id']] = $type['name'];
        }
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

            $resource->active = $model->status;
            $resource->rule_type = '';
            if(isset($this->typeDict[$model->rule_type])){
                $resource->rule_type = $this->typeDict[$model->rule_type];
            }
            
            
            return $resource;
        });
    }
}
