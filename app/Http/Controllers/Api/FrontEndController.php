<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FrontEnd\Bank;
use Response;
use App\Models\FrontEnd\FrontSetting;
class FrontEndController extends Controller
{
    public function getBank(){
        $getBankList = Bank::getAllRecord(0, 1)->get();
        return response($getBankList->jsonSerialize());
    }
    public function getSetting(){
        $getGeneratSetting = FrontSetting::getGeneratSetting();
        \Log::info('working');
        return response()->json(['general' => $getGeneratSetting]);
    }
}
