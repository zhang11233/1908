<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Document</title>
</head>
<body>
<center>
    <form action="{{url('admin/update/'.$AdminInfo->admin_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <table>
            <tr>
                <td>管理员账号</td>
                <td><input type="text" name="admin_user" value="{{$AdminInfo->admin_user}}"><b style="color:red">{{ $errors->first('admin_user') }}
                    </b></td>
            </tr>
            <tr>
                <td>手机号</td>
                <td><input type="tel" name="admin_tel" value="{{$AdminInfo->admin_tel}}"><b style="color:red"></b></td>
            </tr>
            <tr>
                <td>邮箱</td>
                <td><input type="email" name="admin_email" value="{{$AdminInfo->admin_email}}"><b style="color:red"></b></td>
            </tr>
            <tr>
                <td>头像</td>
                <td><img src="{{env('UPLOAD_URL')}}{{$AdminInfo->admin_photo}}" width="50" height="50">
                    <input type="file" name="admin_photo"></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="button" value="修改"></td>
            </tr>
        </table>
    </form>
</body>
</html>
<script src="/jquery.min.js"></script>
<script>
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $(function(){
        var admin_id={{$AdminInfo->admin_id}};
        $(document).on('click','input[type="button"]',function(){
            $('input[name="admin_user"]').next().html('');
            var admin_user=$('input[name="admin_user"]').val();
            var flag=true;
            var reg=/^[\u4e00-\u9fa5a-zA-Z0-9_]+$/;
            if(!reg.test(admin_user)){
                $('input[name="admin_user"]').next().html('管理员账号必须由中文或者数字字母下划线组成');
                return false;
            }
            $.ajax({
                url:'/admin/checkOnly',
                data:{admin_user:admin_user,admin_id:admin_id},
                type:'post',
                dataType:'json',
                async:false,
                success:function(res){
                    if(res.code==2){
                        $('input[name="admin_user"]').next().html('管理员账号已存在');
                        flag=false;
                    }
                }
            })
            if(!flag){
                return false;
            }
            $('input[name="admin_tel"]').next().html('');
            var admin_tel=$('input[name="admin_tel"]').val();
            var reg=/^1[3,5,8,9]\d{9}$/;
            if(!reg.test(admin_tel)){
                $('input[name="admin_tel"]').next().html('手机号有误');
                return false;
            }
            $('input[name="admin_email"]').next().html('');
            var admin_email=$('input[name="admin_email"]').val();
            var reg=/^[a-zA-Z0-9]{5,}@[0-9a-zA-Z]{2,4}(\.)com$/;
            if(!reg.test(admin_email)){
                $('input[name="admin_email"]').next().html('邮箱有误');
                return false;
            }
            $('form').submit();
        })
        $(document).on('blur','input[name="admin_user"]',function(){
            $(this).next().html('');
            var admin_user=$(this).val();
            var reg=/^[\u4e00-\u9fa5a-zA-Z0-9_]+$/;
            if(!reg.test(admin_user)){
                $(this).next().html('管理员账号必须由中文或者数字字母下划线组成');
                return false;
            }
            $.ajax({
                url:'/admin/checkOnly',
                data:{admin_user:admin_user,admin_id:admin_id},
                type:'post',
                dataType:'json',
                success:function(res){
                    if(res.code==2){
                        $('input[name="admin_user"]').next().html('管理员账号已存在');
                    }
                }
            })
        })
        $(document).on('blur','input[name="admin_tel"]',function(){
            $(this).next().html('');
            var admin_tel=$(this).val();
            var reg=/^1[3,5,8,9]\d{9}$/;
            if(!reg.test(admin_tel)){
                $(this).next().html('手机号有误');
            }
        })
        $(document).on('blur','input[name="admin_email"]',function(){
            $(this).next().html('');
            var admin_email=$(this).val();
            var reg=/^[a-zA-Z0-9]{5,}@[0-9a-zA-Z]{2,4}(\.)com$/;
            if(!reg.test(admin_email)){
                $(this).next().html('邮箱有误');
            }
        })
    })
</script>