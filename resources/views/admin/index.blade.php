<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form>
    <input type="text" name="admin_user" value="{{$admin_user}}" placeholder="请输入管理员账号">
    <input type="submit" value="搜索">
</form>
<table border="1px">
    <tr>
        <td>管理员id</td>
        <td>管理员账号</td>
        <td>管理员手机号</td>
        <td>管理员邮箱</td>
        <td>管理员头像</td>
        <td>操作</td>
    </tr>
    @foreach($AdminInfo as $v)
    <tr admin_id="{{$v->admin_id}}">
        <td>{{$v->admin_id}}</td>
        <td>{{$v->admin_user}}</td>
        <td>{{$v->admin_tel}}</td>
        <td>{{$v->admin_email}}</td>
        <td><img src="{{env('UPLOAD_URL')}}{{$v->admin_photo}}" width="50px" height="50px"></td>
        <td><a href="javascript:;" class="del">删除</a>
            <a href="{{url('admin/edit/'.$v->admin_id)}}">修改</a>
        </td>
    </tr>
        @endforeach
</table>
{{$AdminInfo->appends(['admin_user'=>$admin_user])->links()}}
</body>
</html>
<script src="/jquery.min.js"></script>
<script>
    $(function(){
        $(document).on('click','.del',function(){
            var admin_id=$(this).parents('tr').attr('admin_id');
            var _this=$(this);
            $.get(
               '/admin/destroy',
                {admin_id:admin_id},
               function(res){
                   if(res.code==1){
                       _this.parents('tr').remove();
                       location.href='/admin/index';
                   }
               },
                 'json'
            );
        })
    })
</script>