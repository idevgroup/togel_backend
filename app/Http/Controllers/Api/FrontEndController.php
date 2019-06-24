<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FrontEnd\Bank;
use Response;
class FrontEndController extends Controller
{
    public function getBank(){
        $getBankList = Bank::getAllRecord(0, 1)->get();
        return response($getBankList->jsonSerialize());
    }
}
