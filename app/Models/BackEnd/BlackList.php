<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
    protected $table = 'blacklist';
    static function getAllRecord($is_trashed)
    {
        return self::where('is_trashed', $is_trashed)->orderBy('id', 'ASC');
    }
    public function userId(){
        return $this->hasOne('App\Models\BackEnd\User', 'id', 'bl_by');
    }
}
