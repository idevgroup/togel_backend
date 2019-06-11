<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SoftwareRequest extends FormRequest
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
            'name' => 'required|min:4',
            'slug' => 'required|min:1|unique:software,slug,'.$this->segment(3).',id',
            'filepath' => 'required'
        ];
    }
    public function messages(){

        return [
            'name.required' => 'Please input software name',
            'name.unique' => 'The software name as already been taken',
            'slug.required' => 'Please input slug',
            'filepath.required' => 'Please choose file or input file'
        ];
    }
}
