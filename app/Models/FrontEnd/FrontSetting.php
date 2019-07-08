<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;
use DB;
class FrontSetting extends Model
{
   
    const TBL_ACCOUNT_LIMIT = 'bank_account_group';
    const BANK = 'bank';
    const LIMIT_WITHDRAW = 'transaction_limit';
    static function getSettingBankLimit($rowid){
       $query =DB::table(self::TBL_ACCOUNT_LIMIT)->join(self::BANK,self::TBL_ACCOUNT_LIMIT.'.bank_id','=',self::BANK.'.id')->where(self::TBL_ACCOUNT_LIMIT.'.id',$rowid)->where(self::TBL_ACCOUNT_LIMIT.'.status',1) ->select(self::TBL_ACCOUNT_LIMIT.'.*', self::BANK.'.bk_name')->first();
       return $query;
    }
    static function getBankOperator($bk_id){
          $query =DB::table(self::TBL_ACCOUNT_LIMIT)->where('bank_id',$bk_id)->where('status',1)->get();
       return $query;
    }
    static function getLimitWithdraw(){
        $query = DB::table(self::LIMIT_WITHDRAW)->where('id',1)->first();
        return $query;
    }
}
