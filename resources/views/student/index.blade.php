<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center><h1>学生展示页面</h1>
    <form>
    <input type="text" name="s_name" value="{{$s_name}}" placeholder="请输入学生姓名">
    <input type="text" name="s_class" value="{{$s_class}}" placeholder="请输入学生班级">
    <input type="submit" value="提交">
    </form>
    <table border="1px">
        <tr>
            <td>学生id</td>
            <td>学生姓名</td>
            <td>学生性别</td>
            <td>学生班级</td>
            <td>学生成绩</td>
            <td>学生照片</td>
            <td>操作</td>
        </tr>
        @foreach($data as $k=>$v)
        <tr>
            <td>{{$v->s_id}}</td>
            <td>{{$v->s_name}}</td>
            <td>{{$v->s_sex==1?'男':'女'}}</td>
            <td>{{$v->s_class}}</td>
            <td>{{$v->s_performance}}</td>
            <td>@if($v->s_photo)<img src="{{env('UPLOAD_URL')}}{{$v->s_photo}}" height="50px" width="50px">@else 无 @endif</td>
            <td>
                <a href="{{url('/student/destroy/'.$v->s_id)}}">删除</a>
                <a href="{{url('/student/edit/'.$v->s_id)}}">修改</a>
            </td>
        </tr>
            @endforeach
    </table>
    {{$data->appends(['s_name'=>$s_name,'s_class'=>$s_class])->links()}}
</body>
</html>