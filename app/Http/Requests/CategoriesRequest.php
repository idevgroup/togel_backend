<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
           'txtname'=> 'required|min:2',
           'txtslug' => 'required|min:1|unique:category,slug,'.$this->segment(3).',id',
        ];
    }
     public function messages(){
        
         return [
           'txtname.required' => 'Please input category name',
           'txtname.unique' => 'The Category name as already been taken',
           'txtslug.required' => 'Please input slug'  
         ];
    }
}
