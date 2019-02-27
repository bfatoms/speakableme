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
use App\Models\BaseTeacherPenalty;


class ScheduleController extends Controller
{
    public function store()
    {
        $created = [];

        $requests = request()->all();

        $session = ClassSession::where('system_name', 'regular')->first();

        $subject = Subject::where('code','english')->first();

        $class_type = ClassType::find(1);
        // find schedules that you already open that has the same starts_at
        foreach($requests as $request)
        {
            $request = (object) $request;

            $schedule = Schedule::where('starts_at', Carbon::parse($request->starts_at)->tz('UTC'))
                ->where('user_id', $request->user_id ?? auth()->user()->id)
                ->first();

            if(!empty($schedule))
            {
                continue;
            }

            $data = [
                'starts_at' => $request->starts_at,
                'ends_at' => $request->ends_at,
                'user_id' => $request->user_id ?? auth()->user()->id,
                'class_session_id' => $request->session_id ?? $session->id,
                'status' => $request->status ?? "open",
                'subject_id' => $request->subject_id ?? $subject->id,
                'class_type_id' => $request->class_type_id ?? $class_type->id,
                'min' => $request->min ?? 1,
                'max' => $request->max ?? 1,
                'teacher_provider_id' => $request->teacher_provider_id ?? auth()->user()->entity_id
            ];

            $created[] = Schedule::create($data);
        }

        return $this->respond($created, "Schedule Successfully Created");
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

    public function returnBalance(Schedule $schedule, $book, $immortal = false)
    {
        $balance = Balance::find($book->balance_id);
        // if return as immortal, find the balance type that belongs to this user, based on class Type
        if($immortal === true)
        {
            $balance_type = BalanceType::where('class_type_id', $schedule->class_type_id)
                ->where('name', 'immortal')
                ->first();

            $balance = Balance::where('balance_type_id', $balance_type->id)
                ->where('user_id', $book->user_id)
                ->first();
            // if immortal balance doesn't exist create it, and use that for addition
            if(empty($balance))
            {
                $balance = Balance::create([
                    'total' => 0,
                    'remaining' => 0,
                    'user_id' => $book->user_id,
                    'balance_type_id' => $balance_type->id
                ]);
            }
        }

        $balance->remaining++;

        $balance->save();

        return $balance;
    }

    public function absent($id)
    {
        $schedule = Schedule::find($id);
        // if schedule is already cancelled return error
        if($schedule->status != "booked")
        {
            return $this->respond([], 'Class has been cancelled..',403);
        }
        // close the schedule
        $absent = $schedule->update([
            'status' => 'cancelled',
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
                // return to balance if the class is type group class
                $this->returnBalance($schedule, $book, true);
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
        $this->setTeacherPenalty($schedule);
        
        return $this->respond($schedule->refresh());
    }

    public function cancel($id)
    {
        $schedule = Schedule::find($id);
        // if schedule is already cancelled return error
        if($schedule->status != "booked")
        {
            return $this->respond([], 'Class has been cancelled..',403);
        }
        // close the schedule
        $cancel = $schedule->update([
            'status' => 'cancelled',
            'absence_reason' => request('absence_reason')
        ]);
        // if teacher is absent return the balance as immortal (non-expiring)..
        if($cancel)
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
        // set teacher penalty
        $this->setTeacherPenalty($schedule, 'cancelling');

        return $this->respond($schedule->refresh());   
    }

    public function setTeacherPenalty(Schedule $schedule, $name = 'absent')
    {
        // get all penalties for teacher
        $penalties = BaseTeacherPenalty::where('teacher_provider_id', $schedule->teacher_provider_id)
            ->where('student_provider_id', $schedule->student_provider_id)
            ->where('class_type_id', $schedule->class_type_id)
            ->orderBy('rate', 'desc')
            ->get();

        $penalty_rate = $penalties->max('rate');

        $note = "Incurred ".$penalties->first()->name." for being ".$name.".";

        // get penalty based on hour
        if($name === 'cancelling')
        {
            // check if the dates are more than 
            $starts_at = Carbon::parse($schedule->starts_at);
            // if 2 hrs before class start penalty
            $now = now();

            foreach($penalties as $penalty)
            {
                if($starts_at->diffInHours($now) > $penalty->incur_at)
                {
                    $penalty_rate = $penalty->rate;

                    $note = "Incurred ".$penalty->name." for ".$name." schedule.";
                }
            }

        }

        $rate = ScheduleTeacherRate::where('schedule_id', $schedule->id)->update([
            'penalty' => $penalty_rate,
            'fee' => null,
            'note' => "$note",
        ]);

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

        $teachers = Schedule::with(['teacher' => function($q){
            $q->select(['id', 'nick', 'avatar']);
        }])
            ->whereBetween('starts_at', [$datetime->format('Y-m-d H:i:s'), $datetime->format("Y-m-d 23:59:00")])
            ->where('status', 'open')
            ->whereRaw("(student_provider_id is null or student_provider_id = '$provider_id')")
            ->get()->pluck('teacher')->unique();

        $count = count($teachers);
        
        if($count == 0)
        {
            return $this->respond([],'No Teachers Found at this moment', 404);
        }
        
        $word = str_plural('Teacher', $count);
        
        return $this->respond($teachers, "$count $word Found!");
    }

    public function availableTeacherSchedule($id, $datetime = null)
    {
        // get all teachers available to teach from the given datetime
        $datetime = Carbon::parse($datetime)->tz('UTC') ?? now();

        $datetime->addMinutes(30);

        $provider_id = request('student_provider_id', eid());

        return $this->respond(Schedule::where('status', 'open')
            ->where('starts_at', '>=', $datetime->format('Y-m-d H:i:s'))
            ->where('user_id', $id)
            ->whereRaw("(student_provider_id is null or student_provider_id = '$provider_id')")
            ->get());
    }

}
