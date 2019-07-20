<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;
// use QCod\ImageUp\HasImageUploads;

class Notification extends Model
{
    // use HasImageUploads;
    protected $table = 'notification';
    // protected static $imageFields = [
    //     'sound' => [
    //         'path' => _UPLOAD_DIRE . 'notification/' . _DIRE_IS_MONTH,
    //         'file_input' => 'sound'
    //     ],
    // ];
    // protected function soundUploadFilePath($file)
    // {
    //     return $this->nt_name . '-' . $file->getClientOriginalExtension();
    // }
}
