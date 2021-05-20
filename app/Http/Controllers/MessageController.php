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
        if ($validator->fails()){
            // return response($request->all());
            Session::flash('error', $validator->errors());
            Session::flash('request',$request->all());
            return redirect()->route('contact');
        }

        //recaptcha
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => '6LfOZnoUAAAAAFNdAX43Z17487emgfmW5r1Rj9CQ',
            'response' => $request->input('g-recaptcha-response')
        );
        $options = array(
            'http' => array (
                'method' => 'POST',
                'header'=>"Content-Type: application/x-www-form-urlencoded",
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $result = json_decode($verify);
        
        if ($result->success==false) {
            Session::flash('request',$request->all());
            return redirect()->route('contact');
        }

        Message::insert_row($request);
        //SendMail::dispatch($request->email,$order_numero);

        Session::flash('success', '訊息已成功送出，我們將會儘速回覆您。'); 
        return redirect()->route('contact');
        
    }

    
}
