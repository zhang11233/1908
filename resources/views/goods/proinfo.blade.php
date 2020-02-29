@extends('layouts.shop')
@section('title', '详情页')
@section('content')
    <div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>产品详情</h1>
        </div>
    </header>
    <div id="sliderA" class="slider">
        @if($GoodsInfo['goods_imgs'])
        @php $goods_imgs=explode('|',$GoodsInfo['goods_imgs']) @endphp
        @foreach($goods_imgs as $v)
        <img src="{{env('UPLOAD_URL')}}{{$v}}" />
        @endforeach
        @endif
    </div><!--sliderA/-->
    <table class="jia-len">
        <tr>
            <th><strong class="orange">{{$GoodsInfo['goods_price']*0.5}}</strong></th>
            <td>
                <input type="text" id="buy_number" class="spinnerExample"/>
            </td>
        </tr>
        <tr>
            <td>
                <strong>{{$GoodsInfo['goods_name']}}</strong>
                <p class="hui">{{$GoodsInfo['goods_detail']}}</p>
            </td>
            <td align="right">
                <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
            </td>
        </tr>
    </table>
    <div class="height2"></div>
    <h3 class="proTitle">商品规格</h3>
    <ul class="guige">
        <li class="guigeCur"><a href="javascript:;">50ML</a></li>
        <li><a href="javascript:;">100ML</a></li>
        <li><a href="javascript:;">150ML</a></li>
        <li><a href="javascript:;">200ML</a></li>
        <li><a href="javascript:;">300ML</a></li>
        <div class="clearfix"></div>
    </ul><!--guige/-->
    <div class="height2"></div>
    <div class="zhaieq">
        <a href="javascript:;" class="zhaiCur">商品简介</a>
        <a href="javascript:;">商品参数</a>
        <a href="javascript:;" style="background:none;">订购列表</a>
        <div class="clearfix"></div>
    </div><!--zhaieq/-->
    <div class="proinfoList">
        <img src="{{env('UPLOAD_URL')}}{{$GoodsInfo['goods_img']}}" width="636" height="822" />
    </div><!--proinfoList/-->
    <div class="proinfoList">
        暂无信息....
    </div><!--proinfoList/-->
    <div class="proinfoList">
        暂无信息......
    </div><!--proinfoList/-->
    <table class="jrgwc">
        <tr>
            <th>
                <a href="index.html"><span class="glyphicon glyphicon-home"></span></a>
            </th>
            <td><a href="javascript:;" id="addCart">加入购物车</a></td>
        </tr>
    </table>
</div><!--maincont-->
    <script src="/jquery.min.js"></script>
    <script>
        $(function(){
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') } });
            $(document).on('click','#addCart',function(){
                var buy_number=$("#buy_number").val();
//                if(buy_number==0){
//                    alert('购买数量不能为空');
//                    return false;
//                }
                var goods_id="{{$GoodsInfo['goods_id']}}";
                $.ajax({
                    url:'/car',
                    data:{buy_number:buy_number,goods_id:goods_id},
                    type:'post',
                    dataType:'json',
                    success:function(res){
                       if(res.code==1){
                           alert(res.font);
                            location.href='/cart';
                       }else if(res.code==2){
                           alert(res.font);
                       }
                    }
                })
            })
        });
    </script>
    @endsection


