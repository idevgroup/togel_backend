<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class MenuSetting extends Model
{
    protected $table = 'menu_setting';

    public function getParent()
    {
        return $this->hasOne('App\Models\BackEnd\MenuSetting', 'id', 'parents');
    }
    public function getParents(){
      return $this->hasMany('App\Models\BackEnd\MenuSetting', 'parents', 'id');
    }

  
}
