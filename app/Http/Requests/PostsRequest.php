<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsRequest extends FormRequest
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
            'txtname' => 'required|min:4',
            'txtslug' => 'required|min:1|unique:post,slug,'.$this->segment(3).',id'
        ];
    }

    public function messages(){
         return [
             'txtname.required' => 'Please input Post Name',
             'txtname.unique' => 'The Post name as already been taken',
             'txtslug.required' => 'Please input slug'
         ];
    }
}
