<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class GameResult extends Model
{
    protected $table = 'game_result';
    public $timestamps = false;
    public function marketName(){
        return $this->hasOne('App\Models\FrontEnd\Market','code','market');
    }
     public function getDateAttribute($value) {
       
        return date('d-m-Y', strtotime($value));
    }
}
