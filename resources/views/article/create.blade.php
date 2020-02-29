<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
<center>
<form action="{{url('/article/store')}}" method="post" enctype="multipart/form-data">
    @csrf
<table>
    <tr>
        <td>文章标题</td>
        <td><input type="text" name="a_title"><b style="color:red">{{$errors->first('a_title')}}</b></td>
    </tr>
    <tr>
        <td>文章分类</td>
        <td><select name="c_id">
                <option value="">--请选择--</option>
                @foreach($cateInfo as $k=>$v)
                <option value="{{$v->c_id}}">{{$v->c_name}}</option>
                @endforeach
            </select><b style="color:red">{{$errors->first('a_category')}}</b></td>
    </tr>
    <tr>
        <td>文章重要性</td>
        <td><input type="radio" name="a_important" value="1">普通
            <input type="radio" name="a_important" value="2">置顶<b style="color:red">{{$errors->first('a_important')}}</b>
        </td>
    </tr>
    <tr>
        <td>是否显示</td>
        <td><input type="radio" name="a_show" value="1">显示
            <input type="radio" name="a_show" value="2">不显示<b style="color:red">{{$errors->first('a_show')}}
        </td>
    </tr>
    <tr>
        <td>文章作者</td>
        <td><input type="text" name="a_author"><b style="color:red"></b></td>
    </tr>
    <tr>
        <td>作者email</td>
        <td><input type="text" name="a_email"></td>
    </tr>
    <tr>
        <td>关键字</td>
        <td><input type="text" name="a_keyword"></td>
    </tr>
    <tr>
        <td>网页描述</td>
        <td><textarea name="a_detail" cols="30" rows="10"></textarea></td>
    </tr>
    <tr>
        <td>上传文件</td>
        <td><input type="file" name="a_photo"></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="button" value="添加"></td>
    </tr>
</table>
</form>
</body>
</html>
<script src="/jquery.min.js"></script>
<script>
    $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});//get不需要表单令牌,只有post才需要
    $(function(){
        $(document).on('click','input[type="button"]',function(){
             //标题验证
            $('input[name="a_title"]').next().html('');
            var titleflag=true;
            var title=$('input[name="a_title"]').val();
            var reg=/^[\u4e00-\u9fa5a-zA-Z0-9_]+$/;
            if(!reg.test(title)){
                $('input[name="a_title"]').next('b').html('文章标题可以是中文字母数字下划线组成');
                return false;
            }
            $.ajax({
                type:'post',
                url:'/article/checkOnly',
                data:{title:title},
                dataType:'json',
                async:false,
                success:function(res){
                    if(res.count>0){
                        $('input[name="a_title"]').next('b').html('文章标题已存在');
                        titleflag=false;
                    }
                }
            });
            //console.log(titleflag);
            if(!titleflag){
                return false;
            }
            // //作者验证
            // $('input[name="a_author"]').next().html('');
            // var author= $('input[name="a_author"]').val();
            // var reg=/^[\u4e00-\u9fa5a-zA-Z0-9_]+$/;
            // if(!reg.test(author)){
            //     $('input[name="a_author"]').next().html('文章标题可以是中文字母数字下划线组成');
            //     return false;
            // }
            //表单提交
            $('form').submit();
        })
        // $(document).on('blur','input[name="a_author"]',function(){
        //     $(this).next().html('');
        //     var author=$(this).val();
        //     var reg=/^[\u4e00-\u9fa5a-zA-Z0-9_]+$/;
        //     if(!reg.test(author)){
        //         $(this).next().html('文章标题可以是中文字母数字下划线组成');
        //         return false;
        //     }
        // })
        $(document).on('blur','input[name="a_title"]',function(){
            $(this).next('b').html('');
            var title=$(this).val();
            var reg=/^[\u4e00-\u9fa5a-zA-Z0-9_]+$/;
            if(!reg.test(title)){
                $(this).next('b').html('文章标题可以是中文字母数字下划线组成');
                return false;
            }
            $.ajax({
                type:'post',
                url:'/article/checkOnly',
                data:{title:title},
                dataType:'json',
                success:function(res){
                    if(res.count>0){
                        $('input[name="a_title"]').next('b').html('文章标题已存在');
                    }
                }
            })
        })
    })
</script>