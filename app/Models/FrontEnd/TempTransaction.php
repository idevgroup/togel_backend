<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class TempTransaction extends Model
{
     protected $table = 'temp_transaction';
     
    public function member(){
          return $this->hasOne('App\Models\FrontEnd\Member','id','player_id')->select(['reg_username','reg_name']);
    }
     public function getRegUsernameAttribute($value) {
        $val = substr($value,strlen($value)-3,strlen($value));
        $str = str_replace($val,'***', $value);
        return $str;
    }
    static function getTemTransaction($memberid,$status=null){
         if($status != null || !empty($status)){
             return self::where('player_id',$memberid)->where('status',$status)->where('proc_type',$type)->orderBy('request_at','DESC');
         }else{
            return self::where('player_id',$memberid)->orderBy('request_at','DESC');
         }
     }
}
