<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<center>
<form action="{{url('goods/store')}}" method="post" enctype="multipart/form-data">
    @csrf
<table>
    <tr>
        <td>商品名称</td>
        <td><input type="text" name="goods_name"><b style="color:red">{{ $errors->first('goods_name') }}</b></td>
    </tr>
    <tr>
        <td>商品货号</td>
        <td><input type="text" name="goods_item"><b style="color:red">{{ $errors->first('goods_item') }}</b></td>
    </tr>
    <tr>
        <td>商品价格</td>
        <td><input type="text" name="goods_price"><b style="color:red">{{ $errors->first('goods_price') }}</b></td>
    </tr>
    <tr>
        <td>商品缩略图</td>
        <td><input type="file" name="goods_img"></td>
    </tr>
    <tr>
        <td>商品库存</td>
        <td><input type="text" name="goods_num"><b style="color:red">{{ $errors->first('goods_num') }}</b></td>
    </tr>
    <tr>
        <td>是否精品</td>
        <td><input type="radio" name="is_best" value="1" checked>是
            <input type="radio" name="is_best" value="2">否
        </td>
    </tr>
    <tr>
        <td>是否热卖</td>
        <td><input type="radio" name="is_hot" value="1" checked>是
            <input type="radio" name="is_hot" value="2">否</td>
    </tr>
    <tr>
        <td>是否上架</td>
        <td><input type="radio" name="is_up" value="1" checked>是
            <input type="radio" name="is_up" value="2">否</td>
    </tr>
    <tr>
        <td>商品详情</td>
        <td><textarea name="goods_detail" cols="30" rows="10"></textarea></td>
    </tr>
    <tr>
        <td>商品相册</td>
        <td><input type="file" name="goods_imgs[]" multiple="multiple"></td>
    </tr>
    <tr>
        <td>品牌</td>
        <td><select name="b_id">
                <option value="">--请选择--</option>
                @foreach($brandInfo as $v)
                <option value="{{$v->b_id}}">{{$v->b_name}}</option>
                @endforeach
            </select></td>
    </tr>
    <tr>
        <td>分类</td>
        <td><select name="cate_id">
                <option value="">--请选择--</option>
                @foreach($cateInfo as $v)
                <option value="{{$v->cate_id}}">{!! str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$v->level*2.5) !!}{{$v->cate_name}}</option>
                @endforeach
            </select>
        </td>
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
    $.ajaxSetup({headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $(function(){
        $(document).on('click','input[type="button"]',function(){
            $('input[name="goods_name"]').next().html('');
            var flag=true;
            var goods_name=$('input[name="goods_name"]').val();
            var reg=/^[\u4e00-\u9fa5]+$/;
            if(!reg.test(goods_name)){
                $('input[name="goods_name"]').next().html('商品名称必须为中文');
                return false;
            }
            $.ajax({
                url:'/goods/checkOnly',
                data:{goods_name:goods_name},
                type:'post',
                dataType:'json',
                async:false,
                success:function(res){
                    if(res.code==2){
                        $('input[name="goods_name"]').next().html('商品名称已存在');
                        flag=false;
                    }
                }
            })
            if(!flag){
                return false;
            }
            $('input[name="goods_item"]').next().html('');
            var goods_item=$('input[name="goods_item"]').val();
            var reg=/^[a-z]{4}\d{13}$/;
            if(!reg.test(goods_item)){
                $('input[name="goods_item"]').next().html('商品货号必须由4位字母13位数字组成');
                return false;
            }
            $('input[name="goods_price"]').next().html('');
            var goods_price= $('input[name="goods_price"]').val();
            var reg=/^\d+.\d{2}$/;
            if(!reg.test(goods_price)){
               $('input[name="goods_price"]').next().html('商品价格必须由数字组成');
                return false;
            }
            $('input[name="goods_num"]').next().html('');
            var goods_num= $('input[name="goods_num"]').val();
            var reg=/^\d+$/;
            if(!reg.test(goods_num)){
                $('input[name="goods_num"]').next().html('商品库存必须由数字组成');
                return false;
            }
            $('form').submit();
        });
        $(document).on('blur','input[name="goods_name"]',function(){
           $(this).next().html('');
           var goods_name=$(this).val();
           var reg=/^[\u4e00-\u9fa5]+$/;
           if(!reg.test(goods_name)){
               $(this).next().html('商品名称必须为中文');
               return false;
           }
            $.ajax({
                url:'/goods/checkOnly',
                data:{goods_name:goods_name},
                type:'post',
                dataType:'json',
                success:function(res){
                   if(res.code==2){
                       $('input[name="goods_name"]').next().html('商品名称已存在');
                   }
                }
            })
        })
        $(document).on('blur','input[name="goods_item"]',function(){
            $(this).next().html('');
            var goods_item=$(this).val();
            var reg=/^[a-z]{4}\d{13}$/;
            if(!reg.test(goods_item)){
                $(this).next().html('商品货号必须由4位字母13位数字组成');
            }
        })
        $(document).on('blur','input[name="goods_price"]',function(){
            $(this).next().html('');
            var goods_price=$(this).val();
            var reg=/^\d+.\d{2}$/;
            if(!reg.test(goods_price)){
                $(this).next().html('商品价格必须由数字组成');
            }
        })
        $(document).on('blur','input[name="goods_num"]',function(){
            $(this).next().html('');
            var goods_num=$(this).val();
            var reg=/^\d+$/;
            if(!reg.test(goods_num)){
                $(this).next().html('商品库存必须由数字组成');
            }
        })
    })
</script>