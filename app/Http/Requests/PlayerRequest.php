<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerRequest extends FormRequest {

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

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'txtname' => 'required|string|min:3',
                        'txtusername' => 'required|min:3|max:255|unique:players,reg_username',
                        'txtpassword' => 'min:6|required_with:txtconfirm|same:txtconfirm',
                        'txtconfirm' => 'min:6',
                        'txtemail' => 'required|string|email|max:255|unique:players,reg_email',
                        'txtdob' => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d')
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'txtname' => 'required|string|min:3',
                        'txtusername' => 'required|min:3|max:255|unique:players,reg_username,' . $this->segment(3) . ',id',
                        'txtemail' => 'required|string|email|max:255|unique:players,reg_email,' . $this->segment(3) . ',id',
                        'txtdob' => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                        'txtpassword' => 'sometimes|same:txtconfirm',
                    ];
                }
            default:break;
        }
    }

}
