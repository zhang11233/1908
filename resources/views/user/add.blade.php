<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
        <form action="{{route('do')}}" method="post">
            @csrf
            <input type="text" name="name">
            <input type="password" name="pwd">
            <input type="submit" value="注册">
        </form>
</body>
</html>