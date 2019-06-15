<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
            'txtslug' => 'required|min:1|unique:product,slug,'.$this->segment(3).',id'
        ];
    }

    public function messages()
    {
        return [
            'txtname.required' => 'Please input Product Name',
            'txtname.unique' => 'The Product name as already been taken',
            'txtslug.required' => 'Please input slug'
        ];
    }
}
