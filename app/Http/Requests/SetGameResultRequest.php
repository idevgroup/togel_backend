<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Validation\Factory as ValidationFactory;

class SetGameResultRequest extends FormRequest {

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->all()
                        ], 200)
        );
    }

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
            'cbomarket' => 'required|not_in:0',
            'txtresult' => 'required|digits:4|min:4',
            'currenttime' => 'required|before_or_equal:lock_to|after_or_equal:lock_from',
                // 'txtperiod' => 'required'
        ];
    }

    public function messages() {
        return [
            'cbomarket.required' => 'Please select market',
            'cbomarket.not_in' => 'Please select market',
            'txtresult.required' => 'Please input result',
            // 'txtperiod.required' => 'Please input period number',
            'txtresult.integer' => 'The result number must be integer',
            'txtresult.digits' => 'The result number must be at least 4 characters',
            'txtresult.min' => 'The result number must be 4 digits',
            'currenttime.after_or_equal' => 'The result market must between site lock setting',
            'currenttime.before_or_equal' => 'The result market must between site lock setting'
        ];
    }

}
