<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;
use Cache;
class Player extends Model {

    protected $table = 'players';
    protected $hidden = ['reg_password'];

    static function getRecord() {
        return self::with(['getPlayerBank' => function($query) {
                        return $query->with('getBank');
                    }, 'getReferral'])->where('is_trashed', 0);
    }

    public function getPlayerBank() {
        return $this->hasOne('App\Models\BackEnd\PlayerBanks', 'reg_id', 'id');
    }

    public function getReferral() {
        return $this->hasOne('App\Models\BackEnd\Player', 'id', 'reg_referral');
    }

    public function isOnline() {
        return Cache::has('member-is-online-' . $this->id);
    }

}
