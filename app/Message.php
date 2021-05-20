<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Message extends Model
{
    protected $fillable = [
        'name',
        'email',
        'title',
        'message',
        'status'
    ];

    public static function insert_row(Request $request){
        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'title' => $request->title,
            'message' => $request->message,
            'status' => 0
        ]);
    }
}
