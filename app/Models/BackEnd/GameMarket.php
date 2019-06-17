<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class GameMarket extends Model
{
    protected $table = 'game_market';

    static function getAllRecord($is_trashed)
    {
        return self::where('is_trashed', $is_trashed)->orderBy('name', 'ASC');
    }
}
