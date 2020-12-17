<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Auth;

class AuthController extends Controller
{
    public function admin_login(){
        
        return view('admin');
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
      }
}
