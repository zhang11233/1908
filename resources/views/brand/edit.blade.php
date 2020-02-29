<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center><h1>编辑品牌页面</h1>
    <form action="{{url('/brand/update/'.$data->b_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <table>
            <tr>
                <td>品牌名称</td>
                <td><input type="text" name="b_name" value="{{$data->b_name}}"></td>
            </tr>
            <tr>
                <td>品牌LOGO</td>
                <td><img src="{{env('UPLOAD_URL')}}{{$data->b_logo}}" width="50px" height="50px">
                    <input type="file" name="b_logo"></td>
            </tr>
            <tr>
                <td>品牌网址</td>
                <td><input type="text" name="b_url" value="{{$data->b_url}}"></td>
            </tr>
            <tr>
                <td>品牌描述</td>
                <td><textarea name="b_intro" cols="30" rows="10">{{$data->b_intro}}</textarea></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="修改"></td>
            </tr>
        </table>
    </form>
</body>
</html>