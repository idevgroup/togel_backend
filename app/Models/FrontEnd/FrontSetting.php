<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;
use DB;
class FrontSetting extends Model
{
   
    const TBL_ACCOUNT_LIMIT = 'bank_account_group';

   static function getSettingBankLimit($bkid){
       $query =DB::table(self::TBL_ACCOUNT_LIMIT)->where('bank_id',$bkid)->where('status',1)->get();
       return $query;
    }
}
