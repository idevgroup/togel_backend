<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;
class Player extends Model
{
      protected $table = 'players';
      static function getRecord(){
          return self::with(['getPlayerBank'=>function($query){
              return $query->with('getBank');
          },'getReferral'])->orderBy('id','DESC');
      }
      
      public function getPlayerBank(){
          return $this->hasOne('App\Models\BackEnd\PlayerBanks','reg_id','id');
      }
      public function getReferral(){
           return $this->hasOne('App\Models\BackEnd\Player','id','reg_referral');
      }
}
