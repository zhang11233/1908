<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 设置
        // session(['name'=>'zhangsan']);//session存值
        // request()->session()->save();//确保将值存入session(全局辅助函数)

        // 删除
        // session(['name'=>null]);//清空session
        // request()->session()->save();//确保将值存入session(全局辅助函数)

        // //获取
        // echo session('name');//获取session的值

        // request实例 设置
        // request()->session()->put('age',19);//put存值
        // request()->session()->save();

        // echo request()->session()->get('age');//get获取

        // //删除
        // request()->session()->forget('age');//forget删除
        // dd(request()->session()->get('age'));
        // // die;



        $data=Brand::get();
        return view('brand.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // echo session('name');die;
        return view('brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->except('_token');
        if ($request->hasFile('b_logo')) {
            $data['b_logo'] = $this->upload('b_logo');
        }
        $res=Brand::create($data);
        if($res){
            return redirect('/brand/index');
        }
    }

    public function upload($filename){
        if(request()->file($filename)->isValid()) {
            $photo = request()->file($filename);
            $store_result = $photo->store('upload');
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
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
        $data=Brand::find($id);
        return view('brand.edit',['data'=>$data]);
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
        $data=$request->except('_token');
        if ($request->hasFile('b_logo')) {
            $data['b_logo'] = $this->upload('b_logo');
        }
        //dd($data);
        $res=Brand::where('b_id',$id)->update($data);
        if($res!==false){
            return redirect('brand/index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $res=Brand::destroy($id);
        if($res){
            return redirect('/brand/index');
        }
    }
}
