<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center><h1>编辑学生页面</h1>
    @if($errors->any())
    <div class="alert alert-danger">
    <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}
    </li>
    @endforeach
    </ul>
    </div>
    @endif
    <form action="{{url('/student/update',$data->s_id)}}" method="post">
        @csrf
        <table>
            <tr>
                <td>学生姓名:</td>
                <td><input type="text" name="s_name" value="{{$data->s_name}}"></td>
            </tr>
            <tr>
                <td>学生性别:</td>
                <td><input type="radio" name="s_sex" value="1" @if($data->s_sex==1) checked @endif>男
                    <input type="radio" name="s_sex" value="2" @if($data->s_sex==2) checked @endif>女
                </td>
            </tr>
            <tr>
                <td>班级:</td>
                <td><input type="text" name="s_class" value="{{$data->s_class}}"></td>
            </tr>
            <tr>
                <td>成绩:</td>
                <td><input type="text" name="s_performance" value="{{$data->s_performance}}"></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="修改"></td>
            </tr>
        </table>
    </form>
</body>
</html>