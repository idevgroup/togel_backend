<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class BankHolder extends Model
{
    protected $table = 'bank_holder';


    static function getAllRecord($is_trashed)
    {
        return self::where('is_trashed', $is_trashed)->orderBy('name', 'ASC');
    }
}
