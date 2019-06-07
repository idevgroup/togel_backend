<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BanksRequest extends FormRequest
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
            'name' => 'required|min:2',
//            'bannerfile' => 'required',
        ];
    }

    public function messages()
    {
        return [
          'name.required' => 'Please input name',
//          'bannerfile.required' => 'Please choose image'
        ];
    }
}
