<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
class LoginsController extends Controller
{
   public function loginsdo(){
       $data=request()->except('_token');
       $res=Users::where('users_name','=',$data['users_name'])->first();
       if(!$res){
           return redirect('/logins')->with('msg','没有此用户');
       }
       if($data['users_pwd']!=decrypt($res->users_pwd)){
           return redirect('/logins')->with('msg','密码错误');
       }
       session(['users_id'=>$res['users_id'],'users_name'=>$res['users_name'],'users_identity'=>$res['users_identity']]);
       request()->session()->save();
       return redirect('/index');
   }
}
