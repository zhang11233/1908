<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Document</title>
</head>
<body>
<center>
<form action="{{url('cate/store')}}" method="post">
    @csrf
<table>
    <tr>
        <td>分类名称:</td>
        <td><input type="text" name="cate_name" placeholder="请输入分类名称"><b style="color:red">{{$errors->first('cate_name')}}
            </b></td>
    </tr>
    <tr>
        <td>父级分类:</td>
        <td><select name="pid">
                <option value="">顶级分类</option>
                @foreach($cateInfo as $k=>$v)
                <option value="{{$v->cate_id}}">{!! str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$v->level*2.5)!!}{{$v->cate_name}}</option>
                @endforeach
            </select></td>
    </tr>
    <tr>
        <td>分类描述:</td>
        <td><textarea name="cate_detail" cols="30" rows="10"></textarea></td>
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
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') } });
    $(function(){
        $(document).on('click','input[type="button"]',function(){
            var flag=true;
            $('input[name="cate_name"]').next().html('');
            var cate_name= $('input[name="cate_name"]').val();
            var reg=/^[\u4e00-\u9fa5]+$/;
            if(!reg.test(cate_name)){
                $('input[name="cate_name"]').next().html('分类名称必须是中文');
                return false;
            }
            $.ajax({
                url:'/cate/checkOnly',
                data:{cate_name:cate_name},
                type:'post',
                dataType:'json',
                async:false,
                success:function(res){
                    if(res.count>0){
                        $('input[name="cate_name"]').next().html('分类名称已存在');
                        flag=false;
                    }
                }
            });
            if(!flag){
                return false;
            }
            $('form').submit();
        });
       $(document).on('blur','input[name="cate_name"]',function(){
            $(this).next().html('');
            var cate_name=$(this).val();
            var reg=/^[\u4e00-\u9fa5]+$/;
            if(!reg.test(cate_name)){
               $(this).next().html('分类名称必须是中文');
                return false;
            }
           $.ajax({
               url:'/cate/checkOnly',
               data:{cate_name:cate_name},
               type:'post',
               dataType:'json',
               success:function(res){
                   if(res.count>0){
                       $('input[name="cate_name"]').next().html('分类名称已存在');
                   }
               }
           })
       })
    })
</script>