<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameMarketRequest extends FormRequest
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
            'code' => 'required|min:2|max:8|unique:game_market,code'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Please input name',
            'name.required' => 'The name is can\'t null ',
            'name.min' => 'Game name is minimum 2 character',
            'code.required' => 'Please input Code Name',
            'code.max' => 'Code Name is maximum 4 character',
            'code.min' => 'Code Name is minimum 2 character'
        ];
    }
}
