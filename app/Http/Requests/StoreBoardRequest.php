<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoardRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required',
            'title' => 'required',
            'content' => 'required',
            'file' => 'nullable',
//            'file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'notice_flag' => 'nullable',
            //
        ];
    }

    function messages()
    {
        return [
//            'content.required' => '내용을 입력해주세요',
//            'file.*.mimes' => '이 확장자를 가진 파일은 업로드할 수 없습니다.',
        ];
    }




}
