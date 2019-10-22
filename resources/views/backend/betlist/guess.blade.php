<?php

$gameId = (int) $row->gameId;
$guess = (int) $row->guess;
$tebak = '';
if ($gameId > 0 && $gameId <= 5) {
    $tebak = $guess;
    //$gameName = $names[$gameId];
} else if ($gameId == 10) {//Colok Jitu
    $param1 = $row->param1;
    if ($param1 == 1)
        $tebak = "As";
    else if ($param1 == 2)
        $tebak = "Kop";
    else if ($param1 == 3)
        $tebak = "Kepala";
    else if ($param1 == 4)
        $tebak = "Ekor";
    $tebak .= " - $guess";
    // $gameName = "Colok Jitu";
} else if ($gameId == 22 || $gameId == 23) {//Tepi | Tengah
    if ($gameId == 23)
        $tebak = "Tepi";
    else if ($gameId == 22)
        $tebak = "Tengah";
    // $gameName = "Tepi/Tengah";
} else if ($gameId >= 12 && $gameId <= 15 && $gameId != 14  || $gameId == 7 ) {//Dasar
    if ($gameId == 12)
        $tebak = "Ganjil";
    else if ($gameId == 13)
        $tebak = "Genap";
    else if ($gameId == 7)
        $tebak = "Besar";
    else if ($gameId == 15)
        $tebak = "Kecil";
    // $gameName = "Dasar";
} else if ($gameId == 6) {//50-50
    $param1 = $row->param1;
    if ($param1 == 1 || $param1 == 5)
        $tebak = "As";
    else if ($param1 == 2 || $param1 == 6)
        $tebak = "Kop";
    else if ($param1 == 3 || $param1 == 7)
        $tebak = "Kepala";
    else if ($param1 == 4 || $param1 == 8)
        $tebak = "Ekor";

    if ($param1 < 5) {
        if ($guess == "1")
            $tebak .= " - Ganjil";
        else if ($guess == "2")
            $tebak .= " - Genap";
    } else {
        if ($guess == "1")
            $tebak .= " - Besar";
        else if ($guess == "2")
            $tebak .= " - Kecil";
    }
    // $gameName = "50-50";
} else if ($gameId == 20) {//Shio
    $tebak = ShioString($guess, $row->date);
    // $gameName = "Shio";
} else if ($gameId == 14 || $gameId == 21) {//Silang
    if ($guess == 1)
        $tebak = "Depan";
    else if ($guess == 2)
        $tebak = "Tengah";
    else if ($guess == 3)
        $tebak = "Belakang";

    if ($gameId == 21)
        $tebak .= " - Silang";
    elseif ($gameId == 14)
        $tebak .= " - Homo";
    // $gameName = "Silang";
} else if ($gameId == 17 || $gameId == 20 || $gameId == 21) {//Kembang | Kempis | Kimbar
    if ($guess == 1)
        $tebak = "Depan";
    else if ($guess == 2)
        $tebak = "Tengah";
    else if ($guess == 3)
        $tebak = "Belakang";

    if ($gameId == 17)
        $tebak .= " - Kembang";
    else if ($gameId == 20)
        $tebak == " - Kempis";
    else if ($gameId == 21)
        $tebak == "Kembar";
    //$gameName = "Kembang/Kempis";
} else if ($gameId == 18) {//Kombinasi
    $tebak = getKombinasiString($guess) . " - " . getKombinasiString($row->param1);
    // $gameName = "Kombinasi";
}
echo $tebak;

