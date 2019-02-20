<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectTeacherRate;

class SubjectTeacherRateController extends Controller
{
    public function store()
    {
        $request = request()->all();
        $created = SubjectTeacherRate::create($request);
        return $this->respond($created, "Teacher Rate Successfully Created!");
    }

    public function index()
    {
        return $this->respond(
            SubjectTeacherRate::where('teacher_id', auth()->user()->id)
                ->get(),
            "Rates"
        );
    }
}
