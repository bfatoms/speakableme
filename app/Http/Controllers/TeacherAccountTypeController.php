<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherAccountType;

class TeacherAccountTypeController extends Controller
{
    public function index()
    {
        return TeacherAccountType::all();
    }
}
