<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Validation\Rule;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo encrypt(123);die;
        $admin_user=request()->admin_user??'';
        $where=[];
        if($admin_user){
            $where[]=['admin_user','like',"".$admin_user.""];
        }
        $pagesize=config('app.pagesize');
        $AdminInfo=Admin::where($where)->paginate($pagesize);
        return view('admin.index',['AdminInfo'=>$AdminInfo,'admin_user'=>$admin_user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'admin_user' => 'unique:admin|regex:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_]+$/u',
            'admin_tel' => 'regex:/^1[3,5,8,9]\d{9}$/',
            'admin_email'=>'regex:/^[a-zA-Z0-9]{5,}@[0-9a-zA-Z]{2,4}(\.)com$/',
            'admin_pwd'=>'required|confirmed',
            'admin_pwd_confirmation'=>'required',
        ],[
            'admin_user.unique'=>'管理员账号已存在',
            'admin_user.regex'=>'管理员账号管理员账号必须由中文或者数字字母下划线组成',
            'admin_tel.regex'=>'手机号有误',
            'admin_email.regex'=>'邮箱有误',
            'admin_pwd.required'=>'密码必填',
            'admin_pwd.confirmed'=>'两次密码不一致',
            'admin_pwd_confirmation.required'=>'确认密码必填',
        ]);
        $data=$request->except('_token','admin_pwd_confirmation');//也可以去黑名单设置
        if ($request->hasFile('admin_photo')) {
            //
            $data['admin_photo']=upload('admin_photo');
        }
       // dd($data['admin_photo']);
        $data['admin_pwd']=encrypt($data['admin_pwd']);
        $res=Admin::create($data);
        if($res){
            return redirect('/admin/index');
        }
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $AdminInfo=Admin::find($id);
        return view('admin.edit',['AdminInfo'=>$AdminInfo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'admin_user' => [
                'regex:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_]+$/u',
                Rule::unique('admin')->ignore($id,'admin_id'),
                ],
            'admin_tel' => 'regex:/^1[3,5,8,9]\d{9}$/',
            'admin_email'=>'regex:/^[a-zA-Z0-9]{5,}@[0-9a-zA-Z]{2,4}(\.)com$/',
        ],[
            'admin_user.unique'=>'管理员账号已存在',
            'admin_user.regex'=>'管理员账号管理员账号必须由中文或者数字字母下划线组成',
            'admin_tel.regex'=>'手机号有误',
            'admin_email.regex'=>'邮箱有误',
        ]);
        $data=$request->except('_token');
        if ($request->hasFile('admin_photo')) {
            //
            $data['admin_photo']=upload('admin_photo');
        }
        $res=Admin::where('admin_id','=',$id)->update($data);
        if($res!==false){
            return redirect('/admin/index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
        $admin_id=request()->admin_id;
        $res=Admin::destroy($admin_id);
        if($res){
            echo json_encode(['code'=>1,'font'=>'删除成功']);
        }else{
            echo json_encode(['code'=>2,'font'=>'删除失败']);
        }
    }
    public function checkOnly(){
        $where=[];
        $admin_user=request()->admin_user;
        if($admin_user){
            $where[]=['admin_user','=',$admin_user];
        }
        $admin_id=request()->admin_id;
        if($admin_id){
            $where[]=['admin_id','!=',$admin_id];
        }
        $count=Admin::where($where)->count();
        if($count>0){
            echo json_encode(['code'=>2,'font'=>'no']);
        }
    }
}
