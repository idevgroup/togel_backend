<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class PlayerBanks extends Model
{
     protected $table = 'player_banks';
     
       public function getBank(){
          return $this->hasOne('App\Models\BackEnd\Banks','id','reg_bk_id');
      }
}
