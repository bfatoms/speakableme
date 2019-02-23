<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Subject;
use App\Models\Balance;
use App\Models\Schedule;
use App\Models\ClassType;
use App\Models\BalanceType;
use App\Models\ClassSession;
use App\Models\ScheduleBooking;
use App\Models\ScheduleTeacherRate;

use App\Jobs\SystemLogger;
use App\Jobs\SendCancelledScheduleEmail;
use App\Models\Student;


class ScheduleController extends Controller
{
    public function store()
    {
        $schedule = Schedule::where('starts_at', Carbon::parse(request('starts_at'))->tz('UTC'))
            ->where('user_id', request('user_id', auth()->user()->id))
            ->first();

        if(!empty($schedule))
        {
            throw new \Exception("You cannot book same time and hour", 416);
        }

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
            'teacher_provider_id' => request('teacher_provider_id',auth()->user()->entity_id)
        ];

        return $this->respond(Schedule::create($data), "Schedule Successfully Created");
    }

    public function show($id)
    {
        return $this->respond(Schedule::find($id),"Schedule Found");
    }

    public function index()
    {
        return $this->respond(
            Schedule::where('user_id', auth()->user()->id)->get(),
            "Schedule Found"
        );
    }

    public function returnBalance(Schedule $schedule, $book)
    {
        $balance = Balance::find($book->balance_id);

        if($schedule->class_type_id === 1)
        {
            $balance = Balance::where('schedule_id', $schedule->id)
                ->where('balance_type_id', 2)
                ->first();
        }

        $balance->remaining++;

        $balance->save();
    }

    public function absent($id)
    {
        $schedule = Schedule::find($id);
        // close the schedule
        $absent = $schedule->update([
            'status' => 'closed',
            'absence_reason' => request('absence_reason'),
            'is_teacher_absent' => true,
            'actor_id' => auth()->user()->id,
            'actor_message' => $schedule->actor_message . "\n" . auth()->user()->id
        ]);
        // if teacher is absent return the balance as immortal (non-expiring)..
        if($absent)
        {
            // find the balance_type for immortal
            $bookings = ScheduleBooking::where('schedule_id', $schedule->id)->get();

            foreach($bookings as $book)
            {
                // return to group balance if the class is type group class
                $this->returnBalance($schedule, $book);
                // send notification that the class has been cancelled and balance was returned as non-expiring
                $student = Student::find($book->user_id);

                $data = array_merge(
                    ['student' => $student],
                    ['schedule'=> $schedule]
                );
                // send Registration Data to email
                SendCancelledScheduleEmail::dispatch($data['student']->email, $data);
            }
        }
        // Incur the highest penalty for teacher
        $this->setTeacherPenalty($schedule, config('speakable.penalty3'), "Penalty 3 for being absent");
        
        return $this->respond($schedule->refresh());
    }

    public function cancel($id)
    {
        $schedule = Schedule::find($id);
        // close the schedule
        $absent = $schedule->update([
            'status' => 'closed',
            'absence_reason' => request('absence_reason')
        ]);
        // if teacher is absent return the balance as immortal (non-expiring)..
        if($absent)
        {
            // find the balance_type for immortal
            $bookings = ScheduleBooking::where('schedule_id', $schedule->id)->get();

            foreach($bookings as $book)
            {
                // return to group balance if the class is type group class
                $this->returnBalbookance($schedule, $book);

                // send notification that the class has been cancelled and balance was returned as non-expiring
                $student = Student::find($book->user_id);

                $data = array_merge(
                    ['student' => $student],
                    ['schedule'=> $schedule]
                );
                // send Registration Data to email
                SendCancelledScheduleEmail::dispatch($data['student']->email, $data);
            }
        }
        // set teacher penalty
        $this->setTeacherPenalty($schedule);

        return $this->respond($schedule->refresh());   
    }

    public function setTeacherPenalty(Schedule $schedule, $penalty = null, $note = null)
    {
        if(empty($penalty))
        {
            // check if the dates are more than 
            $starts_at = Carbon::parse($schedule->starts_at);
            // if 2 hrs before class start penalty
            $now = now();

            $penalty = config('speakable.penalty1');
            $note = "\nIncurred penalty 2 for cancelling a schedule.";

            if($starts_at->diffInHours($now) < 4)
            {
                $penalty = config('speakable.penalty2');
                $note = "\nIncurred penalty 2 for cancelling a schedule.";
            }

            if($starts_at->diffInHours($now) < 2)
            {
                $penalty = config('speakable.penalty3');
                $note = "\nIncurred penalty 3 for cancelling a schedule.";
            }
        }

        $rate = ScheduleTeacherRate::where('schedule_id', $schedule->id)->first();

        $rate->penalty = $penalty;

        $rate->fee = null;

        $rate->note .= "\n".$note;

        $rate->save();

        return $rate;
    }

    public function students($id)
    {
        $student_ids = ScheduleBooking::where('schedule_id', $id)->get()->pluck('user_id');
        
        $students = Student::whereIn('id', $student_ids)->get();
        
        return $this->respond($students);
    }

    public function availableTeachers($datetime = null)
    {
        $datetime = $datetime ? Carbon::parse($datetime)->tz('UTC') : now();

        $datetime->addMinutes(30);

        $provider_id = request('student_provider_id', eid());

        $teachers = Schedule::with('teacher')
            ->whereBetween('starts_at', [$datetime->format('Y-m-d H:i:s'), $datetime->format("Y-m-d 23:59:00")])
            ->where('status', 'open')
            ->whereRaw("(student_provider_id is null or student_provider_id = '$provider_id')")
            ->get();

        $count = count($teachers);
        
        if($count == 0)
        {
            return $this->respond([],'No Teachers Found at this moment', 404);
        }
        
        $word = str_plural('Teacher', $count);
        
        return $this->respond($teachers->pluck('teacher'), "$count $word Found!");
    }

    public function availableTeacherSchedule($id, $datetime = null)
    {
        // get all teachers available to teach from the given datetime
        $datetime = Carbon::parse($datetime)->tz('UTC') ?? now();

        $datetime->addMinutes(30);

        $provider_id = request('student_provider_id', eid());

        return Schedule::where('status', 'open')
            ->where('starts_at', '>=', $datetime->format('Y-m-d H:i:s'))
            ->where('user_id', $id)
            ->whereRaw("(student_provider_id is null or student_provider_id = '$provider_id')")
            ->get();
    }

}
