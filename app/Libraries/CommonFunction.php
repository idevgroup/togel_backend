<?php
namespace App\Libraries;

class CommonFunction {
    static function _CurrencyFormat($number){
        if(is_numeric($number)){
            return number_format($number,2);
        }else{
            return 'NULL';
        }
    }
}
