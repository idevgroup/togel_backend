<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class TemTransaction extends Model
{
     protected $table = 'temp_transaction';
     public function players(){
          return $this->hasOne('App\Models\BackEnd\Player','id','player_id');
    }
    public function checkDepositWithdraw($idtransaction,$player_id,$proc_type,$status){
        $query = self::where('transactid',$idtransaction)->where('player_id',$player_id)->where('proc_type',$proc_type)->where('status',$status);
        return $query;
    }
}
