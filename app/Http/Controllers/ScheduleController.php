<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Schedule;
use App\Models\ClassSession;
use App\Models\ClassType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ScheduleBooking;
use App\Models\Balance;

class ScheduleController extends Controller
{
    public function store()
    {
        $data = [
            'starts_at' => request('starts_at'),
            'ends_at' => request('ends_at'),
            'user_id' => request('user_id', auth()->user()->id),
            'class_session_id' => request('session_id', ClassSession::where('system_name', 'regular')->first()->id),
            'status' => request('status', "open"),
            'subject_id' => request('subject_id', Subject::where('code','english')->first()->id),
            'class_type_id' => request('class_type_id', ClassType::find(1)->id),
            'min' => request('min', 1),
            'max' => request('max', 1),
        ];

        return $this->respond(Schedule::create($data), "Schedule Successfully Created");
    }

    public function show($id)
    {
        return $this->respond(Schedule::find($id),"Schedule Found");
    }

    public function index()
    {
        return $this->respond(Schedule::where('user_id', auth()->user()->id)->get(),"Schedule Found");
    }

    public function absent($id)
    {
        $schedule = Schedule::find($id);
        
        // close the sched if its Tutoring
        $schedule->update([
            'status' => request('teacher_absent') ? 'closed' : $schedule->status,
            'absence_reason' => request('absence_reason')
        ]);

        return $this->respond($schedule->refresh());
    }




}
