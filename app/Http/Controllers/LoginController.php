<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
class LoginController extends Controller
{
   public function login(){
       return view('login.login');
   }
    public function logindo(){
        $data=request()->except('_token');
        $res=Users::where(
            'user_reg','=',$data['user_reg']
        )->first();
        dd($res);
    }
}
