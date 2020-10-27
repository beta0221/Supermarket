<?php
namespace App\Helpers;

use Illuminate\Http\Request;

class Pagination{

    public $page = 1;
    public $rows = 10;
    
    public $orderBy = 'id';
    public $order = 'desc';
    
    public $skip = 0;
    
    //

    public $total = 0;
    public $hasNextPage = true;
    public $totalPage = 0;

    public function __construct(Request $request)
    {
        if($request->has('page')){
            $this->page = $request->page;
        }
        if($request->has('rows')){
            $this->rows = $request->rows;
        }
        if($request->has('orderBy')){
            $this->orderBy = $request->orderBy;
        }
        if($request->order == 'asc'){
            $this->order = 'asc';
        }

        $this->skip = ($this->page - 1) * $this->rows;
    }


    /**
     * 計算總頁數
     * @param int $total
     * @return Void
     */
    public function cacuTotalPage(int $total){
        $this->total = $total;
        if(($this->skip + $this->rows) >= $total){
            $this->hasNextPage = false;
        }
        $this->totalPage = ceil($total / $this->rows);
    }
}