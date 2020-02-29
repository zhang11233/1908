<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center><h1>外来务工人员列表</h1>
    <form>
        <input type="text" name="username" value="{{$username}}" placeholder="请输入用户名">
        <input type="submit" value="搜索">
    </form>
    <table>
        <tr>
            <td>ID</td>
            <td>用户名</td>
            <td>年龄</td>
            <td>身份证号</td>
            <td>头像</td>
            <td>是否湖北人</td>
            <td>添加时间</td>
            <td>操作</td>
        </tr>
        @foreach($data as $k=>$v)
        <tr @if($k%2==0) bgcolor="aqua" @else bgcolor="#7fffd4" @endif>
            <td>{{$v->p_id}}</td>
            <td>{{$v->username}}</td>
            <td>{{$v->age}}</td>
            <td>{{$v->card}}</td>
            <td>@if($v->head)<img src="{{env('UPLOAD_URL')}}{{$v->head}}" height="50px" width="50px">@else 无@endif</td>
            <td>{{$v->is_hubei==1?'√':'×'}}</td>
            <td>{{date('Y-m-d h:i:s',$v->add_time)}}</td>
            <td><a href="{{url('/people/destroy/'.$v->p_id)}}">删除</a>
                <a href="{{url('/people/edit/'.$v->p_id)}}">修改</a>
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="8">{{$data->appends(['username'=>$username])->links()}}</td>
        </tr>
    </table>
</body>
</html>