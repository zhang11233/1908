<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeoplePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *是否授权
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
            'username' => 'required|unique:people|max:12|min:2',
            'age' => 'required|integer|max:3|min:1',
        ];
    }
    public function messages(){
        return [
            'username.required'=>'名字不能为空',
            'username.unique'=>'名字已存在',
            'username.max'=>'名字不能超过12位',
            'username.min'=>'名字不能少于2位',
            'age.required'=>'年龄不能为空',
            'age.integer'=>'年龄必须是数字',
            'age.max'=>'年龄不能超过3位',
            'age.min'=>'年龄不能少于1位',
        ];
    }
}
