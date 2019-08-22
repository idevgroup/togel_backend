<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class BetTransaction extends Model
{
    protected $table = 'bet_transction';
    public $timestamps = false;
    
    public function gameName(){
        return $this->hasOne('App\Models\FrontEnd\Game','id','gameId');
    }
}
