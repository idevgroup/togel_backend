<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FrontEnd\Bank;
use Response;
use App\Models\FrontEnd\FrontSetting;
use Config;
use Illuminate\Support\Arr;

class FrontEndController extends Controller {

    public function getBank() {
        $getBankList = Bank::getAllRecord(0, 1)->get();
        return response($getBankList->jsonSerialize());
    }

    public function getSetting() {
        $getGeneralSetting = FrontSetting::getGeneralSetting();
        $getArrayCurrency = Config('sysconfig.currency_code');
        $getLocaleCode = $getArrayCurrency[$getGeneralSetting->currency];
        $setLocaleCode = isset($getLocaleCode['locale']) ? $getLocaleCode['locale'] : 'en';
        $setGeneralSetting = [
            'currency' => $getGeneralSetting->currency,
            'logo' => $getGeneralSetting->logo,
            'favicon' => $getGeneralSetting->icon,
            'timezone' => $getGeneralSetting->timezone,
            'locale' => $setLocaleCode
        ];


        return response()->json(['general' => $setGeneralSetting]);
    }

}
