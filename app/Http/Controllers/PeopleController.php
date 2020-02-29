<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\People;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
//use App\Http\Requests\StorePeoplePost;
class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page=request()->page??1;
        $username=request()->username??'';
        $where=[];
        if($username){
            $where[]=['username','like',"%".$username."%"];
        }
        // $data =Cache::get('data_'.$page.$username);
        $data = Redis::get('data_'.$page.'_'.$username);
        dump($data);
        if(!$data){
            echo "数据库";
            //ORM操作
            $pagesize=config('app.pagesize');
            $data=People::where($where)->orderby('p_id','desc')->paginate($pagesize);
            //Cache::put('data_'.$page.$username,$data,60*60*24);
            $data = serialize($data);//序例化
            Redis::setex('data_'.$page.'_'.$username,20,$data);
        }
        $data = unserialize($data);//反序例化
       return view('people.index',['data'=>$data,'username'=>$username]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('people.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    //public function store(StorePeoplePost $request)
    {
//        $request->validate([
//            'username' => 'required|unique:people|max:12|min:2',
//            'age' => 'required|integer|max:3|min:1',
//        ],[
//            'username.required'=>'名字不能为空',
//            'username.unique'=>'名字已存在',
//            'username.max'=>'名字不能超过12位',
//            'username.min'=>'名字不能少于2位',
//            'age.required'=>'年龄不能为空',
//            'age.integer'=>'年龄必须是数字',
//            'age.max'=>'年龄不能超过3位',
//            'age.min'=>'年龄不能少于1位',
//        ]);
        $data=$request->except('_token');
        $validator = Validator::make($data,[
            'username' => 'required|unique:people|max:12|min:2',
            'age' => 'required|integer|between:1,130',
            ],[
            'username.required'=>'名字不能为空',
            'username.unique'=>'名字已存在',
            'username.max'=>'名字不能超过12位',
            'username.min'=>'名字不能少于2位',
            'age.required'=>'年龄不能为空',
            'age.integer'=>'年龄必须是数字',
            'age.between'=>'年龄不合法',
           // 'age.min'=>'年龄不能少于1位',
        ]);
        if ($validator->fails()){
            return redirect('people/create')
                ->withErrors($validator)
                ->withInput();
        }
        //dd($data);
        if ($request->hasFile('head')) {
            //
            $data['head']=$this->upload('head');
        }
        //dd($data);
        $data['add_time']=time();
        //DB操作
        //$res=DB::table('people')->insert($data);
        //ORM操作
       // 1.
        $people=new People;
        $people->username=$data['username'];
        $people->age=$data['age'];
        $people->head=$data['head']??'';
        $people->card=$data['card'];
        $people->add_time=$data['add_time'];
        $people->is_hubei=$data['is_hubei'];
        $res=$people->save();
//        dd($res);返回true
        //2.
        //$res=People::create($data);
        //dd($res); 返回数据结果集
        //$res=People::insert($data);
        //dd($res);返回true
        if($res){
            return redirect('/people');//路由跳转
        }
    }


    public  function upload($filename)
    {
        if(request()->file($filename)->isValid()){
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
        $data=DB::table('people')->where('p_id',$id)->first();
        return view('people.edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data=$request->except('_token');
        if ($request->hasFile('head')) {
            //
            $data['head']=$this->upload('head');
        }
        $res=DB::table('people')->where('p_id',$id)->update($data);
        if($res!==false){
            return redirect('/people');
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
        $res=DB::table('people')->where('p_id',$id)->delete();
        if($res){
            return redirect('/people');
        }
    }
}
