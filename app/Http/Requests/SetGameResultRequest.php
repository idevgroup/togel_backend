<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\BackEnd\SiteLock;
use Carbon\Carbon;
class SetGameResultRequest extends FormRequest
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
       $marketCode = request()->input('cbomarket');
       $getSiteLock = SiteLock::getAllRecord(0)->where('market',$marketCode)->first();
       request()->merge(['currenttime' => Carbon::now()->toTimeString(),'lock_from' =>$getSiteLock->lock_from]);
       \Log::info($getSiteLock);
        return [
            'cbomarket' => 'required|not_in:0',
            'txtresult' => 'required|digits:4|min:4',
            'currenttime' => 'required|'
        ];
    }
}
