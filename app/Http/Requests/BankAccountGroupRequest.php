<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountGroupRequest extends FormRequest
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
            'bank_holder_id' => 'required'
//            'bank_id' => 'exists:bank_account_group,bank_id'
        ];
    }

    public function messages()
    {
        return [
          'name.required' => 'Please Input Name Account Group',
          'name.min' => 'Name is Minimum 2 character'
        ];
    }
}
