<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center>库存管理系统<br/>
<a href="#">货物管理</a>
<a href="#">出入库记录管理</a>
@if(session('users_identity')==1)<a href="{{url('/indexs')}}">用户管理</a> @endif
</body>
</html>