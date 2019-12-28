<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
     public function getDescriptionAttribute($value) {
        $html = str_replace('src="/',' class="img-fluid" src="'.asset('/'),$value);
        return $html;
    }
}
