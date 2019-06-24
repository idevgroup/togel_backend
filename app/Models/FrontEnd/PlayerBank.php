<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class PlayerBank extends Model {

    protected $table = 'player_banks';

    public function getBank() {
        return $this->hasOne('App\Models\FrontEnd\Bank', 'id', 'reg_bk_id');
    }

}
