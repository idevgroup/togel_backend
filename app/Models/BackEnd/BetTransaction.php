<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class BetTransaction extends Model
{
    protected $table = 'bet_transction';
    public $timestamps = false;
    
    public function gameName(){
        return $this->hasOne('App\Models\BackEnd\Game','id','gameId');
    }
}
