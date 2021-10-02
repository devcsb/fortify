<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBoardRequest extends FormRequest
{

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
            'file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'notice_flag' => 'nullable',
            //
        ];
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
