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
use App\Models\ScheduleTeacherRate;
use App\Models\SubjectTeacherRate;

class ScheduleBookingController extends Controller
{
    public function store()
    {
        $balance = Balance::find(request('balance_id'));
        // check balance first
        if(empty($balance) || $balance->remaining === 0)
        {
            throw new \Exception(__("BOOKING_WITH_ZERO_BALANCE_IS_FORBIDDEN"), 403);
        }

        $ids = request('ids');

        if(!is_array($ids))
        {
            $ids = explode(",", $ids);
        }

        $schedules = Schedule::whereIn('id', $ids)->where('status', 'open')->get()->filter();
        // get his/her balance

        $booked = [];

        foreach($schedules as $schedule)
        {
            $bookings = ScheduleBooking::where('schedule_id', $schedule->class_type_id)->get();
            //book this schedule
            if(count($bookings) < $schedule->max)
            {
                $booked[] = $this->bookSchedule($schedule, $balance);
            }
            $bookings->fresh();
            // if its already full mark it as booked
            if(count($bookings) >= $schedule->max)
            {
                $schedule->status = 'booked';

                $schedule->save();
            }
            // create the schedule
            $this->createTeacherRate($schedule);


            // if balance is 0 break the operation
            if($balance->remaining <= 0)
            {
                break;
            }

        }

        if(empty($booked))
        {
            throw new \Exception(__("Class is already fully-booked."), 424);
        }

        return $this->respond($booked, "Successfully Booked");
    }

    public function bookSchedule($schedule, $balance)
    {
        $created = ScheduleBooking::create([
            'user_id' => request('user_id', auth()->user()->id),
            'balance_id' => $balance->id,
            'schedule_id' => $schedule->id,
        ]);
        // if created subtract 1 from the balance
        if(!empty($created))
        {
            $balance->remaining = ($balance->remaining - 1);

            $balance->save();

            return $created;
        }

        return [];
    }

    public function createTeacherRate($schedule)
    {
        // get the fee from Subject Teacher Rate
        $subject_teacher = SubjectTeacherRate::where('teacher_id', $schedule->user_id)
            ->where('entity_id', $schedule->entity_id)
            ->where('entity_id')
            ->first();

        ScheduleTeacherRate::updateOrCreate(
            ['schedule_id' => $schedule->id],
            [
                'fee' => $subject_teacher->rate,
                'currency_code' => $subject_teacher->currency_code,
                'teacher_id' => $schedule->user_id,
                'schedule_id' => $schedule->id
            ]
        );

        return $rate;
    }


    public function absent($id)
    {
        $schedule = Schedule::find($id);

        $students = request('students');

        foreach($students as $student)
        {
            // mark each student as absent if all students are absent close
            // the class and pay teacher half of the price
            $student = ScheduleBooking::find($id);

        }

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
                $this->returnBalance($schedule);

                // send notification that the class has been cancelled and balance was returned as non-expiring
                $student = Student::find($book->user_id);

                $data = array_merge(
                    ['student' => $student],
                    ['schedule'=> $schedule]
                );
                // send Registration Data to email
                SendCancelledScheduleEmail::dispatch($email['student']->email, $data);
            }
        }
        // Incur the highest penalty for teacher
        $this->setTeacherPenalty($schedule, config('speakable.penalty3'), "Penalty 3 for being absent");
        
        return $this->respond($schedule->refresh());
    }

}
