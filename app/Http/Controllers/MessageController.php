<?php

namespace App\Http\Controllers;

use App\Helpers\Pagination;
use App\Message;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;
use \Validator;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
{

    use CrudTrait;
    
    public function __construct()
    {
        $this->model =Message::class;
        $this->storeRule = [
            'name'=>['required','max:255','string'],
            'email' => ['required','max:255','Email','string'],
            'title' => ['required','max:255','string'],
            'message' => ['required','string']
        ];
        $this->updateRule = [
            'status'=> ['required','integer']
        ];
        $this->updateColumns = ['status'];
    }

    public function index(Request $request){
        
        $p = new Pagination($request);

        $query = new Message();
        if($request->has('status')){
            $query = $query->where('status',(int)$request->status);
        }

        $p->cacuTotalPage($query->count());
        
        $messageList = $query->skip($p->skip)
            ->take($p->rows)
            ->orderBy($p->orderBy,$p->order)
            ->get();

        foreach ($messageList as $i => $message) {
            $message->statusText = '待處理';
            if($message->status == 1){$message->statusText = '結案';}
            $created_at = $message->created_at->format("Y/m/d H:m:s");
            $message->timestamps = false;
            $message->created_at = $created_at;
        }

        return response([
            'data'=>$messageList,
            'pagination'=>$p,
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), $this->storeRule);
        Session::flash('error', $validator->errors()); 
        if (!$validator->fails()) {
            Session::flash('success', '訊息已成功送出，我們將會儘速回覆您。'); 
        }

        //SendMail::dispatch($request->email,$order_numero);
        
        return redirect()->route('contact');
        
    }

    
}
