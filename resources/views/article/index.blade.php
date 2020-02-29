<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center>
    <form>
        请输入文章标题:<input type="text" name="a_title" placeholder="请输入文章标题" value="{{$a_title}}"><br>
        请选择文章分类:<select name="c_id">
            <option value="">--请选择--</option>
            @foreach($cateInfo as $v)
            <option value="{{$v->c_id}}" {{$c_id==$v->c_id?'selected':''}}>{{$v->c_name}}</option>
            @endforeach
        </select>
        <input type="submit" value="搜索">
    </form>
<table border="1px">
    <thead>
    <tr>
        <td>文章id</td>
        <td>文章标题</td>
        <td>文章分类</td>
        <td>文章重要性</td>
        <td>是否显示</td>
        <td>文章作者</td>
        <td>作者email</td>
        <td>关键字</td>
        <td>文章描述</td>
        <td>文章图片</td>
        <td>操作</td>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $k=>$v)
    <tr a_id="{{$v->a_id}}">
        <td>{{$v->a_id}}</td>
        <td>{{$v->a_title}}</td>
        <td>{{$v->c_name}}</td>
        <td>@if($v->a_important==1)普通@else置顶@endif</td>
        <td>@if($v->a_show==1)√@else×@endif</td>
        <td>{{$v->a_author}}</td>
        <td>{{$v->a_email}}</td>
        <td>{{$v->a_keyword}}</td>
        <td>{{$v->a_detail}}</td>
        <td><img src="{{env('UPLOAD_URL')}}{{$v->a_photo}}" width="50px" height="50px"></td>
        <td>
            <a href="javascript:;" class="del">删除</a>
            <a href="{{url('/article/edit/'.$v->a_id)}}">修改</a>
            <a href="{{url('/article/show/'.$v->a_id)}}">预览详情</a>
        </td>
    </tr>
    @endforeach
        <tr>
            <td colspan="11">{{ $data->appends(['a_title'=>$a_title,'c_id'=>$c_id])->links() }}</td>
        </tr>
    </tbody>
</table>

</body>
</html>
<script src="/jquery.min.js"></script>
<script>
    //给类为pagination的属性的a标签一个点击事件
    $(document).on('click','.pagination a',function(){
        var url=$(this).attr('href');//获取当前点击对象的自定义属性的href的值
        $.get(
             url,//从66行传过来的 获取当前点击对象的自定义属性的href的值的常量
             function(result){
                 $('tbody').html(result);
             }
        )
        return false;//当点击页码状态栏中不传值不跳转
    })
    $(function(){
        $(document).on('click','.del',function(){
            var a_id=$(this).parents('tr').attr('a_id');
            if(a_id.length<=0){
                return false;
            }
            $.get(
                '/article/destroy',
                {a_id:a_id},
                function(res){
                    if(res.code=='0000'){
                        $('a[class="del"]').parents('tr').remove();
                        location.href='/article/index';
                    }
                },
                   'json'
            )
        })
    })
</script>