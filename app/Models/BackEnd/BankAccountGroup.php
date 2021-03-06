<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class BankAccountGroup extends Model
{
    protected $table = 'bank_account_group';
    public function bank() {
        return $this->hasOne('App\Models\BackEnd\Banks', 'id', 'bank_id');
    }
    public function bank_holder() {
        return $this->belongsTo('App\Models\BackEnd\BankHolder');
    }
    static function getAllRecord($is_trashed)
    {
        return self::where('is_trashed', $is_trashed)->with(['bank','bank_holder'])->orderBy('name', 'ASC');
    }
}
