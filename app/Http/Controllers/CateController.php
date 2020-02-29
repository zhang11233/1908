<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cate;
use Illuminate\Validation\Rule;
class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data=Cate::get();
       // dd($data);
        $data=GetcateInfo($data);
        //dd($data);
        return view('cate.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cateInfo=Cate::get();
        //print_r($cateInfo);die;
        $cateInfo=GetcateInfo($cateInfo);
        //dd($cateInfo);
        return view('cate.create',['cateInfo'=>$cateInfo]);
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
            'cate_name' => 'unique:cate|regex:/^[\x{4e00}-\x{9fa5}]+$/u',
        ],[
            'cate_name.regex'=>'分类名称必须是中文',
            'cate_name.unique'=>'分类名称已存在',
        ]);
        $data=$request->except('_token');
        $res=Cate::create($data);
        if($res){
            return redirect('/cate/index');
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
        //{{$data->pid==$v->cate_id?'selected':''}}
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
        $data=Cate::find($id);
        //dd($data);
        $cateInfo=Cate::get();
        $cateInfo=GetcateInfo($cateInfo);
        return view('cate.edit',['cateInfo'=>$cateInfo,'data'=>$data]);
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
            'cate_name' => [
                'regex:/^[\x{4e00}-\x{9fa5}]+$/u',
                Rule::unique('cate')->ignore($id,'cate_id'),
            ],
        ],[
            'cate_name.regex'=>'分类名称必须是中文',
            'cate_name.unique'=>'分类名称已存在',
        ]);
        $data=$request->except('_token');
        $res=Cate::where('cate_id','=',$id)->update($data);
        if($res!==false){
            return redirect('cate/index');
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
        $count=Cate::where('pid','=',$id)->count();
        if($count>0){
            echo "<script>alert('不可删除');location.href='/cate/index';</script>";
        }else{
            $res=Cate::destroy($id);
            if($res){
                return redirect('cate/index');
            }
        }
    }

    public  function checkOnly(){
        $cate_name=request()->cate_name;
        if($cate_name){
            $where[]=['cate_name','=',$cate_name];
        }
        $cate_id=request()->cate_id;
        if($cate_id){
            $where[]=['cate_id','!=',$cate_id];
        }
        $count=Cate::where($where)->count();
        if($count){
            echo json_encode(['code'=>1,'msg'=>'ok','count'=>$count]);
        }
    }
}
