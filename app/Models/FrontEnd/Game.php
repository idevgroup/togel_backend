<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'game';
    static function getAllRecord($is_trashed,$status=1)
    {
        return self::where('is_trashed', $is_trashed)->where('status',$status)->orderBy('name', 'ASC');
    }
    public function listBetTransaction(){
         return $this->hasMany('App\Models\FrontEnd\BetTransaction','gameId','id');
    }
}
