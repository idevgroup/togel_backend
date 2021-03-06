<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class Category extends Model
{

    use HasImageUploads;
    protected $table = 'category';

    public function getParents(){
        return $this->hasMany('App\Models\BackEnd\Category', 'parent_id', 'id');
    }
    
    public function posts(){
        return $this->hasMany('App\Models\BackEnd\Post', 'category_id', 'id')->where([['status',1],['is_trashed',0]]);
    }
  
    public function products(){
        return $this->hasMany('App\Models\BackEnd\Product', 'category_id', 'id')->where([['status',1],['is_trashed',0]]);
    }
    public function dreambooks(){
        return $this->hasMany('App\Models\BackEnd\DreamBooks', 'category_id', 'id')->where([['status',1],['is_trashed',0]]);
    }
    protected static $imageFields = [
        'banner' => [
            'width' => _IMG_CATE_W,
            'resize_image_quality' => 90,
            'crop' => false,
            'path' => _UPLOAD_DIRE . 'category/' . _DIRE_IS_MONTH,
            'file_input' => 'bannerfile'
        ],
        'thumb' => [
            'width' => _IMG_CATE_THUM_W,
            'resize_image_quality' => 90,
            'crop' => true,
            'path' => _UPLOAD_DIRE . 'category/' . _DIRE_IS_MONTH . '/thumb',
            'file_input' => 'bannerfile'
        ],
    ];

    protected function bannerUploadFilePath($file)
    {
        return $this->slug . '-' . $this->id . '.' . $file->getClientOriginalExtension();
    }

    protected function thumbUploadFilePath($file)
    {
        return $this->slug . '-' . $this->id . '.' . $file->getClientOriginalExtension();
    }

    static function getAllRecord($is_trashed)
    {
        return self::where('is_trashed', $is_trashed)->orderBy('name', 'ASC');
    }

}
