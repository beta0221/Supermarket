<?php
namespace App\Traits;

use App\Helpers\Pagination;
use Illuminate\Http\Request;
use \Validator;

/**
 * 使用CrudTrait
 */
trait CrudTrait{

    /** CRUD 對象 */
    protected $model;
    /** C 規則 */
    protected $storeRule = [];
    /** U 規則 */
    protected $updateRule = [];
    /** U 欄位 */
    protected $updateColumns = [];



    /**
     * model實例化
     * @param mixed $value
     * @return object 
     */
    private function getModelInstance($value){
        $key = (property_exists($this->model,'key'))?$this->model::$key:'id';
        $model = $this->model::where($key,$value)->firstOrFail();
        return $model;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $p = new Pagination($request);
        $p->cacuTotalPage($this->model::count());
        
        $modelList = $this->model::skip($p->skip)
            ->take($p->rows)
            ->orderBy($p->orderBy,$p->order)
            ->get();

        return response([
            'data'=>$modelList,
            'pagination'=>$p,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), $this->storeRule);
        if ($validator->fails()) { return response($validator->messages(),400); }
        
        $model = $this->model::create($request->all());
        return response($model);
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $value
     * @return \Illuminate\Http\Response
     */
    public function show($value)
    {
        $model = $this->getModelInstance($value);
        return response($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  mixed  $value
     * @return \Illuminate\Http\Response
     */
    public function edit($value)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $value
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $value)
    {
        $validator = Validator::make($request->all(), $this->updateRule);
        if ($validator->fails()) { return response($validator->messages(),400); }

        $model = $this->getModelInstance($value);

        try {
            $model->update($request->only($this->updateColumns));
        } catch (\Throwable $th) {
            return response($th,500);
        }

        return response($model);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $value
     * @return \Illuminate\Http\Response
     */
    public function destroy($value)
    {
        //
    }


}