<?php
namespace App\Libraries;
use App\Models\BackEnd\GeneralSetting;
use Config;
class CommonFunction {
    static function _CurrencyFormat($number){
        $getArrayCurrency = Config('sysconfig.currency_code');
        $getSettingCurrency = GeneralSetting::first();
        $getCurrency = $getArrayCurrency[$getSettingCurrency->currency];
        if(is_numeric($number)){
            return $getCurrency['symbol'].' '.number_format($number,2);
        }else{
            return '0';
        }
    }
}
