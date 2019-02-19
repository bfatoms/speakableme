<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentRemark;
use App\Jobs\SendStudentRemarkEmail;
use App\Jobs\SystemLogger;
use App\Models\Student;
use App\Models\Teacher;
// use App\Mail\StudentRemarkEmail;

class StudentRemarkController extends Controller
{
    public function store($id)
    {
        $request = request()->all();

        $request['teacher_id'] = auth()->user()->id;

        $request['student_id'] = $id;

        $created = StudentRemark::create($request);

        if(!empty($created))
        {
            $data['student'] = Student::find($id);

            $data['teacher'] = auth()->user();

            $data['remark'] = $created;

            // send the remarks via email to student
            SendStudentRemarkEmail::dispatch($data['student']->email, $data)
                ->delay(now()->addSeconds(10));


            // \Mail::to($data['student']->email)
            //     ->locale($data['student']->lang)
            //     ->send(new StudentRemarkEmail($data));


            SystemLogger::dispatch([
                'actor_id' => (empty(auth()->user())) ? 0: auth()->user()->id,
                'actor' => ( empty(auth()->user()) ) ? 'system' : 'user',
                'description' => "A Lesson Memo was sent to " . $data['student']->email,
                'system_loggable_id' => $data['student']->email,
                'system_loggable_type' => 'user',
                'data' => json_encode($data)
            ])
            ->delay(now()->addSeconds(5));
        }
        
        return $this->respond($created, "Remark Successfully added..");
    }
}
