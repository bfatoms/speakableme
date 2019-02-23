<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balance;

class BalanceController extends Controller
{
    public function index()
    {
        $balances = Balance::where('user_id', request('user_id', auth()->user()->id))
            ->whereRaw('(validity > "'.now()->format('Y-m-d H:i:s').'" or validity is null)')
            ->where('remaining','>',0)
            ->oldest()
            ->get();
        
        return $this->respond($balances, "Balances");
    }
}
