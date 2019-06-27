<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class IPFilter extends Model
{
    protected $table = 'ipfilter';

    static function getAllRecord($is_trashed)
    {
        return self::where('is_trashed', $is_trashed)->orderBy('id', 'ASC');
    }
}
