<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FrontEnd\Bank;
use App\Models\FrontEnd\FrontSetting;
use Config;
use App\Models\FrontEnd\Game;
use App\Models\FrontEnd\Market;
use App\Models\FrontEnd\MarketGameSetting;
use Auth;
use App\Models\FrontEnd\GameResult;

class FrontEndController extends Controller {

    public function getBank() {
        $getBankList = Bank::getAllRecord(0, 1)->get();
        return response($getBankList->jsonSerialize());
    }

    protected function guard() {
        return Auth::guard('api');
    }

    public function getSetting() {
        $getGeneralSetting = FrontSetting::getGeneralSetting();
        $getArrayCurrency = Config('sysconfig.currency_code');
        $getLocaleCode = $getArrayCurrency[$getGeneralSetting->currency];
        $getSymbol = isset($getLocaleCode['symbol']) ? $getLocaleCode['symbol'] : '';
        $setGeneralSetting = [
            'currency' => $getGeneralSetting->currency,
            'logo' => $getGeneralSetting->logo,
            'favicon' => $getGeneralSetting->icon,
            'timezone' => $getGeneralSetting->timezone,
            'symbol' => $getSymbol
        ];
        //\Log::info($setGeneralSetting);
        $market = Market::getAllRecord(0, 1)->get();
        $getBankList = Bank::getAllRecord(0, 1)->get();
        $getGameList = Game::getAllRecord(0)->get();
        $getSiteLock = FrontSetting::getSiteLock();
        return response()->json(['general' => $setGeneralSetting, 'market' => $market->jsonSerialize(), 'bank' => $getBankList->jsonSerialize(), 'gameitem' => $getGameList->jsonSerialize(),'sitelock' => $getSiteLock->jsonSerialize()], 200);
    }

    public function getMarketGameSetting(Request $request) {
       // \Log::info($request->all());
        $market = $request->input('market');
        $game = $request->input('game');
        if(is_array($game)){
            $getMarketGameSetting = MarketGameSetting::where('market', $market)->whereIn('game_name', $game)->orderBy('id','ASC')->get();
        }else{
            $getMarketGameSetting = MarketGameSetting::where('market', $market)->where('game_name', $game)->first();
        }
        
        return response()->json($getMarketGameSetting->jsonSerialize());
    }
    
    public function getPeriodMarket(Request $request) {
        $getBetMarket = $request->input('marketcode');
        $getPeriod = 1;
        $getPeriod += GameResult::where('market', $getBetMarket)->where('isChecked', 'Y')->max('period');
        return response()->json(['period' => $getPeriod]);
    }

    public function checkLimitNumberBet(Request $request) {
        $getBetMarket = $request->input('marketcode');
        $getPeriod = 1;
        $getPeriod += GameResult::where('market', $getBetMarket)->where('isChecked', 'Y')->max('period');
        $numberbet = $request->input('numberbet');
        $marketcode = $request->input('marketcode');
        $getGame = $request->input('gamecode');
        //Bet Transaction
        $gamecode = \App\Models\FrontEnd\Game::where('name', $getGame)->first()->id;

        $countBetNumber = \App\Models\FrontEnd\BetTransaction::where('gameId', $gamecode)->where('market',$marketcode)->where('period',$getPeriod)->where('guess',$numberbet)->count();
         return response()->json(['count' => $countBetNumber]);
    }

}
