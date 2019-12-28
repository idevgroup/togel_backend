<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
     protected $table = 'site_config';
     public function getDescBottomAttribute($value) {
        $html = str_replace('src="/',' class="img-fluid" src="'.asset('/'),$value);
        return $html;
    }
}
