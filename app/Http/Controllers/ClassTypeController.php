<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassType;

class ClassTypeController extends Controller
{
    public function index()
    {
        return $this->respond(ClassType::all());
    }
}
