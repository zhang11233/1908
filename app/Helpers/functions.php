<?php
function GetcateInfo($data,$pid=0,$level=1){
    if(!$data){
        return;
    }
    static $arr=[];
    foreach($data as $k=>$v){
        if($v->pid==$pid){
            $v->level=$level;
            $arr[]=$v;
            GetcateInfo($data,$v->cate_id,$level+1);
        }
    }
    return  $arr;
}
 function upload($filename){
    if (request()->file($filename)->isValid()) {
        $photo = request()->file($filename);
        $store_result = $photo->store('upload');
        return $store_result;
    }
    exit('未获取到上传文件或上传过程出错');
}

function Moreupload($filename){
    $photo=request()->file($filename);
    if(!is_array($photo)){
        return;
    }
    foreach($photo as $v){
        if($v->isValid()){
            $store_result[]=$v->store('upload');
        }
    }
    return $store_result;
}