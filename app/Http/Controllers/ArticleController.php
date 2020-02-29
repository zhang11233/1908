<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Article;
use App\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $page=request()->page??1;//接收当前页码
        $a_title=request()->a_title??'';//接收值
        $c_id=request()->c_id??'';//接收值
        $where=[];
        if($a_title){
            $where[]=['a_title','like',"%".$a_title."%"];
        }
        if($c_id){
            $where[]=['category.c_id','=',$c_id];
        }
        // Redis::flushall();//清除所有
        // Cache::flush();die;//清除所有
        //$cateInfo=Cache::get('cateInfo');//缓存中一表的值(取值)
        $cateInfo = Redis::get('cateInfo');
        // dump($cateInfo);
        if(!$cateInfo){//如果一表的缓存中没有值 就会走数据库
            echo "数据库";
            $cateInfo=Category::get();//查询一表中所有的数据
            //Cache::put('cateInfo',$cateInfo,60*5);//把一表的数据存入缓存 在指定缓存时间 60*5五分钟
            $cateInfo = serialize($cateInfo);//序例化
            Redis::setex('cateInfo',60,$cateInfo);
        }
        //反序例化结果集 将字符串转化为object对象
        $cateInfo = unserialize($cateInfo);

        // $data=Cache::get('data_'.$page.'_'.$a_title.'_'.$c_id);//缓存中多表的值 将指定页码和搜索条件取值
        $data = Redis::get('data_'.$page.'_'.$a_title.'_'.$c_id);
        // dump($data);
        if(!$data){//如果多表中没有缓存的值 就会走数据库
            echo '数据库';
            $pagesize=config('app.pagesize');//获取偏移量
            $data=Article::leftJoin('category','article.c_id','=','category.c_id')->where($where)->paginate($pagesize);//两表联查
            //Cache::put('data_'.$page.'_'.$a_title.'_'.$c_id,$data,60*5);//把多表的数据存入缓存 给指定时间
            $data = serialize($data);//序例化
            Redis::setex('data_'.$page.'_'.$a_title.'_'.$c_id,60,$data);
        }
        //反序例化结果集 将字符串转化为object对象
        $data = unserialize($data);
        //ajax分页 判断是否是ajax请求
        if(request()->ajax()){
            return view('article.ajaxpage',['data'=>$data,'cateInfo'=>$cateInfo,'a_title'=>$a_title,'c_id'=>$c_id]);
        }
        return view('article.index',['data'=>$data,'cateInfo'=>$cateInfo,'a_title'=>$a_title,'c_id'=>$c_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cateInfo=Category::get();
        return view('article.create',['cateInfo'=>$cateInfo]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate(
            [
                'a_title' => 'unique:article|regex:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_]+$/u',
                'c_id' => 'required',
                'a_important' => 'required',
                'a_show' => 'required',
            ],[
                'a_title.unique'=>'文章标题已存在',
                'a_title.regex'=>'文章标题可以是中文字母数字下划线组成',
                'c_id.required'=>'文章分类不能为空',
                'a_important.required'=>'文章重要性不能为空',
                'a_show.required'=>'是否显示不能为空',
        ]);
        $data=$request->except('_token');
        if ($request->hasFile('a_photo')) {
            //
            $data['a_photo']=upload('a_photo');
             }
            $res=Article::create($data);
        if($res){
            return redirect('/article/index');
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
     *预览详情页
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //访问量
        $count = Redis::setnx('num_'.$id,1);
        if (!$count) {
            $count = Redis::incr('num_'.$id);
        }
        $crticle = Article::find($id);
        return view('article.show',['crticle'=>$crticle,'count'=>$count]);
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
        $cateInfo=Category::get();
        $data=Article::find($id);
        return view('article.edit',['data'=>$data,'cateInfo'=>$cateInfo]);
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
        $request->validate(
            [
                'a_title' => [
                    'regex:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_]+$/u',
                     Rule::unique('article')->ignore($id,'a_id'),
                    ],
                'c_id' => 'required',
                'a_important' => 'required',
                'a_show' => 'required',
            ],[
            'a_title.unique'=>'文章标题已存在',
            'a_title.regex'=>'文章标题可以是中文字母数字下划线组成',
            'c_id.required'=>'文章分类不能为空',
            'a_important.required'=>'文章重要性不能为空',
            'a_show.required'=>'是否显示不能为空',
        ]);
        $data=$request->except('_token');
        if ($request->hasFile('a_photo')) {
            //
            $data['a_photo']=$this->upload('a_photo');
        }
        $res=Article::where('a_id',$id)->update($data);
        if($res!==false){
            return redirect('/article/index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
        $id=request()->a_id;
        $res=Article::destroy($id);
        if($res){
            echo json_encode(['code'=>'0000','msg'=>'ok']);
        }
    }
    /**
     *js验证唯一性
     */
    public function checkOnly(){
        $title=request()->title;
        $where=[];
        if($title){
            $where[]=['a_title','=',$title];
        }
        $a_id=request()->a_id;
        if($a_id){
            $where[]=['a_id','!=',$a_id];
        }
        $count=Article::where($where)->count();
        echo json_encode(['code'=>'00000','msg'=>'ok','count'=>$count]);die;
    }
}


