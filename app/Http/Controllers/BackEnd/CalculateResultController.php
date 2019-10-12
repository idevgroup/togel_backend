<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\BackEnd\GameSetting;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\BetTransaction;
use App\Models\BackEnd\Game;
use App\Models\BackEnd\GameResult;

class CalculateResultController extends Controller {

    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rowId = $request->input('id');
        $keyGame = (int) $request->input('key');
        $game = $request->input('gamename');
        $getGameResult = GameResult::findOrFail($rowId);
        $market = $getGameResult->market;
        $result = $getGameResult->result;
        $period = $getGameResult->period;
        $date = $getGameResult->date;
        $responce = '';
        switch ($keyGame) {
            case 1:
                BetTransaction::where('period', $period)->where('market', $market)->update(['isWin' => 0, 'win_termp' => 0]);
               $responce = self::doResultXD($market, $result, $date, $period);
                break;
            case 2:
               // return response()->json($game);
                break;
            case 3:
                //return response()->json($game);
                break;
            case 4:
               // return response()->json($game);
                break;
            case 5:
               // return response()->json($game);
                break;
            case 6:
               // return response()->json($game);
                break;
            case 7:
               // return response()->json($game);
                break;
            case 8:
               // return response()->json($game);
                break;
            case 9:
               // return response()->json($game);
                break;
            case 10:
               // return response()->json($game);
                break;
            case 11:
               // return response()->json($game);
                break;
            case 12:
                //return response()->json($game);
                break;
        }
        return $responce;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function doResultXD($market, $result, $date, $period) {
       
        try {
            DB::raw("CALL calculateXD($market,$result,$date,$period)");
            return response()->json(['status' => true, 'message' => 'Calculated 2D,3D,4D,2D Depan, 2D Tengah is ready']);
        } catch (\Exception $ex) {
            \Log::error('Do Result XD');
            \Log::info(\URL::current());
            \Log::error($ex);
            return response()->json(['status' => false, 'message' => 'Server Error please contact web master']);
        }
    }

    public function doResultColokBebas($market, $result, $date, $period) {
        $getSetting = GameSetting::where('market', $market)->where('game_name', 'Colok Bebas')->first();
        $getGameId = Game::where('name', 'Colok Bebas')->first()->id;
        $fd = (string) $result;
        $m = $getSetting->menang;
        $m2 = $getSetting->menang_dbl;
        $m3 = $getSetting->menang_triple;
        $m4 = $getSetting->menang_quadruple;
        try {
            DB::beginTransaction();
            $doResult = BetTransaction::where('period', $period)->where('market', $market)->where('gameId', $getGameId)
                    ->whereDate('date', '<', $date)
                    ->orWhere('guess', $fd[0])
                    ->orWhere('guess', $fd[1])
                    ->orWhere('guess', $fd[2])
                    ->orWhere('guess', $fd[3])
                    ->update(['isWin' => 1, 'win_termp' => DB::raw("pay + (case when length($result) - length(REPLACE($result,guess,'')) = 1 then buy * $m when length($result) - length(REPLACE($result,guess,'')) = 2 then buy * $m2 when length($result) - length(REPLACE($result,guess,'')) = 3 then buy * $m3 when length($result) - length(REPLACE($result,guess,'')) = 4 then buy * $m4 end)")]);
            DB::commit();
            if ($doResult)
                return response()->json(['status' => true, 'message' => 'Calculated Colok Bebas is ready']);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error('Do Result Colok Bebas');
            \Log::info(\URL::current());
            \Log::error($ex);
            return response()->json(['status' => false, 'message' => 'Server Error please contact web master']);
        }
    }

    public function doResultColok2D($market, $result, $date, $period) {
        $getSetting = GameSetting::where('market', $market)->where('game_name', 'Colok 2D')->first();
        $getGameId = Game::where('name', 'Colok 2D')->first()->id;
        $r = (string) $result;
        $a = "%" . $result[0] . "%";
        $b = "%" . $result[1] . "%";
        $c = "%" . $result[2] . "%";
        $d = "%" . $result[3] . "%";
        try {
            DB::beginTransaction();
            $getGuess = BetTransaction::whereRaw("date < $date and period=$period and gameId = $getGameId and 
                 market=$market and (guess like $a or guess like $b or guess like $c or guess like $d)")->get();
            foreach ($getGuess as $row) {
                $guess = $row->guess;

                $g1 = $guess[0];
                $g2 = $guess[1];

                if (strpos($r, $g1) !== false && strpos($r, $g2) !== false) {
                    if (substr_count($r, $g1) == 1 && substr_count($r, $g2) == 1) {
                        $m = $getSetting->menang;
                    } else if (substr_count($r, $g1) == 2 || substr_count($r, $g2) == 2) {
                        $m = $getSetting->menang_dbl;
                    } else if (substr_count($r, $g1) == 3 || substr_count($r, $g2) == 3) {
                        $m = $getSetting->menang_triple;
                    }
                    $doResult += BetTransaction::whereRaw("guess=$guess and period=$period and market=$market and date < $date and gameId=$getGameId ")->update(['isWin' => 1, 'win_termp' => DB::raw("pay + (buy * $m)")]);
                }
            }
            DB::commit();
            if ($doResult)
                return response()->json(['status' => true, 'message' => 'Calculated Colok 2D is ready']);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error('Do Result Colok 2D');
            \Log::info(\URL::current());
            \Log::error($ex);
            return response()->json(['status' => false, 'message' => 'Server Error please contact web master']);
        }
    }

    public function doResultColokNaga($market, $result, $date, $period) {
        $getSetting = GameSetting::where('market', $market)->where('game_name', 'Colok Naga')->first();
        $getGameId = Game::where('name', 'Colok Naga')->first()->id;
        $r = (string) $result;
        $a = "%" . $result[0] . "%";
        $b = "%" . $result[1] . "%";
        $c = "%" . $result[2] . "%";
        $d = "%" . $result[3] . "%";
        try {
            DB::beginTransaction();
            $getGuess = BetTransaction::whereRaw("date < $date and period=$period and gameId = $getGameId and 
                 market=$market and (guess like $a or guess like $b or guess like $c or guess like $d)")->get();
            foreach ($getGuess as $row) {
                $guess = $row->guess;
                $g1 = $guess[0];
                $g2 = $guess[1];
                $g3 = $guess[2];
                if (strpos($r, $g1) !== false && strpos($r, $g2) !== false) {
                    if (substr_count($r, $g1) == 2 || substr_count($r, $g2) == 2 || substr_count($r, $g3) == 2) {
                        $m = $setting->menang_dbl;
                    } else {
                        $m = $setting->menang;
                    }
                    $doResult += BetTransaction::whereRaw("guess=$guess and period=$period and market=$market and date < $date and gameId=$getGameId ")->update(['isWin' => 1, 'win_termp' => DB::raw("pay + (buy * $m)")]);
                }
            }
            DB::commit();
            if ($doResult)
                return response()->json(['status' => true, 'message' => 'Calculated Colok Naga is ready']);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error('Do Result Colok Naga');
            \Log::info(\URL::current());
            \Log::error($ex);
            return response()->json(['status' => false, 'message' => 'Server Error please contact web master']);
        }
    }

    public function doResultColokJitu($market, $result, $date, $period) {
        $getSetting = GameSetting::where('market', $market)->where('game_name', 'Colok Jitu')->first();
        $getGameId = Game::where('name', 'Colok Jitu')->first()->id;
        $as = $result[0];
        $kop = $result[1];
        $kepala = $result[2];
        $ekor = $result[3];
        $m = $getSetting->menang;
        try {
            DB::beginTransaction();
            $doResult = BetTransaction::whereRaw("period=$period and market=$market and date < $date
                                      and gameId=$getGameId and ((param1=1 and guess=$as) or (param1=2 and guess=$kop) or 
                                      (param1=3 and guess=$kepala) or (param1=4 and guess=$ekor))")
                    ->update(['isWin' => 1, 'win_termp' => DB::raw(" pay + (buy * $m)")]);
            DB::commit();
            if ($doResult)
                return response()->json(['status' => true, 'message' => 'Calculated Colok Jitu is ready']);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error('Do Result Colok Jitu');
            \Log::info(\URL::current());
            \Log::error($ex);
            return response()->json(['status' => false, 'message' => 'Server Error please contact web master']);
        }
    }

    public function doResultColoTepiTengah($market, $result, $date, $period) {
        $re = $result[2] . $result[3];
        $re = (int) $re;
        if ($re > 24 && $re < 75) {
            $getSetting = GameSetting::where('market', $market)->where('game_name', 'Tengah')->first();
            $getGameId = Game::where('name', 'Tengah')->first()->id;
        } else {
            $getSetting = GameSetting::where('market', $market)->where('game_name', 'Tepi')->first();
            $getGameId = Game::where('name', 'Tepi')->first()->id;
        }
        $m = $getSetting->menang;
        try {
            DB::beginTransaction();
            $doResult = BetTransaction::whereRaw("period=$period and market=$market and date < $date
                                      and gameId=$getGameId")
                    ->update(['isWin' => 1, 'win_termp' => DB::raw(" pay + (buy * $m)")]);
            DB::commit();
            if ($doResult)
                return response()->json(['status' => true, 'message' => 'Calculated Tengah,Tepi is ready']);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error('Do Result Tengah,Tepi');
            \Log::info(\URL::current());
            \Log::error($ex);
            return response()->json(['status' => false, 'message' => 'Server Error please contact web master']);
        }
    }

    public function doResultDasar($market, $result, $date, $period) {
        $dsa1 = (int) ($result[2] . $result[3]);
        while ($dsa1 > 9) {
            $dsa1 = (string) $dsa1;
            $dsa2 = (int) $dsa1[0];
            $dsa3 = (int) $dsa1[1];
            $dsa1 = ($dsa2 + $dsa3);
        }
        try {
            DB::beginTransaction();
            //Ganjil | Genap
            if ($dsa1 % 2 == 0) {
                $getSetting = GameSetting::where('market', $market)->where('game_name', 'Genap')->first();
                $getGameId = Game::where('name', 'Genap')->first()->id;
            } else {
                $getSetting = GameSetting::where('market', $market)->where('game_name', 'Ganjil')->first();
                $getGameId = Game::where('name', 'Ganjil')->first()->id;
            }
            $m = $getSetting->menang;
            $doResult = BetTransaction::whereRaw("period=$period and market=$market and date < $date
                                      and gameId=$getGameId")
                    ->update(['isWin' => 1, 'win_termp' => DB::raw(" pay + (buy * $m)")]);

            //Besar | Kecil
            if ($dsa1 < 5) {
                $getSetting = GameSetting::where('market', $market)->where('game_name', 'Kecil')->first();
                $getGameId = Game::where('name', 'Genap')->first()->id;
            } else {
                $getSetting = GameSetting::where('market', $market)->where('game_name', 'Besar')->first();
                $getGameId = Game::where('name', 'Ganjil')->first()->id;
            }
            $m = $getSetting->menang;
            $doResult = BetTransaction::whereRaw("period=$period and market=$market and date < $date
                                      and gameId=$getGameId")
                    ->update(['isWin' => 1, 'win_termp' => DB::raw(" pay + (buy * $m)")]);

            DB::commit();
            if ($doResult)
                return response()->json(['status' => true, 'message' => 'Calculated Dasar is ready']);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error('Do Result Dasar');
            \Log::info(\URL::current());
            \Log::error($ex);
            return response()->json(['status' => false, 'message' => 'Server Error please contact web master']);
        }
    }

    public function doResult50_50($market, $result, $date, $period) {
        $getSetting = GameSetting::where('market', $market)->where('game_name', '50-50')->first();
        $getGameId = Game::where('name', '50-50')->first()->id;
        $as = $result[0];
        $kop = $result[1];
        $kepala = $result[2];
        $ekor = $result[3];

        //Ganjil | Genap
        $gas = ($as % 2 == 0 ? 2 : 1);
        $gkop = ($kop % 2 == 0 ? 2 : 1);
        $gkepala = ($kepala % 2 == 0 ? 2 : 1);
        $gekor = ($ekor % 2 == 0 ? 2 : 1);

        //Besar | Kecil
        $tas = ($as > 4 ? 1 : 2);
        $tkop = ($kop > 4 ? 1 : 2);
        $tkepala = ($kepala > 4 ? 1 : 2);
        $tekor = ($ekor > 4 ? 1 : 2);
        try {
            DB::beginTransaction();
            $m = $getSetting->menang;
            $doResult = BetTransaction::whereRaw("period=$period and market=$market and date < $date
                                      and gameId=$getGameId and ((param1=1 and guess=$gas) or (param1=2 and guess=$gkop) or 
                                      (param1=3 and guess=$gkepala) or (param1=4 and guess=$gekor) or (param1=5 and guess=$tas) or 
                                      (param1=6 and guess=$tkop) or (param1=7 and guess=$tkepala) or (param1=8 and guess=$tekor))")
                    ->update(['isWin' => 1, 'win_termp' => DB::raw(" pay + (buy * $m)")]);
            DB::commit();
            if ($doResult)
                return response()->json(['status' => true, 'message' => 'Calculated 50-50 is ready']);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error('Do Result 50-50');
            \Log::info(\URL::current());
            \Log::error($ex);
            return response()->json(['status' => false, 'message' => 'Server Error please contact web master']);
        }
    }

    public function doResultShio($market, $result, $date, $period) {
        $getSetting = GameSetting::where('market', $market)->where('game_name', 'Shio')->first();
        $getGameId = Game::where('name', 'Shio')->first()->id;
        $r = $result[2] . $result[3];
        $kambing = array("01", "13", "25", "37", "49", "61", "73", "85", "97"); // 1
        $kuda = array("02", "14", "26", "38", "50", "62", "74", "86", "98"); // 2
        $ular = array("03", "15", "27", "39", "51", "63", "75", "87", "99"); // 3
        $naga = array("04", "16", "28", "40", "52", "64", "76", "88", "00"); // 4
        $kelinci = array("05", "17", "29", "41", "53", "65", "77", "89"); // 5
        $harimau = array("06", "18", "30", "42", "54", "66", "78", "90"); // 6
        $kerbau = array("07", "19", "31", "43", "55", "67", "79", "91"); // 7
        $tikus = array("08", "20", "32", "44", "56", "68", "80", "92"); // 8
        $babi = array("09", "21", "33", "45", "57", "69", "81", "93"); // 9
        $anjing = array("10", "22", "34", "46", "58", "70", "82", "94"); // 10
        $ayam = array("11", "23", "35", "47", "59", "71", "83", "95"); // 11
        $monyet = array("12", "24", "36", "48", "60", "72", "84", "96"); // 12

        $g = 0;
        if (in_array($r, $kambing) == true)
            $g = 1;
        else if (in_array($r, $kuda) == true)
            $g = 2;
        else if (in_array($r, $ular) == true)
            $g = 3;
        else if (in_array($r, $naga) == true)
            $g = 4;
        else if (in_array($r, $kelinci) == true)
            $g = 5;
        else if (in_array($r, $harimau) == true)
            $g = 6;
        else if (in_array($r, $kerbau) == true)
            $g = 7;
        else if (in_array($r, $tikus) == true)
            $g = 8;
        else if (in_array($r, $babi) == true)
            $g = 9;
        else if (in_array($r, $anjing) == true)
            $g = 10;
        else if (in_array($r, $ayam) == true)
            $g = 11;
        else if (in_array($r, $monyet) == true)
            $g = 12;

        try {
            DB::beginTransaction();
            $m = $getSetting->menang;
            $doResult = BetTransaction::whereRaw("period=$period and market=$market and date < $date
                                      and gameId=$getGameId and guess=$g")
                    ->update(['isWin' => 1, 'win_termp' => DB::raw(" pay + (buy * $m)")]);
            DB::commit();
            if ($doResult)
                return response()->json(['status' => true, 'message' => 'Calculated Shio is ready']);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error('Do Result Shio');
            \Log::info(\URL::current());
            \Log::error($ex);
            return response()->json(['status' => false, 'message' => 'Server Error please contact web master']);
        }
    }

    public function doResultSilang($market, $result, $date, $period) {
        $p1 = (int) $result[0];
        $p2 = (int) $result[1];
        $p3 = (int) $result[2];
        $p4 = (int) $result[3];
        try {
            DB::beginTransaction();
            //Silang
            $getSetting = GameSetting::where('market', $market)->where('game_name', 'Silang')->first();
            $getGameId = Game::where('name', 'Silang')->first()->id;
            $m = $getSetting->menang;
            $depan = ((($p1 % 2 == 0 && $p2 % 2 == 0) || ($p1 % 2 == 1 && $p2 % 2 == 1)) ? 0 : 1); //($p1 == $p2 ? 0 : 1);
            $tengah = ((($p2 % 2 == 0 && $p3 % 2 == 0) || ($p2 % 2 == 1 && $p3 % 2 == 1)) ? 0 : 2); //($p2 == $p3 ? 0 : 2);
            $belakang = ((($p3 % 2 == 0 && $p4 % 2 == 0) || ($p3 % 2 == 1 && $p4 % 2 == 1)) ? 0 : 3); //($p3 == $p4 ? 0 : 3);

            $doResult = BetTransaction::whereRaw("period=$period and market=$market and date < $date
                                          and gameId=$getGameId and (guess=$depan or guess=$tengah or guess=$belakang)")
                    ->update(['isWin' => 1, 'win_termp' => DB::raw(" pay + (buy * $m)")]);


            //Homo
            $getSetting = GameSetting::where('market', $market)->where('game_name', 'Homo')->first();
            $getGameId = Game::where('name', 'Homo')->first()->id;
            $m = $getSetting->menang;
            $depan = ((($p1 % 2 == 0 && $p2 % 2 == 0) || ($p1 % 2 == 1 && $p2 % 2 == 1)) ? 1 : 0); //($p1 == $p2 ? 1 : 0);
            $tengah = ((($p2 % 2 == 0 && $p3 % 2 == 0) || ($p2 % 2 == 1 && $p3 % 2 == 1)) ? 2 : 0); //($p2 == $p3 ? 2 : 0);
            $belakang = ((($p3 % 2 == 0 && $p4 % 2 == 0) || ($p3 % 2 == 1 && $p4 % 2 == 1)) ? 3 : 0); //($p3 == $p4 ? 3 : 0);

            $doResult = BetTransaction::whereRaw("period=$period and market=$market and date < $date
                                          and gameId=$getGameId and (guess=$depan or guess=$tengah or guess=$belakang)")
                    ->update(['isWin' => 1, 'win_termp' => DB::raw(" pay + (buy * $m)")]);
            DB::commit();
            if ($doResult)
                return response()->json(['status' => true, 'message' => 'Calculated Silang is ready']);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error('Do Result Silang');
            \Log::info(\URL::current());
            \Log::error($ex);
            return response()->json(['status' => false, 'message' => 'Server Error please contact web master']);
        }
    }

    public function doResultKembang($market, $result, $date, $period) {
        $p1 = (int) $result[0];
        $p2 = (int) $result[1];
        $p3 = (int) $result[2];
        $p4 = (int) $result[3];
        try {
            DB::beginTransaction();
            //Kembang
            $getSetting = GameSetting::where('market', $market)->where('game_name', 'Kembang')->first();
            $getGameId = Game::where('name', 'Kembang')->first()->id;
            $m = $getSetting->menang;
            $depan = ($p1 < $p2 ? 1 : 0);
            $tengah = ($p2 < $p3 ? 2 : 0);
            $belakang = ($p3 < $p4 ? 3 : 0);
            $doResult = BetTransaction::whereRaw("period=$period and market=$market and date < $date
                                          and gameId=$getGameId and (guess=$depan or guess=$tengah or guess=$belakang)")
                    ->update(['isWin' => 1, 'win_termp' => DB::raw(" pay + (buy * $m)")]);

            //Kempis
            $getSetting = GameSetting::where('market', $market)->where('game_name', 'Kempis')->first();
            $getGameId = Game::where('name', 'Kempis')->first()->id;
            $m = $getSetting->menang;
            $depan = ($p1 > $p2 ? 1 : 0);
            $tengah = ($p2 > $p3 ? 2 : 0);
            $belakang = ($p3 > $p4 ? 3 : 0);
            $doResult = BetTransaction::whereRaw("period=$period and market=$market and date < $date
                                          and gameId=$getGameId and (guess=$depan or guess=$tengah or guess=$belakang)")
                    ->update(['isWin' => 1, 'win_termp' => DB::raw(" pay + (buy * $m)")]);


            //Kembar
            $getSetting = GameSetting::where('market', $market)->where('game_name', 'Kembar')->first();
            $getGameId = Game::where('name', 'Kembar')->first()->id;
            $m = $getSetting->menang;
            $depan = ($p1 == $p2 ? 1 : 0);
            $tengah = ($p2 == $p3 ? 2 : 0);
            $belakang = ($p3 == $p4 ? 3 : 0);
            $doResult = BetTransaction::whereRaw("period=$period and market=$market and date < $date
                                          and gameId=$getGameId and (guess=$depan or guess=$tengah or guess=$belakang)")
                    ->update(['isWin' => 1, 'win_termp' => DB::raw(" pay + (buy * $m)")]);

            DB::commit();
            if ($doResult)
                return response()->json(['status' => true, 'message' => 'Calculated Kembang is ready']);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error('Do Result Kembang');
            \Log::info(\URL::current());
            \Log::error($ex);
            return response()->json(['status' => false, 'message' => 'Server Error please contact web master']);
        }
    }

    public function doResultKombinasi($market, $result, $date, $period) {
        $p1 = (int) $result[0];
        $p2 = (int) $result[1];
        $p3 = (int) $result[2];
        $p4 = (int) $result[3];
        $getSetting = GameSetting::where('market', $market)->where('game_name', 'Kombinasi')->first();
        $getGameId = Game::where('name', 'Kombinasi')->first()->id;
        $m = $getSetting->menang;
        //As Ganjil | Genap
        $as_g = ($p1 % 2 == 0 ? 2 : 1);
        //As Besar / Kecil
        $as_b = ($p1 > 4 ? 3 : 4);

        //Kop Ganjil | Genap
        $kop_g = ($p2 % 2 == 0 ? 6 : 5);
        //Kop Besar / Kecil
        $kop_b = ($p2 > 4 ? 7 : 8);

        //Kepala Ganjil | Genap
        $kepala_g = ($p3 % 2 == 0 ? 10 : 9);
        //Kepala Besar / Kecil
        $kepala_b = ($p3 > 4 ? 11 : 12);

        //Kepala Ganjil | Genap
        $ekor_g = ($p4 % 2 == 0 ? 14 : 13);
        //Kop Besar / Kecil
        $ekor_b = ($p4 > 4 ? 15 : 16);
        try {
            DB::beginTransaction();
            $sSql = "";
            for ($i = 1; $i < 9; $i++)
                $sSql .= "(guess=:g$i and param1=:p$i) or ";
            $sSql = substr($sSql, 0, -4);

            $a = array($as_b, $as_g);
            $b = array($kop_b, $kop_g);
            $i = 0;
            foreach ($a as $val) {
                foreach ($b as $vv) {
                    $data[":g" . (string) ($i + 1)] = $val;
                    $data[":p" . (string) ($i + 1)] = $vv;
                    $i++;
                }
            }
            $a = array($kepala_b, $kepala_g);
            $b = array($ekor_b, $ekor_g);
            foreach ($a as $val) {
                foreach ($b as $vv) {
                    $data[":g" . (string) ($i + 1)] = $val;
                    $data[":p" . (string) ($i + 1)] = $vv;
                    $i++;
                }
            }
            $doResult = BetTransaction::whereRaw(" period=$period and market=$market and date < $date
                                          and gameId=$getGameId and ($sSql) ")
                    ->update(['isWin' => 1, 'win_termp' => DB::raw(" pay + (buy * $m)")])
                    ->setBindings($data);


            $sSql = "";
            for ($i = 1; $i < 17; $i++)
                $sSql .= "(guess=:g$i and param1=:p$i) or ";
            $sSql = substr($sSql, 0, -4);


            $a = array($as_b, $as_g, $kop_b, $kop_g);
            $b = array($kepala_b, $kepala_g, $ekor_b, $ekor_g);
            $i = 0;
            foreach ($a as $val) {
                foreach ($b as $vv) {
                    $data[":g" . (string) ($i + 1)] = $val;
                    $data[":p" . (string) ($i + 1)] = $vv;
                    $i++;
                }
            }
            $doResult = BetTransaction::whereRaw(" period=$period and market=$market and date < $date
                                          and gameId=$getGameId and ($sSql) ")
                    ->update(['isWin' => 1, 'win_termp' => DB::raw(" pay + (buy * $m)")])
                    ->setBindings($data);
            DB::commit();
            if ($doResult)
                return response()->json(['status' => true, 'message' => 'Calculated Kombinasi is ready']);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error('Do Result Kombinasi');
            \Log::info(\URL::current());
            \Log::error($ex);
            return response()->json(['status' => false, 'message' => 'Server Error please contact web master']);
        }
    }

}
