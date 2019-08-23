<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuSettingRequest extends FormRequest
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
            'name' => 'required|unique:menu_setting,name,'.$this->segment(3).',id',
            'url' => 'unique:menu_setting,url,'.$this->segment(3).',id',
            'alias' => 'unique:menu_setting,alias,'.$this->segment(3).',id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please input name'
        ];
    }
}
