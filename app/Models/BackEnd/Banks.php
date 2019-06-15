<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class Banks extends Model
{
    use HasImageUploads;
    protected $table = 'bank';

    protected static $imageFields = [
        'bk_image' => [
            'width' => _IMG_CATE_W,
            'resize_image_quality' => 90,
            'crop' => false,
            'path' => _UPLOAD_DIRE . 'banks/' . _DIRE_IS_MONTH,
            'file_input' => 'bannerfile'
        ],
        'bk_thumb' => [
            'width' => _IMG_CATE_THUM_W,
            'resize_image_quality' => 90,
            'crop' => true,
            'path' => _UPLOAD_DIRE . 'banks/' . _DIRE_IS_MONTH . '/thumb',
            'file_input' => 'bannerfile'
        ],
    ];

    protected function bk_imageUploadFilePath($file)
    {
        return $this->name . '-' . $this->id . '.' . $file->getClientOriginalExtension();
    }

    protected function bk_thumbUploadFilePath($file)
    {
        return $this->name . '-' . $this->id . '.' . $file->getClientOriginalExtension();
    }
    public function bankaccountgroup(){
        return $this->hasOne('App\Models\BackEnd\BankAccountGroup', 'id', 'bank_id');
    }
    static function getAllRecord($is_trashed)
    {
        return self::where('is_trashed', $is_trashed)->orderBy('bk_name', 'ASC');
    }
}
