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
use App\Models\FrontEnd\Menu;
use App\Models\FrontEnd\Post;
Use App\Models\FrontEnd\Product;
use App\Models\FrontEnd\Category;
use App\Models\FrontEnd\TempTransaction;
use DB;
use App\Models\FrontEnd\Language;
use App\Models\FrontEnd\SiteSetting;

class FrontEndController extends Controller {

    public function getBank() {
        $getBankList = Bank::getAllRecord(0, 1)->get();
        return response($getBankList->jsonSerialize());
    }

    protected function guard() {
        return Auth::guard('api');
    }

    public function getHome() {
        $getMarket = Market::where([['status', 1], ['is_trashed', 0]])->get();
        $result = collect();
        foreach ($getMarket as $row) {
            $result[$row->code] = GameResult::with('marketName')->where([['market', $row->code], ['isChecked', 'Y'], ['isCalc', 'Y']])->orderBy('result_id', 'DESC')->first();
        }
        $arrResult = collect($result)->sortByDesc(function ($obj, $key) {
            $value = !is_null(collect($obj)) ? collect($obj) : '';
            return $value;
        });
        $trasactionDeposit = TempTransaction::leftJoin('players','players.id','=','temp_transaction.player_id')->select('temp_transaction.*','players.reg_username')->where('proc_type', 'deposit')->orderBy('id', 'DESC')->limit(20)->get();
        $trasactionWithdraw = TempTransaction::leftJoin('players','players.id','=','temp_transaction.player_id')->select('temp_transaction.*','players.reg_username')->where('proc_type', 'withdraw')->orderBy('id', 'DESC')->limit(20)->get();
        $data = ['result' => $arrResult, 'deposit' => $trasactionDeposit, 'withdraw' => $trasactionWithdraw];
        return response()->json($data);
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
            'symbol' => $getSymbol,
            'langdefault' => $getGeneralSetting->lang,
            'siteinfo' => SiteSetting::findOrFail(1),
            'language' => Language::where('status',1)->get()
                
        ];
        //\Log::info($setGeneralSetting);
        $market = Market::getAllRecord(0, 1)->get();
        $getBankList = Bank::getAllRecord(0, 1)->get();
        $getGameList = Game::getAllRecord(0)->get();
        $getSiteLock = FrontSetting::getSiteLock();
        $getMenuFrontEnd = Menu::with(['getContent', 'getProduct', 'getCategoryProduct', 'getCategoryContent'])->where([['status', 1], ['is_trashed', 0]])->get();
        return response()->json(['general' => $setGeneralSetting, 'market' => $market->jsonSerialize(), 'bank' => $getBankList->jsonSerialize(), 'gameitem' => $getGameList->jsonSerialize(), 'sitelock' => $getSiteLock->jsonSerialize(), 'menu' => $getMenuFrontEnd->jsonSerialize()], 200);
    }

    public function getMarketGameSetting(Request $request) {
        // \Log::info($request->all());
        $market = $request->input('market');
        $game = $request->input('game');
        if (is_array($game)) {
            $getMarketGameSetting = MarketGameSetting::where('market', $market)->whereIn('game_name', $game)->orderBy('id', 'ASC')->get();
        } else {
            $getMarketGameSetting = MarketGameSetting::where('market', $market)->where('game_name', $game)->first();
            $getMarketGameSetting['bet_times'] = (int) $getMarketGameSetting->bet_times;
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

        $countBetNumber = \App\Models\FrontEnd\BetTransaction::where('gameId', $gamecode)->where('market', $marketcode)->where('period', $getPeriod)->where('guess', $numberbet)->count();
        return response()->json(['count' => $countBetNumber]);
    }

    public function article($slug) {
        $cagetory = Category::where([['slug', $slug], ['status', 1], ['is_trashed', 0]])->first();
        $post = Post::where([['category_id', $cagetory->id], ['status', 1], ['is_trashed', 0]])->paginate(5);
        
        $data = ['category' => $cagetory, 'post' => $post];
        return response()->json($data);
    }

    public function articleDetail($slug) {
        $post = Post::where([['slug', $slug], ['status', 1], ['is_trashed', 0]])->first();
        if ($post)
            return response()->json(['article' => $post]);
        else
            return response()->json(['article' => array_keys(get_object_vars($post))]);
    }

    public function product($slug) {
        $cagetory = Category::where([['slug', $slug], ['status', 1], ['is_trashed', 0]])->first();
        $product = Product::where([['category_id', $cagetory->id], ['status', 1], ['is_trashed', 0]])->paginate(5);
        $data = ['category' => $cagetory, 'product' => $product];
        return response()->json($data);
    }

    public function productDetail($slug) {
        $product = Product::where([['slug', $slug], ['status', 1], ['is_trashed', 0]])->first();
        if ($product)
            return response()->json(['product' => $product]);
        else
            return response()->json(['product' => array_keys(get_object_vars($product))]);
    }

}
