<?php

namespace App\Http\Controllers\index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use Illuminate\Support\Facades\Cookie;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use App\Mail\SendCode;
use Illuminate\Support\Facades\Mail;
class LoginsController extends Controller
{
    //验证唯一性
    function checkOnly(){
        $user_reg=request()->user_reg??'';
        $count=Users::where('user_reg','=',$user_reg)->count();
        if($count>0){
            echo json_encode(['code'=>2,'font'=>'no']);
        }else{
            echo json_encode(['code'=>1,'font'=>'ok']);
        }
    }
    //发送邮件
    function sendCode(){
        $email='791131672@qq.com';
        $res=Mail::to($email)->send(new SendCode());
        dd($res);
    }
    //ajax发送短信
    function sendReg(){
        request()->validate([
            'user_reg' => 'unique:user|regex:/^1[3,5,8,9]\d{9}$/',
        ],[
            'user_reg.unique'=>'手机号或者邮箱已存在',
            'user_reg.regex'=>'手机号或邮箱输入有误',
        ]);
        $user_reg=request()->user_reg??'';
        $code=rand(100000,999999);
        $res=$this->sendTel($user_reg,$code);
        $TelInfo=array('user_tel'=>$user_reg,'user_code'=>$code,'user_time'=>time());
        $TelInfo=serialize($TelInfo);
        if($res['Code']=='OK'){
            Cookie::queue('TelInfo',$TelInfo,60);
            echo json_encode(['code'=>1,'font'=>'发送成功']);
        }else{
            echo json_encode(['code'=>2,'font'=>'发送失败']);
        }
    }
    //发送短信
    public function sendTel($user_reg,$code){
                            AlibabaCloud::accessKeyClient('LTAI4Fxof2KHa3qSmXathxpb', 'q5RbylYH8QyKruLcDnPrF8hdpPloeb')
                                    ->regionId('cn-hangzhou')
                                    ->asDefaultClient();

                        try {
                                    $result = AlibabaCloud::rpc()
                                    ->product('Dysmsapi')
                                        // ->scheme('https') // https | http
                                    ->version('2017-05-25')
                                    ->action('SendSms')
                                    ->method('POST')
                                    ->host('dysmsapi.aliyuncs.com')
                                    ->options([
                                    'query' => [
                                        'RegionId' => "cn-hangzhou",
                                        'PhoneNumbers' =>$user_reg,
                                        'SignName' => "是不是应该放弃",
                                        'TemplateCode' => "SMS_178755775",
                                        'TemplateParam' => "{code:$code}",
                                    ],
                                    ])
                                    ->request();
                            return $result->toArray();
                        } catch (ClientException $e) {
                            return $e->getErrorMessage();
                        } catch (ServerException $e) {
                            return $e->getErrorMessage();
                        }
                                }
    //测试cookie
    function user_index(){
//        $abc=['a'=>1,'b'=>2];
//        $abc=serialize($abc);
//        return response('测试产生cookie')->cookie('name',$abc,3);
        $abc=Cookie::get('name');
        $abc=unserialize($abc);
        echo $abc['b'];
//    Cookie::queue('name',null,-1);
    }
    //点击注册
    function regdo(){
        request()->validate([
            'user_reg' => 'unique:user|regex:/^1[3,5,8,9]\d{9}$/',
            'user_pwd'=>'required|confirmed|regex:/^[0-9a-zA-Z]{6,18}$/',
            'user_pwd_confirmation'=>'required',
            'user_code'=>'required',
        ],[
            'user_reg.unique'=>'手机号或邮箱已存在',
            'user_reg.regex'=>'手机号或邮箱输入有误',
            'user_pwd.required'=>'密码必填',
            'user_pwd.confirmed'=>'两次密码不一致',
            'user_pwd.regex'=>'密码格式错误',
            'user_pwd_confirmation.required'=>'确认密码必填',
            'user_code.required'=>'验证码不能为空'
        ]);
        $TelInfo=Cookie::get('TelInfo');
        $TelInfo=unserialize($TelInfo);
        $data=request()->except('_token','user_pwd_confirmation');
        if($TelInfo['user_tel']!=$data['user_reg']){
            echo  "<script>alert('发送验证码的手机号和当前的手机号不一致');location.href='/reg';</script>";
            //return redirect('/reg')->with('msg','发送验证码的手机号和当前的手机号不一致');die;
        }
        if(empty($data['user_code'])){
            echo  "<script>alert('验证码不能为空');location.href='/reg';</script>";die;
            //return redirect('/reg')->with('msg','验证码不能为空');die;
        }else if($TelInfo['user_code']!=$data['user_code']){
            echo  "<script>alert('验证码有误');location.href='/reg';</script>";die;
            //return redirect('/reg')->with('msg','验证码有误');die;
        }else if((time()-$TelInfo['user_time'])>300){
            echo  "<script>alert('验证码已超时');location.href='/reg';</script>";die;
        }
        $data['user_pwd']=encrypt($data['user_pwd']);
        $res=Users::create($data);
        if($res){
            return redirect('/login');
        }
    }
    function logindo(){
        request()->validate([
            'user_reg' => 'required',
            'user_pwd'=>'required',
        ],[
            'user_reg.required'=>'手机号或邮箱不能为空',
            'user_pwd.required'=>'密码不能为空',
        ]);
        $data=request()->except('_token');
        $res=Users::where('user_reg','=',$data['user_reg'])->first();
        if(!$res){
            return redirect('/login')->with('msg','没有此用户');
        }
        if($data['user_pwd']!=decrypt($res->user_pwd)){
            return redirect('/login')->with('msg','密码错误');
        }
        session(['user_id'=>$res->user_id,'user_reg'=>$res->user_reg]);
        request()->session()->save();
        return redirect('/');
    }
}
