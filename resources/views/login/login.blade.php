<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
</head>
<body>
<center>
<h1>登录页面</h1>
<b style="color:red">{{session('msg')}}</b>
<form action="{{url('/logindo')}}" method="post">
    @csrf
    {{--<input type="text" name="admin_user" placeholder="请输入用户名"><br/>--}}
    {{--<input type="text" name="admin_pwd" placeholder="请输入密码"><br/><br/>--}}
<input type="text" name="user_reg" placeholder="请输入用户名"><br/>
<input type="text" name="user_pwd" placeholder="请输入密码"><br/><br/>
<input type="submit" value="登录">
</form>
</body>
</html>