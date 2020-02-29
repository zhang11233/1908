<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logins;
class CheckController extends Controller
{
    public function logindo(){
    	$post = request()->except("_token");

    	// $post['users_pwd'] = encrypt($post['users_pwd']);//encrypt laravel中加密的一中
    	$logins = Logins::where(['users_name'=>$post['users_name']])->first();

    	//如果登录的密码和表中的密码不一致的话  decrypt解密(全局辅助函数)
    	if ($post['users_pwd']!=decrypt($logins['users_pwd'])) {
    		return redirect('/article/login')->with('msg','没有此用户');
    	}

    	session(['adminuser'=>$logins]);
    	request()->session()->save();
    	return redirect('/article/index');
    }
}
