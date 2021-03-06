<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'game';
    static function getAllRecord($is_trashed)
    {
        return self::where('is_trashed', $is_trashed)->orderBy('name', 'ASC');
    }
}
