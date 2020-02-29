<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
</head>
<body>
<form>
    请输入商品名称<input type="text" name="goods_name" value="{{$goods_name}}" placeholder="请输入商品名称">
    请选择品牌<select name="b_id">
        <option value="">--请选择--</option>
        @foreach($brandInfo as $v)
        <option value="{{$v->b_id}}" {{$v->b_id==$b_id?'selected':''}}>{{$v->b_name}}</option>
        @endforeach
    </select>
    <input type="submit" value="搜索">
</form>
<table border="1">
    <tr>
        <td>商品id</td>
        <td>商品名称</td>
        <td>商品货号</td>
        <td>商品价格</td>
        <td>商品库存</td>
        <td>商品缩略图</td>
        <td>是否上架</td>
        <td>是否热卖</td>
        <td>是否精品</td>
        <td>商品详情</td>
        <td>商品相册</td>
        <td>所属品牌</td>
        <td>所属分类</td>
        <td>操作</td>
    </tr>
    @foreach($AllInfo as $k=>$v)
    <tr goods_id="{{$v->goods_id}}">
        <td>{{$v->goods_id}}</td>
        <td>{{$v->goods_name}}</td>
        <td>{{$v->goods_item}}</td>
        <td>{{$v->goods_price}}</td>
        <td>{{$v->goods_num}}</td>
        <td>@if($v->goods_img)<img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}" width="50px" height="50px">@else无@endif</td>
        <td>{{$v->is_up==1?'√':'×'}}</td>
        <td>{{$v->is_hot==1?'√':'×'}}</td>
        <td>{{$v->is_best?'√':'×'}}</td>
        <td>{{$v->goods_detail}}</td>
        <td>@if($v->goods_imgs)
             @php $goods_imgs=explode('|',$v->goods_imgs)@endphp
             @foreach($goods_imgs as $vv)
                    <img src="{{env('UPLOAD_URL')}}{{$vv}}" width="50px" height="50px">
             @endforeach
            @endif
        </td>
        <td>{{$v->b_name}}</td>
        <td>{{$v->cate_name}}</td>
        <td><a href="javascript:;" class="del">删除</a>
            <a href="{{url('goods/edit/'.$v->goods_id)}}">修改</a>
        </td>
    </tr>
        @endforeach
    </table>
{{$AllInfo->appends(['goods_name'=>$goods_name])->links()}}
</body>
</html>
<script src="/jquery.min.js"></script>
<script>
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $(function(){
        $(document).on('click','.del',function(){
            var _this=$(this);
            var goods_id=$(this).parents('tr').attr('goods_id');
            if(window.confirm('是否确认删除?')){
                $.get(
                        "/goods/destroy",
                        {goods_id:goods_id},
                        function(res){
                           if(res.code==1){
                               _this.parents('tr').remove();
                               location.href='/goods/index';
                           }
                        },
                        'json'
                )
            }
        })
    })
</script>