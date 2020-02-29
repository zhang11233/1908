<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use App\Cart;
class GoodsController extends Controller
{
    //
    function index($id){
        $GoodsInfo=Goods::find($id);
        return view('goods.proinfo',['GoodsInfo'=>$GoodsInfo]);
    }
    function addcart(){
        $goods_id=request()->goods_id??'';
        $buy_number=request()->buy_number;
        if($buy_number==0){
           echo json_encode(['code'=>2,'font'=>'购买数量不能为空']);die;
        }
        if(request()->session()->has('user_id')) {
             $res=$this->addCartDb($goods_id,$buy_number);
        }
        if($res){
            echo json_encode(['code'=>1,'font'=>'加入购物车成功']);die;
        }else{
            echo json_encode(['code'=>2,'font'=>"加入购物车失败"]);die;
        }
    }
    function addCartDb($goods_id,$buy_number){
        $where=[
            ['user_id','=',session('user_id')],//这个用户
            ['goods_id','=',$goods_id],//商品id
            ['cart_del','=',1],//隐藏条件,回收站为正常
        ];
        $goods_num=Goods::where('goods_id','=',$goods_id)->value('goods_num');
        $CartInfo=Cart::where($where)->first();
        //如果加入过,不是空的,累加
        if(!empty($CartInfo)){
            //如果你要买的数量加上数据库之前要买的数量大于商品库存
            if(($CartInfo['buy_number']+$buy_number)>$goods_num){
                $buy_number=$goods_num;//要买的数量就是最大库存
            }else{
                $buy_number=$CartInfo['buy_number']+$buy_number;//否则做累加
            }
            $res=Cart::where($where)->update(['buy_number'=>$buy_number,'add_time'=>time()]);//修改添加时间和购买数量
            //否则添加
        }else{
            if($buy_number>$goods_num){//购买数量大于库存
                $buy_number=$goods_num;//要买的数量就是最大库存
            }
            $arr=["goods_id"=>$goods_id,'buy_number'=>$buy_number,'add_time'=>time(),'user_id'=>session('user_id')];//把商品id、购买数量、加入购物车的时间、用户id存入数据库
            $res=Cart::create($arr);//存储数据库
        }
        return $res;
    }

    public function cartList(){
        
        return view('goods.cartlist');
    }
}
