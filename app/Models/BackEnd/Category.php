<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class Category extends Model {

    use HasImageUploads;

    protected $table = 'category';
    
    protected static $imageFields = [
        'banner' => [
            'width' => _IMG_CATE_W,
            'resize_image_quality' => 90,
            'crop' => false,
            'path' => 'uploads/category',
            'file_input' => 'bannerfile'
        ],
        'thumb' => [
            'width' => _IMG_CATE_THUM_W,
            'resize_image_quality' => 90,
            'crop' => true,
            'path' => 'uploads/category/thumb',
            'file_input' => 'bannerfile'
        ],
    ];
    
     protected function bannerUploadFilePath($file) {
        return $this->slug.'-'.$this->id. '.' . $file->getClientOriginalExtension();
    }
    protected function thumbUploadFilePath($file) {
        return $this->slug.'-'.$this->id. '.' . $file->getClientOriginalExtension();
    }

}
