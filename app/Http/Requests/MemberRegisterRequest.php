<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Recaptcha;
class MemberRegisterRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required|string|min:3',
            'username' => 'required|min:3|max:255|unique:players,reg_username',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'email' => 'required|string|email|max:255|unique:players,reg_email',
           // 'recaptcha' => ['required',new Recaptcha],
            'recaptcha' => 'required',
            'bank' => 'required',
            'accountid' => 'required|unique:player_banks,reg_account_number',
            'accountname' => 'required',            
        ];
    }

}
