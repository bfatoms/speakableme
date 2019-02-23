<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BaseRate;

class BaseRateController extends Controller
{
    public function store()
    {
        $created = BaseRate::create(request()->all());
        return $this->respond($created, "Base Rate Created");
    }
}
