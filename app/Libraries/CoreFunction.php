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
    $getStr = substr($str, -4);
    return 'XXXXXXXX' . $getStr;
}

function _SiteLock($fromTime, $endTime) {
    $current_time = date("h:i a");
    $begin = $fromTime;
    $end = $endTime;

    $date1 = DateTime::createFromFormat('H:i a', $current_time);
    $date2 = DateTime::createFromFormat('H:i a', $begin);
    $date3 = DateTime::createFromFormat('H:i a', $end);

    if ($date1 > $date2 && $date1 < $date3) {
        return true;
    } else {
        return false;
    }
}

function permute($arg) {
    $arg = str_replace("0", "~", $arg);
    $array = is_string($arg) ? str_split($arg) : $arg;
    if (1 === count($array))
        return $array;
    $r = array();
    foreach ($array as $key => $item)
        foreach ($this->permute(array_diff_key($array, array($key => $item))) as $p)
            $r[] = $item . $p;

    $result = array();
    $index = 0;
    foreach ($r as $key => $val) {
        if (in_array($val, $result) == false) {
            $result[$index] = $val;
            //$result[$index] = str_replace("_", "0", $val);
            $index++;
        }
    }

    return $result;
}

function getKombinasiString($index) {
    switch ($index) {
        case 1: return "As Ganjil";
        case 2: return "As Genap";
        case 3: return "As Besar";
        case 4: return "As Kecil";

        case 5: return "Kop Ganjil";
        case 6: return "Kop Genap";
        case 7: return "Kop Besar";
        case 8: return "Kop Kecil";

        case 9: return "Kepala Ganjil";
        case 10: return "Kepala Genap";
        case 11: return "Kepala Besar";
        case 12: return "Kepala Kecil";

        case 13: return "Ekor Ganjil";
        case 14: return "Ekor Genap";
        case 15: return "Ekor Besar";
        case 16: return "Ekor Kecil";
    }
    return NULL;
}

function ShioString($item_index, $date = null) {
    if ($date == null)
        $date = date("Y-m-d");
    else
        $date = date("Y-m-d", strtotime($date));
    $s = date("Y_m_d", strtotime($date));
    if ($s == null) {
        $year = date("Y", strtotime($date));
        if ($year < 2015)
            $year = 2015;
        else if ($year > 2044)
            $year = 2044;
        $arYear = array(2015 => "02-19", 2016 => "02-08", 2017 => "01-28", 2018 => "02-16", 2019 => "02-05", 2020 => "01-25", 2021 => "02-12", 2022 => "02-01", 2023 => "02-22",
            2024 => "02-10", 2025 => "01-29", 2026 => "02-17", 2027 => "02-06", 2028 => "01-26", 2029 => "02-13", 2030 => "02-03", 2031 => "01-23", 2032 => "02-11", 2033 => "01-31",
            2034 => "02-19", 2035 => "02-08", 2036 => "01-28", 2037 => "02-15", 2038 => "02-04", 2039 => "01-24", 2040 => "02-12", 2041 => "02-01", 2042 => "01-22", 2043 => "02-10", 2044 => "02-30");
        if (strtotime($date) < strtotime($year . "-" . $arYear[$year])) {
            $year = $year - 1;
            if ($year < 2015)
                $year = 2015;
            else if ($year > 2044)
                $year = 2044;
        }

        $g = array("Kambing", "Kuda", "Ular", "Naga", "Kelinci", "Harimau", "Kerbau", "Tikus", "Babi", "Anjing", "Ayam", "Monyet");
        $index = ($year - 2015);
        if ($index > 11)
            $index = $index % 12;

        $cnt = 12 + $index;
        for ($i = $cnt - 1; $i > 0; $i--) {
            if ($i - $index < 0)
                break;
            $g[$i] = $g[$i - $index];
        }
        for ($i = 12; $i < $cnt; $i++) {
            $g[$i - 12] = $g[$i];
            unset($g[$i]);
        }

        $s = $g;
    }
    return $s[$item_index - 1];
}
