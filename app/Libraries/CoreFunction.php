<?php

function _CheckStatus($status, $id) {
    $html = '';
    if ($status == 1) {
        $html = '<a href="javascript:void(0);" class="btn btn-info m-btn m-btn--icon m-btn--icon-only published" data-status="1" data-id="' . $id . '" id="status_' . $id . '"><i class="fa fa-eye"></i></a>';
    } else {
        $html = '<a href="javascript:void(0);" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only published" data-status="0" data-id="' . $id . '" id="status_' . $id . '" ><i class="fa fa-eye-slash"></i></a>';
    }
    return $html;
}

function _CheckImage($filepath, $defaultimage = '', $optional = []) {
    $attridute = '';
    if (is_array($optional) || count($optional) > 0) {
        foreach ($optional as $key => $value) {
            $attridute .= "$key='$value' ";
        }
    }
    $default_image = '';
    if ($defaultimage != '') {
        $default_image = _IMG_DEFAULT;
    }
    if ($filepath != null || $filepath != '') {
        if (file_exists(public_path() . '/' . $filepath)) {
            return '<img src="' . asset($filepath) . '" ' . $attridute . ' />';
        } else {
            return '<img src="' . asset($default_image) . '" ' . $attridute . '/>';
        }
    } else {
        return '<img src="' . asset($default_image) . '" ' . $attridute . '/>';
    }
}

function _EncryptPwd($pwd) {
    $pwd = md5(trim($pwd));
    $cnt = strlen($pwd);
    $result = "";
    for ($i = 0; $i < $cnt; $i++) {
        $a = ((ord($pwd[$i]) * 2 + 100) / 3) + 5;
        if ($a > 254) {
            $a = ($a / 2) - 50;
        }
        $result .= chr($a);
    }
    return $result;
}

/**
 * Remove HTML tags, including invisible text such as style and
 * script code, and embedded objects.  Add line breaks around
 * block-level tags to prevent word joining after tag removal.
 */
function _strip_html_tags($text) {
    $text = preg_replace(
            array(
                // Remove invisible content
                '@<head[^>]*?>.*?</head>@siu',
                '@<style[^>]*?>.*?</style>@siu',
                '@<script[^>]*?.*?</script>@siu',
                '@<object[^>]*?.*?</object>@siu',
                '@<embed[^>]*?.*?</embed>@siu',
                '@<applet[^>]*?.*?</applet>@siu',
                '@<noframes[^>]*?.*?</noframes>@siu',
                '@<noscript[^>]*?.*?</noscript>@siu',
                '@<noembed[^>]*?.*?</noembed>@siu',
                // Add line breaks before and after blocks
                '@</?((address)|(blockquote)|(center)|(del))@iu',
                '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
                '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
                '@</?((table)|(th)|(td)|(caption))@iu',
                '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
                '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
                '@</?((frameset)|(frame)|(iframe))@iu',
            ),
            array(
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
                "\n\$0", "\n\$0",
            ),
            $text);
    return strip_tags($text);
}

function _covertStringX($str) {
    $strLen = strlen($str);
    $getStr = substr($str,-4);
   \Log::info($getStr);
    return 'XXXXXXXX'.$getStr;
}
