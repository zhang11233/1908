@extends('layouts.shop')

@section('title', '首页')
@section('content')
    <div class="maincont">
    <div class="head-top">
        <img src="/static/index/images/head.jpg" />
        <dl>
            <dt><a href="user.html"><img src="/static/index/images/touxiang.jpg" /></a></dt>
            <dd>
                <h1 class="username">@if(request()->session()->has('user_reg'))欢迎{{session('user_reg')}}登录 @else 未登录 @endif</h1>
                <ul>
                    <li><a href="prolist.html"><strong>{{$count}}</strong><p>全部商品</p></a></li>
                    <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
                    <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
                    <div class="clearfix"></div>
                </ul>
            </dd>
            <div class="clearfix"></div>
        </dl>
    </div><!--head-top/-->
    <form action="{{url('/')}}" method="get" class="search">
        <input type="text" name="goods_name" class="seaText fl"  value="{{$goods_name}}"/>
        <input type="submit" value="搜索" class="seaSub fr" />
    </form><!--search/-->
    <ul class="reg-login-click">
        <li><a href="{{url('/login')}}">登录</a></li>
        <li><a href="{{url('/reg')}}" class="rlbg">注册</a></li>
        <div class="clearfix"></div>
    </ul><!--reg-login-click/-->
    <div id="sliderA" class="slider">
        @foreach($goods_img as $k=>$v)
        <img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}"/>\
         @endforeach
    </div><!--sliderA/-->
    <ul class="pronav">
        @foreach($CateInfo as $k=>$v)
        <li><a href="prolist.html">{{$v->cate_name}}</a></li>
        @endforeach
        <div class="clearfix"></div>
    </ul><!--pronav/-->
    <div class="index-pro1">
        @foreach($GoodsInfo as $k=>$v)
        <div class="index-pro1-list">
            <dl>
                <dt><a href="{{url('/proinfo/'.$v->goods_id)}}"><img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}"  width="450px" height="200px"/></a></dt>
                <dd class="ip-text"><a href="proinfo.html">{{$v->goods_name}}</a><span>已售：488</span></dd>
                <dd class="ip-price"><strong>{{$v->goods_price*0.5}}</strong> <span>{{$v->goods_price}}</span></dd>
            </dl>
        </div>
        @endforeach
        <div class="clearfix"></div>
    </div><!--index-pro1/-->
    <div class="prolist">
        @foreach($GoodsInfo as  $k=>$v)
        <dl>
            <dt><a href="{{url('/proinfo/'.$v->goods_id)}}"><img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}" width="100" height="100" /></a></dt>
            <dd>
                <h3><a href="proinfo.html">{{$v->goods_name}}</a></h3>
                <div class="prolist-price"><strong>{{$v->goods_price*0.5}}</strong> <span>{{$v->goods_price}}</span></div>
                <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
            </dd>
            <div class="clearfix"></div>
        </dl>
        @endforeach
    </div><!--prolist/-->
    <div class="joins"><a href="fenxiao.html"><img src="/static/index/images/jrwm.jpg" /></a></div>
    <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>
        <div class="height1"></div>
        <div class="footNav">
            <dl>
                <a href="index.html">
                    <dt><span class="glyphicon glyphicon-home"></span></dt>
                    <dd>微店</dd>
                </a>
            </dl>
            <dl>
                <a href="prolist.html">
                    <dt><span class="glyphicon glyphicon-th"></span></dt>
                    <dd>所有商品</dd>
                </a>
            </dl>
            <dl>
                <a href="car.html">
                    <dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
                    <dd>购物车 </dd>
                </a>
            </dl>
            <dl>
                <a href="user.html">
                    <dt><span class="glyphicon glyphicon-user"></span></dt>
                    <dd>我的</dd>
                </a>
            </dl>
            <div class="clearfix"></div>
        </div><!--footNav/-->
    </div><!--maincont-->
@endsection
