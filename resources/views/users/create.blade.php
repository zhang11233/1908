<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center>
    <form action="{{url('store')}}" method="post">
        @csrf
    <table>
        <tr>
            <td>用户名</td>
            <td><input type="text" name="users_name"></td>
        </tr>
        <tr>
            <td>用户密码</td>
            <td><input type="password" name="users_pwd"></td>
        </tr>
        <tr>
            <td align="center" colspan="2"><input type="submit" value="添加"></td>
        </tr>
    </table>
    </form>
</body>
</html>