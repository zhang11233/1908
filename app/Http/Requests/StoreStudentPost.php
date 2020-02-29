<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            's_name'=>'unique:student|regex:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_]{2,12}$/u',
            's_sex'=>'required|numeric',
            's_performance'=>'required|numeric|between:0,100',
        ];
    }
    public function messages(){
        return [
            's_name.unique'=>'学生姓名已存在',
            's_name.regex'=>'学生姓名可以是中文数字字母下划线组成并且2到12位',
            's_sex.required'=>'学生性别不能为空',
            's_sex.numberic'=>'学生性别必须是数字类型',
            's_performance.required'=>'学生成绩不能为空',
            's_performance.numberic'=>'学生成绩必须是数字类型',
            's_performance.between'=>'学生成绩有误',
        ];
    }
}
