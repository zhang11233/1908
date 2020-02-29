@extends('layouts.shop')
@section('title', '登录')
@section('content')
    <div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>会员注册</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/static/index/images/head.jpg" />
    </div><!--head-top/-->
    <form action="{{url('/logindo')}}" method="post" class="reg-login">
        <h3 style="color:red" align="center">{{session('msg')}}</h3>
        @csrf
        <h3>还没有三级分销账号？点此<a class="orange" href="{{url('/reg')}}">注册</a></h3>
        <div class="lrBox">
            <div class="lrList"><input type="text" placeholder="输入手机号码或者邮箱号" name="user_reg" /><b style="color:red"></b></div>
            <div class="lrList"><input type="password" placeholder="输入密码" name="user_pwd" /><b style="color:red"></b></div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="button" value="立即登录" />
        </div>
    </form><!--reg-login/-->
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
<script src="/static/index/js/jquery.min.js"></script>
<script>
    $(function(){
        $(document).on('click','input[type="button"]',function(){
            $('input[name="user_reg"]').next().html('');
            var user_reg=$('input[name="user_reg"]').val();
            if(user_reg==''){
                $('input[name="user_reg"]').next().html('手机号或邮箱不能为空');
                return false;
            }
            $('input[name="user_pwd"]').next().html('');
            var user_pwd=$('input[name="user_pwd"]').val();
            if(user_pwd==''){
                $('input[name="user_pwd"]').next().html('密码不能为空');
                return false;
            }
            $('form').submit();
        })
        $(document).on('blur','input[name="user_reg"]',function(){
            $(this).next().html('');
            var user_reg=$(this).val();
            if(user_reg==''){
                $(this).next().html('手机号或邮箱不能为空');
            }
        })
        $(document).on('blur','input[name="user_pwd"]',function(){
            $(this).next().html('');
            var user_pwd=$(this).val();
            if(user_pwd==''){
                $(this).next().html('密码不能为空');
            }
        })
    })
</script>
@endsection