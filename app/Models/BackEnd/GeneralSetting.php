<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class GeneralSetting extends Model
{
    use HasImageUploads;
    protected $table = 'general_setting';

    protected static $imageFields = [
        'logo' => [
            'width' => _IMG_GENSETLOGO_THUM_W,
            'height' => _IMG_GENSETLOGO_THUM_H,
            'resize_image_quality' => 90,
            'crop' => false,
            'path' => _UPLOAD_DIRE . 'generalsetting/' . _DIRE_IS_MONTH,
            'file_input' => 'logo'
        ],
        'icon' => [
            'width' => _IMG_GENSETICON_THUM_W,
            'height' => _IMG_GENSETICON_THUM_H,
            'resize_image_quality' => 90,
            'crop' => true,
            'path' => _UPLOAD_DIRE . 'generalsetting/' . _DIRE_IS_MONTH . '/icon',
            'file_input' => 'icon'
        ],
    ];

    protected function logoUploadFilePath($file)
    {
        return $this->currency . '-' . $this->id . '.' . $file->getClientOriginalExtension();
    }

    protected function iconUploadFilePath($file)
    {
        return $this->currency . '-' . $this->id . '.' . $file->getClientOriginalExtension();
    }

}
