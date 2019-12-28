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
    public function getContent(){
        return $this->hasOne('App\Models\BackEnd\Post', 'id', 'link_cont_id');
    }
    public function getCategoryContent(){
        return $this->hasOne('App\Models\BackEnd\Category', 'id', 'link_cont_id');
    }
    public function getProduct(){
        return $this->hasOne('App\Models\BackEnd\Product', 'id', 'link_product_id');
    }
     public function getCategoryProduct(){
        return $this->hasOne('App\Models\BackEnd\Category', 'id', 'link_cat_prod_id');
    }
}
