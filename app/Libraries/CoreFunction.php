<?php
function _CheckStatus($status,$id){
    $html = '';
    if($status == 1){
        $html = '<a href="javascript:void(0);" class="btn btn-info m-btn m-btn--icon m-btn--icon-only published" data-status="1" data-id="'.$id.'" id="status_'.$id.'"><i class="fa fa-eye"></i></a>';
    }else{
        $html = '<a href="javascript:void(0);" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only published" data-status="0" data-id="'.$id.'" id="status_'.$id.'" ><i class="fa fa-eye-slash"></i></a>';
    }
    return $html;
}

function _CheckImage($filepath, $optional = []) {
    $attridute = '';
    if (is_array($optional) || count($optional) > 0) {
        foreach ($optional as $key => $value) {
            $attridute .= "$key='$value' ";
        }
    }
    $default_image = _IMG_MISSING_FRONTEND;
    $storagelink = '/storage/';
    if ($filepath != null || $filepath != '') {
        if (file_exists(public_path() . $storagelink . $filepath)) {
            return '<img src="' . asset($storagelink . $filepath) . '" ' . $attridute . '/>';
        } else {
            return '<img src="' . asset($default_image) . '" ' . $attridute . '/>';
        }
    } else {
        return '<img src="' . asset($default_image) . '" ' . $attridute . '/>';
    }
}
