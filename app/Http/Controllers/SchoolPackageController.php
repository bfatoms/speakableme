<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SchoolPackage;

class SchoolPackageController extends Controller
{
    public function index()
    {
        return $this->response("Get All School Package",
            SchoolPackage::where('school_id', auth()->user()->school_id)
                ->where('status','active')
                ->get()
        );
    }
}
