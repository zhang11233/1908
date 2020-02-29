<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bootstrap 实例 - 水平表单</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
<center><h1>编辑外来务工人员</h1></center>
<form class="form-horizontal" role="form" method="post" action="{{url('/people/update/'.$data->p_id)}}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">名字</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="{{$data->username}}" name="username" id="firstname"
                   placeholder="请输入名字">
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">年龄</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="{{$data->age}}" name="age" id="firstname"
                   placeholder="请输入年龄">
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">身份证号</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="{{$data->card}}" name="card" id="lastname"
                   placeholder="请输入身份证号">
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">是否是湖北人</label>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="is_hubei" value="1" @if($data->is_hubei==1) checked @endif>是
        <input type="radio" name="is_hubei" value="2" @if($data->is_hubei==2) checked @endif>否
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">头像</label>
        <div class="col-sm-8">
            <img src="{{env('UPLOAD_URL')}}{{$data->head}}">
            <input type="file" name="head" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">修改</button>
        </div>
    </div>
</form>

</body>
</html>