<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class SiteLock extends Model
{
    protected $table = 'site_lock';
//    public function bank_holder() {
//        return $this->belongsTo('App\Models\BackEnd\BankHolder');
//    }
    static function getAllRecord($is_trashed)
    {
        return self::where('is_trashed', $is_trashed)->orderBy('lock_id', 'ASC');
    }
}
