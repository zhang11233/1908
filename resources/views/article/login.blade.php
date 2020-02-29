<form action="{{url('/article/logindo')}}" method="post">
	@csrf
	{{session('msg')}}
	用户名:<input type="text" name="users_name"><br>
	密码:<input type="password" name="users_pwd"><br>
	<input type="submit" value="添加">
</form>