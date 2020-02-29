<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center>
<h1>用户管理</h1>
    <table border="1">
        <tr>
            <td>用户id</td>
            <td>用户昵称</td>
            <td>用户身份</td>
            <td>操作</td>
        </tr>
        @foreach($usersInfo as $v)
        <tr>
            <td>{{$v->users_id}}</td>
            <td>{{$v->users_name}}</td>
            <td>@if($v->users_identity==1)库管主管 @else 普通库管员 @endif</td>
            <td><a href="{{url('destroy/'.$v->users_id)}}">删除</a>
                <a href="{{url('create')}}">添加</a>
            </td>
        </tr>
            @endforeach
    </table>
</body>
</html>