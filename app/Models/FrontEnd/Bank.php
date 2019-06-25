<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model {

    protected $table = 'bank';

    static function getAllRecord($is_trashed,$is_status) {
        return self::where('is_trashed', $is_trashed)->where('status',$is_status)->orderBy('bk_name', 'ASC');
    }
   public function getBank(){
          return $this->hasOne('App\Models\FrontEnd\Banks','id','reg_bk_id');
      }
}
