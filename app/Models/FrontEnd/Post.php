<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   protected $table = 'post';
      public function getDescriptionAttribute($value) {
        $html = str_replace('src="/',' class="img-fluid" src="'.asset('/'),$value);
        return $html;
    }
}
