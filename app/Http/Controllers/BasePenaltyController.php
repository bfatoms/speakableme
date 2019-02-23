<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BasePenalty;

class BasePenaltyController extends Controller
{
    public function store()
    {
        $created = BasePenalty::create(request()->all());
        return $this->respond($created, "Base Penalty Successfully Created");
    }
}
