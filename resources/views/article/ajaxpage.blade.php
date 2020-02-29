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