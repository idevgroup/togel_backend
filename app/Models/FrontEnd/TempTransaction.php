<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class TempTransaction extends Model
{
     protected $table = 'temp_transaction';
     
    static function getTemTransaction($memberid,$status=null){
         if($status != null || !empty($status)){
             return self::where('player_id',$memberid)->where('status',$status)->where('proc_type',$type)->orderBy('request_at','DESC');
         }else{
            return self::where('player_id',$memberid)->orderBy('request_at','DESC');
         }
     }
}
