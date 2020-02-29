<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<table border="1px">
    <tr>
        <td>分类id</td>
        <td>分类名称</td>
        {{--<td>父级分类</td>--}}
        <td>分类描述</td>
        <td>操作</td>
    </tr>
    @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->cate_id}}</td>
        <td>{!! str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$v->level*2.5)!!}{{$v->cate_name}}</td>
        {{--<td>{{$v->pid}}</td>--}}
        <td>{{$v->cate_detail}}</td>
        <td><a href="{{url('cate/destroy/'.$v->cate_id)}}">删除</a>
            <a href="{{url('cate/edit/'.$v->cate_id)}}">修改</a>
        </td>
    </tr>
    @endforeach
</table>
</body>
</html>