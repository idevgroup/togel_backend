<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;
use DB;

class FrontSetting extends Model {

    const TBL_ACCOUNT_LIMIT = 'bank_account_group';
    const TBL_BANK = 'bank';
    const TBL_LIMIT_WITHDRAW = 'transaction_limit';
    const TBL_BONUS_SETTING = 'regdep_bonus';
    const TBL_GENERAL_SETTING = 'general_setting';
    const TBL_SITE_LOCK = 'site_lock';
    static function getSettingBankLimit($rowid) {
        $query = DB::table(self::TBL_ACCOUNT_LIMIT)->join(self::TBL_BANK, self::TBL_ACCOUNT_LIMIT . '.bank_id', '=', self::TBL_BANK . '.id')->where(self::TBL_ACCOUNT_LIMIT . '.id', $rowid)->where(self::TBL_ACCOUNT_LIMIT . '.status', 1)->select(self::TBL_ACCOUNT_LIMIT . '.*', self::TBL_BANK . '.bk_name')->first();
        return $query;
    }

    static function getBankOperator($bk_id) {
        $query = DB::table(self::TBL_ACCOUNT_LIMIT)->where('bank_id', $bk_id)->where('status', 1)->get();
        return $query;
    }

    static function getLimitWithdraw() {
        $query = DB::table(self::TBL_LIMIT_WITHDRAW)->where('id', 1)->first();
        return $query;
    }

    static function getBonus() {
        $query = DB::table(self::TBL_BONUS_SETTING)->first();
        return $query;
    }
    static function getGeneralSetting(){
        $query = DB::table(self::TBL_GENERAL_SETTING)->first();
        return $query;
    }
    static function getSiteLock(){
        $query = DB::table(self::TBL_SITE_LOCK)->where('status',1)->get();
        return $query;
    }

}
