<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankHolderRequest extends FormRequest
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
            'number' => 'required|numeric',
            'phone' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please Input Account Name',
            'number.required' => 'Please Input Account Number',
            'number.numeric' => 'Please Input Only number',
            'phone.required' => 'Please Input Phone Number',
            'phone.numeric' => 'Please Input Only number',
        ];
    }
}
