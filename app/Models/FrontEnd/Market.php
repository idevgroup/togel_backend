<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $table = 'game_market';
    
    static function getAllRecord($is_trashed,$is_status) {
        return self::where('is_trashed', $is_trashed)->where('status',$is_status)->orderBy('name', 'ASC');
    }
}
