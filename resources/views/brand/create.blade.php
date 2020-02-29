<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center><h1>添加品牌页面</h1>
    <form action="{{url('/brand/store')}}" method="post" enctype="multipart/form-data">
        @csrf
    <table>
        <tr>
            <td>品牌名称</td>
            <td><input type="text" name="b_name"></td>
        </tr>
        <tr>
            <td>品牌LOGO</td>
            <td><input type="file" name="b_logo"></td>
        </tr>
        <tr>
            <td>品牌网址</td>
            <td><input type="text" name="b_url"></td>
        </tr>
        <tr>
            <td>品牌描述</td>
            <td><textarea name="b_intro" cols="30" rows="10"></textarea></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="添加"></td>
        </tr>
    </table>
    </form>
</body>
</html>