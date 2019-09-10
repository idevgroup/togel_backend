<?php
namespace App\Libraries;
use App\Models\BackEnd\GeneralSetting;
use Config;
class CommonFunction {
    static function _CurrencyFormat($number,$is_currency=0){
        $getArrayCurrency = Config('sysconfig.currency_code');
        $getSettingCurrency = GeneralSetting::first();
        $getCurrency = $getArrayCurrency[$getSettingCurrency->currency];
        if(is_numeric($number)){
            if($is_currency == 0){
                return $getCurrency['symbol'].' '.number_format($number,2);
            }else{
                return number_format($number,2);
            }
        }else{
            return '0';
        }
    }
}
