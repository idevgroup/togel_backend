<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class MarketGameSetting extends Model
{
    protected $table = 'game_setting';
    public function getRowGame(){
        return $this->hasOne('App\Models\FrontEnd\Game','name','game_name');
    }
}
