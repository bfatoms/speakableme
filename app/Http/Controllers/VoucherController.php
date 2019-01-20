<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        return Voucher::where("school_id", auth()->user()->school_id)->get();
    }
}
