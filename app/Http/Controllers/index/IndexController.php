<?php

namespace App\Http\Controllers\index;
use App\Cate;
use App\Goods;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
class IndexController extends Controller
{
    //
    function index(){
        $goods_name=request()->goods_name??'';
        $where=[];
        if($goods_name){
            $where[]=['goods_name','like',"%".$goods_name."%"];
        }
        $CateInfo=Cate::limit(4)->where('pid','=',0)->get();
        $goods_img=Goods::limit(4)->select('goods_img')->get();
        $GoodsInfo=Goods::where($where)->limit(8)->get();
        $count=Goods::count();
        return view('index.index',['CateInfo'=>$CateInfo,'goods_img'=>$goods_img,'GoodsInfo'=>$GoodsInfo,'goods_name'=>$goods_name,'count'=>$count]);
    }

}
