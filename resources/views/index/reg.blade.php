@extends('layouts.shop')
@section('title', '注册')
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
    <form action="{{url('/regdo')}}" method="post" class="reg-login">
        @csrf
        <h3>已经有账号了？点此<a class="orange" href="{{url('/login')}}">登陆</a></h3>
        <div class="lrBox">
            <div class="lrList">
                <input type="text"  name="user_reg" placeholder="输入手机号码或者邮箱号" /><b style="color:red">{{$errors->first('user_reg')}}
                </b>
            </div>
            <div class="lrList2"><input type="text" name="user_code" placeholder="输入短信验证码" /><button type="button" id="acquire_reg">获取</button><b style="color:red">{{session('msg')}}{{$errors->first('user_code')}}</b></div>
            <div class="lrList"><input type="password" name="user_pwd" placeholder="设置新密码（6-18位数字或字母）" /><b style="color:red">{{$errors->first('user_pwd')}}</b></div>
            <div class="lrList"><input type="password" name="user_pwd_confirmation" placeholder="再次输入密码" /><b style="color:red">{{$errors->first('user_pwd_confirmation')}}</b></div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="button" value="立即注册" />
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
<script src="/jquery.min.js"></script>
<script>
    $(function(){
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') } });
        $(document).on('click','input[type="button"]',function(){
            $('input[name="user_reg"]').next().html('');
            var user_reg=$('input[name="user_reg"]').val();
            if(user_reg==''){
                $('input[name="user_reg"]').next().html('手机号或者邮箱不能为空');
                return false;
            }
            if(user_reg.match('@')=='@'){
                var reg=/^[0-9a-zA-Z]+@[0-9a-zA-Z]{2,4}(\.)com$/;
                if(!reg.test(user_reg)){
                    $('input[name="user_reg"]').next().html('手机号或邮箱输入有误');
                    return false;
                }
            }else{
                var reg=/^1[3,5,8,9]\d{9}$/;
                if(!reg.test(user_reg)){
                    $('input[name="user_reg"]').next().html('手机号或邮箱输入有误');
                    return false;
                }
            }
            var flag=true;
            $.ajax({
                url:'/login/checkOnly',
                data:{user_reg:user_reg},
                type:'post',
                dataType:'json',
                async:false,
                success:function(res){
                    if(res.code==2){
                        $('input[name="user_reg"]').next().html('手机号或邮箱已存在');
                        flag=false;
                    }
                }
            })
            if(!flag){
                return false;
            }
            $('input[name="user_code"]').next().next().html('');
            var user_code=$('input[name="user_code"]').val();
            if(user_code==''){
                $('input[name="user_code"]').next().next().html('验证码不能为空');
                return false;
            }
            $('input[name="user_pwd"]').next().html('');
            var user_pwd=$('input[name="user_pwd"]').val();
            if(user_pwd==''){
                $('input[name="user_pwd"]').next().html('密码不能为空');
                return false;
            }
            var reg=/^[0-9a-zA-Z]{6,18}$/;
            if(!reg.test(user_pwd)){
                $('input[name="user_pwd"]').next().html('密码格式错误');
                return false;
            }
            $('input[name="user_pwd_confirmation"]').next().html('');
            var user_pwd_confirmation=$('input[name="user_pwd_confirmation"]').val();
            var user_pwd=$('input[name="user_pwd"]').val();
            if(user_pwd_confirmation==''){
                $('input[name="user_pwd_confirmation"]').next().html('确认密码不能为空');
                return false;
            }
            var reg=/^[0-9a-zA-Z]{6,18}$/;
            if(!reg.test(user_pwd_confirmation)){
                $('input[name="user_pwd_confirmation"]').next().html('密码格式错误');
                return false;
            }
            if(user_pwd_confirmation!=user_pwd){
                $('input[name="user_pwd_confirmation"]').next().html('两次密码不一致');
                return false;
            }
            $('form').submit();
        })
        $(document).on('blur','input[name="user_reg"]',function(){
            $(this).next().html('');
            var user_reg=$(this).val();
            if(user_reg==''){
               $(this).next().html('手机号或者邮箱不能为空');
                return false;
            }
            if(user_reg.match('@')=='@'){
                var reg=/^[0-9a-zA-Z]+@[0-9a-zA-Z]{2,4}(\.)com$/;
                if(!reg.test(user_reg)){
                    $(this).next().html('手机号或邮箱输入有误');
                    return false;
                }
            }else{
                var reg=/^1[3,5,8,9]\d{9}$/;
                if(!reg.test(user_reg)){
                    $(this).next().html('手机号或邮箱输入有误');
                    return false;
                }
            }
            var flag=true;
            $.ajax({
                url:'/login/checkOnly',
                data:{user_reg:user_reg},
                type:'post',
                dataType:'json',
                async:false,
                success:function(res){
                    if(res.code==2){
                        $('input[name="user_reg"]').next().html('手机号或邮箱已存在');
                        flag=false;
                    }
                }
            })
            if(!flag){
                return false;
            }
        })
        $(document).on('blur','input[name="user_code"]',function(){
            $(this).next().next().html('');
            var user_code=$(this).val();
            if(user_code==''){
                $(this).next().next().html('验证码不能为空');
            }
        })
        $(document).on('click','#acquire_reg',function(){
            $(this).next().html('');
            $("#acquire_reg").text("60s");
            $("#acquire_reg").css("pointer-events","none");
            set=setInterval(goTime_tel,1000);
            var user_reg=$('input[name="user_reg"]').val();
            if(user_reg.length==11){
                /*发送手机号*/
                $.ajax({
                    url:"/login/sendReg",
                    data:{user_reg:user_reg},
                    type:'post',
                    dataType:'json',
                    success:function(res){
                        alert(res.font);
                    }
                })
            }
        })
        function goTime_tel(){
            var second=$("#acquire_reg").text();
            second=parseInt(second);
            if(second==0){
                clearInterval(set);
                $("#acquire_reg").text("获取");
                $("#acquire_reg").css("pointer-events","auto");
            }else{
                second=second-1;
                $("#acquire_reg").text(second+'s');
                $("#acquire_reg").css("pointer-events","none");
                //$("#span_tel").prop('disabled',true)
            }
        }
        $(document).on('blur','input[name="user_pwd"]',function(){
            $(this).next().html('');
            var user_pwd=$(this).val();
            if(user_pwd==''){
                $(this).next().html('密码不能为空');
                return false;
            }
            var reg=/^[0-9a-zA-Z]{6,18}$/;
            if(!reg.test(user_pwd)){
                $(this).next().html('密码格式错误');
                return false;
            }
        })
        $(document).on('blur','input[name="user_pwd_confirmation"]',function(){
            $(this).next().html('');
            var user_pwd_confirmation=$(this).val();
            var user_pwd=$('input[name="user_pwd"]').val();
            if(user_pwd_confirmation==''){
                $(this).next().html('确认密码不能为空');
                return false;
            }
            var reg=/^[0-9a-zA-Z]{6,18}$/;
            if(!reg.test(user_pwd_confirmation)){
                $(this).next().html('密码格式错误');
                return false;
            }
            if(user_pwd_confirmation!=user_pwd){
                $(this).next().html('两次密码不一致');
                return false;
            }
        })
    })
</script>
@endsection