<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class BankHolder extends Model
{
    use HasImageUploads;
    protected $table = 'bank_holder';
    protected static $imageFields = [
        'photo' => [
            'width' => _IMG_CATE_W,
            'resize_image_quality' => 90,
            'crop' => false,
            'path' => _UPLOAD_DIRE . 'bankholders/' . _DIRE_IS_MONTH,
            'file_input' => 'photo'
        ],
        'thumb' => [
            'width' => _IMG_CATE_THUM_W,
            'resize_image_quality' => 90,
            'crop' => true,
            'path' => _UPLOAD_DIRE . 'bankholders/' . _DIRE_IS_MONTH . '/thumb',
            'file_input' => 'photo'
        ],
    ];

    protected function photoUploadFilePath($file)
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
