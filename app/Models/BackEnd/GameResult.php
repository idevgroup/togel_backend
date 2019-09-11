<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class GameResult extends Model
{
    protected $table = 'game_result';
    public $timestamps = false;
    
    public function marketName(){
        return $this->hasOne('App\Models\BackEnd\GameMarket','code','market');
    }
}
