<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
      protected $table = 'menu_setting';
      
    public function getContent(){
        return $this->hasOne('App\Models\FrontEnd\Post', 'id', 'link_cont_id');
    }
    public function getProduct(){
        return $this->hasOne('App\Models\FrontEnd\Product', 'id', 'link_product_id');
    }
     public function getCategoryProduct(){
        return $this->hasOne('App\Models\FrontEnd\Category', 'id', 'link_cat_prod_id');
    }
     public function getCategoryContent(){
         return $this->hasOne('App\Models\FrontEnd\Category', 'id', 'link_cat_id');
    }
}
