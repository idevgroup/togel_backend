<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class Banks extends Model
{
    use HasImageUploads;
    protected $table = 'bank';

    protected static $imageFields = [
        'image' => [
            'width' => _IMG_CATE_W,
            'resize_image_quality' => 90,
            'crop' => false,
            'path' => _UPLOAD_DIRE . 'banks/' . _DIRE_IS_MONTH,
            'file_input' => 'bannerfile'
        ],
        'thumb' => [
            'width' => _IMG_CATE_THUM_W,
            'resize_image_quality' => 90,
            'crop' => true,
            'path' => _UPLOAD_DIRE . 'banks/' . _DIRE_IS_MONTH . '/thumb',
            'file_input' => 'bannerfile'
        ],
    ];

    protected function imageUploadFilePath($file)
    {
        return $this->name . '-' . $this->id . '.' . $file->getClientOriginalExtension();
    }

    protected function thumbUploadFilePath($file)
    {
        return $this->name . '-' . $this->id . '.' . $file->getClientOriginalExtension();
    }
    static function getAllRecord($is_trashed)
    {
        return self::where('is_trashed', $is_trashed)->orderBy('name', 'ASC');
    }
}
