<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentAccountType;

class StudentAccountTypeController extends Controller
{
    public function index()
    {
        return StudentAccountType::all();
    }
}
