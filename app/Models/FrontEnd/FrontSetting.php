<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;
use DB;
class FrontSetting extends Model
{
   
    const TBL_ACCOUNT_LIMIT = '';

    public function getSettingBankLimit(){
       $query =DB::table(self::TBL_ACCOUNT_LIMIT)->where('status',1);
    }
}
