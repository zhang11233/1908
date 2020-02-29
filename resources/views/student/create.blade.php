<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center><h1>添加学生页面</h1>
{{--@if($errors->any())--}}
{{--<div class="alert alert-danger">--}}
{{--<ul>--}}
{{--@foreach ($errors->all() as $error)--}}
{{--<li>{{ $error }}--}}
{{--</li>--}}
{{--@endforeach--}}
{{--</ul>--}}
{{--</div>--}}
{{--@endif--}}
    <form action="{{url('/student/store')}}" method="post" enctype="multipart/form-data" id="myform">
    @csrf
    <table>
        <tr>
            <td>学生姓名:</td>
            <td><input type="text" name="s_name" id="s_name"><a style="color:red">{{ $errors->first('s_name') }}</a></td>

        </tr>
        <tr>
            <td>学生性别:</td>
            <td><input type="radio" name="s_sex" value="1" checked>男
                <input type="radio" name="s_sex" value="2">女 <a style="color:red">{{ $errors->first('s_sex') }}</a>

            </td>
        </tr>
        <tr>
            <td>班级:</td>
            <td><input type="text" name="s_class"  id="s_class"></td>
        </tr>
        <tr>
            <td>成绩:</td>
            <td><input type="text" name="s_performance"  id="s_performance"><a style="color:red">{{ $errors->first('s_performance') }}</a></td>
        </tr>
        <tr>
            <td>学生照片</td>
            <td><input type="file" name="s_photo"></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="添加"></td>
        </tr>
    </table>
</form>
</body>
</html>
<script src="/jquery.min.js"></script>
<script>
    $(function(){
        $(document).on('blur','#s_name',function(){
            var s_name=$("#s_name").val();
            if(s_name==''){
                alert('学生姓名必填');
                return false;
            }
            var reg=/^[\u4e00-\u9fa5a-zA-Z0-9_]{2,12}$/;
            if(!reg.test(s_name)) {
                alert('学生姓名可以是中文数字字母下划线组成并且2到12位');
                return false;
            }
        });
        $(document).on('blur','#s_class',function(){
            var s_class=$("#s_class").val();
            if(s_class==''){
                alert('学生班级不能为空');
                return false;
            }
            var reg=/^[0-9a-zA-Z]+$/;
            if(!reg.test(s_class)){
                alert('学生班级可以是数字字母组成');
                return false;
            }
        })
        $(document).on('blur','#s_performance',function(){
            var s_performance=$("#s_performance").val();
            if(s_performance==''){
                alert('学生成绩不能为空');
                return false;
            }
            var reg=/^[\d]{1,3}$/;
            if(!reg.test(s_performance)){
                alert('学生成绩只能是数字并且0到3位');
                return false;
            }
            if(parseInt(s_performance)>100){
                alert('学生成绩有误');
                return false;
            }
            if(parseInt(s_performance)<0){
                alert('学生成绩有误');
                return false;
            }
        })
        $(document).on('submit','#myform',function(){
            var s_name=$("#s_name").val();
            if(s_name==''){
                alert('学生姓名必填');
                return false;
            }
            var reg=/^[\u4e00-\u9fa5a-zA-Z0-9_]{2,12}$/;
            if(!reg.test(s_name)) {
                alert('学生姓名可以是中文数字字母下划线组成并且2到12位');
                return false;
            }
            var s_class=$("#s_class").val();
            if(s_class==''){
                alert('学生班级不能为空');
                return false;
            }
            var reg=/^[0-9a-zA-Z]+$/;
            if(!reg.test(s_class)){
                alert('学生班级可以是数字字母组成');
                return false;
            }
            var s_performance=$("#s_performance").val();
            if(s_performance==''){
                alert('学生成绩不能为空');
                return false;
            }
            var reg=/^[\d]{1,3}$/;
            if(!reg.test(s_performance)){
                alert('学生成绩只能是数字并且0到3位');
                return false;
            }
            if(parseInt(s_performance)>100){
                alert('学生成绩有误');
                return false;
            }
            if(parseInt(s_performance)<0){
                alert('学生成绩有误');
                return false;
            }
        })
    })
</script>