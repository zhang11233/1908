<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
//use Validator;
use DB;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreStudentPost;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $s_class=request()->s_class??'';
        $s_name=request()->s_name??'';
        $where=[];
        if($s_name){
            $where[]=['s_name','like',"%".$s_name."%"];
        }
        if($s_class){
            $where[]=['s_class','like',"%".$s_class."%"];
        }
        $pagesize=config('app.pagesize');
        $data=Student::where($where)->paginate($pagesize);
        return view('student.index',['data'=>$data,'s_name'=>$s_name,'s_class'=>$s_class]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    //public function store(StoreStudentPost $request)
    {
        //
        $request->validate([
            's_name'=>'unique:student|regex:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_]{2,12}$/u',
            's_sex'=>'required|numeric',
            's_performance'=>'required|numeric|between:0,100',
        ],[
            's_name.unique'=>'学生姓名已存在',
            's_name.regex'=>'学生姓名可以是中文数字字母下划线组成并且2到12位',
            's_sex.required'=>'学生性别不能为空',
            's_sex.numberic'=>'学生性别必须是数字类型',
            's_performance.required'=>'学生成绩不能为空',
            's_performance.numberic'=>'学生成绩必须是数字类型',
            's_performance.between'=>'学生成绩有误',
        ]);
        $data=$request->except('_token');
        if ($request->hasFile('s_photo')) {
            $data['s_photo']=$this->upload('s_photo');
        }
        $res=Student::create($data);
        if($res){
            return redirect('/student/index');
        }
    }

    public function upload($filename){
        if (request()->file($filename)->isValid()) {
            $photo = request()->file($filename);
            $store_result = $photo->store('upload');
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data=Student::find($id);
        return view('student.edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
   // public function update(StoreStudentPost $request, $id)
    {
        //
        $request->validate([
            's_name'=>['regex:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_]{2,12}$/u',
                        Rule::unique('student')->ignore($id,'s_id'),
            ],
            's_sex'=>'required|numeric',
            's_performance'=>'required|numeric|between:0,100',
        ],[
            's_name.unique'=>'学生姓名已存在',
            's_name.regex'=>'学生姓名可以是中文数字字母下划线组成并且2到12位',
            's_sex.required'=>'学生性别不能为空',
            's_sex.numberic'=>'学生性别必须是数字类型',
            's_performance.required'=>'学生成绩不能为空',
            's_performance.numberic'=>'学生成绩必须是数字类型',
            's_performance.between'=>'学生成绩有误',
        ]);
        $data=$request->except('_token');
       // DB::connection()->enableQueryLog();
        $res=Student::where('s_id',$id)->update($data);
       // dd(DB::getQueryLog());
        if($res!==false){
            return redirect('/student/index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $res=Student::destroy($id);
        if($res){
            return redirect('/student/index');
        }
    }
}
