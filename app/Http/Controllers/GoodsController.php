<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goods;
use App\Cate;
use App\Brand;
use Illuminate\Validation\Rule;
class GoodsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $goods_name=request()->goods_name??'';
        $b_id=request()->b_id??'';
        $where=[];
        if($goods_name){
            $where[]=['goods_name','like',"%".$goods_name."%"];
        }
        if($b_id){
            $where[]=['g.b_id','=',$b_id];
        }
        $pagesize=config('app.pagesize');
        $brandInfo=Brand::get();
        $AllInfo=Goods::from('goods as g')->leftJoin('brand as b','g.b_id','=','b.b_id')->leftJoin('cate as c','g.cate_id','=','c.cate_id')->where($where)->paginate($pagesize);
        return view('goods.index',['AllInfo'=>$AllInfo,'goods_name'=>$goods_name,'brandInfo'=>$brandInfo,'b_id'=>$b_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $brandInfo=Brand::get();
        $cateInfo=Cate::get();
        $cateInfo=GetcateInfo($cateInfo);
        return view('goods.create',['brandInfo'=>$brandInfo,'cateInfo'=>$cateInfo]);
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
             'goods_name' => 'unique:goods|regex:/^[\x{4e00}-\x{9fa5}]+$/u',
             'goods_item' => 'regex:/^[a-z]{4}\d{13}$/',
             'goods_price' => 'regex:/^\d+.\d{2}$/',
             'goods_num' => 'regex:/^\d+$/',
        ],[
            'goods_name.unique'=>'商品名称已存在',
            'goods_name.regex'=>'商品名称必须为中文',
            'goods_item.regex'=>'商品货号必须由4位字母13位数字组成',
            'goods_price.regex'=>'商品价格必须由数字组成',
            'goods_num'=>'商品库存必须由数字组成',
      ]);
        $data=$request->except('_token');
        if ($request->hasFile('goods_img')) { // }
            $data['goods_img']=upload('goods_img');
        }
        //dd($data);
        if(isset($data['goods_imgs'])){
            $data['goods_imgs']=Moreupload('goods_imgs');
            $data['goods_imgs']=implode('|',$data['goods_imgs']);
        }
        //dd($data);
        $res=Goods::create($data);
        if($res){
            return redirect('/goods/index');
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
        $goodsInfo=Goods::find($id);
        $brandInfo=Brand::get();
        $cateInfo=Cate::get();
        $cateInfo=GetcateInfo($cateInfo);
        return view('goods.edit',['goodsInfo'=>$goodsInfo,'brandInfo'=>$brandInfo,'cateInfo'=>$cateInfo]);
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
            'goods_name' =>[
                'regex:/^[\x{4e00}-\x{9fa5}]+$/u',
                Rule::unique('goods')->ignore($id,'goods_id'),
            ],
            'goods_item' => 'regex:/^[a-z]{4}\d{13}$/',
            'goods_price' => 'regex:/^\d+.\d{2}$/',
            'goods_num' => 'regex:/^\d+$/',
        ],[
            'goods_name.unique'=>'商品名称已存在',
            'goods_name.regex'=>'商品名称必须为中文',
            'goods_item.regex'=>'商品货号必须由4位字母13位数字组成',
            'goods_price.regex'=>'商品价格必须由数字组成',
            'goods_num'=>'商品库存必须由数字组成',
        ]);
        $data=$request->except('_token');
        if ($request->hasFile('goods_img')) { // }
            $data['goods_img']=upload('goods_img');
        }
        if(isset($data['goods_imgs'])){
            $data['goods_imgs']=Moreupload('goods_imgs');
            $data['goods_imgs']=implode('|',$data['goods_imgs']);
        }
        $res=Goods::where('goods_id','=',$id)->update($data);
        if($res!==false){
            return redirect('/goods/index');
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
        $goods_id=request()->goods_id;
        $res=Goods::destroy($goods_id);
        if($res){
            echo json_encode(['code'=>1,'msg'=>'删除成功']);
        }else{
            echo json_encode(['code'=>2,'msg'=>'删除失败']);
        }
    }

    public function checkOnly(){
        $where=[];
        $goods_name=request()->goods_name;
        $goods_id=request()->goods_id;
        if($goods_name){
            $where[]=['goods_name','=',$goods_name];
        }
        if($goods_id){
            $where[]=['goods_id','!=',$goods_id];
        }
        $count=Goods::where($where)->count();
        if($count>0){
            echo json_encode(['code'=>2,'msg'=>'no']);
        }else{
            echo json_encode(['code'>1,'msg'=>'ok']);
        }
    }
}
