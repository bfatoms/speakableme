<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ScheduleBooking;
use App\Models\Balance;
use App\Models\ScheduleTeacherRate;
use App\Models\TeacherRate;

class ScheduleBookingController extends Controller
{
    public function store()
    {
        $balance = Balance::with('balanceType')->find(request('balance_id'));
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
            // if class_type_id of balance and schedule is not the same do not book!!
            if($balance->balanceType->class_type_id != $schedule->class_type_id)
            {
                continue;
            }

            // before anything check if you already booked this class, skip if you did
            $previously_booked = ScheduleBooking::where('schedule_id', $schedule->id)
                ->where('user_id', request('student_id',auth()->user()->id))
                ->first();

            if(!empty($previously_booked))
            {
                continue;
            }
            
            $bookings = ScheduleBooking::where('schedule_id', $schedule->id)->get();

            //book this schedule
            if(count($bookings) < $schedule->max)
            {
                $book_schedule = $this->bookSchedule($schedule, $balance);
                
                if(!empty($book_schedule))
                {
                    // if not empty books_chedule
                    $schedule->student_provider_id = eid();

                    $schedule->save();
                }
                
                $booked[] = $book_schedule;
            }

            $this->setFullyBooked($schedule);
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
            throw new \Exception(__("Class Booked, fully-booked, or Balance is not for this class"), 424);
        }

        return $this->respond($booked, "Successfully Booked");
    }

    public function setFullyBooked($schedule)
    {
        $bookings = ScheduleBooking::where('schedule_id', $schedule->id)->get();
        // if its already full mark it as booked
        if(count($bookings) >= $schedule->max)
        {
            $schedule->status = 'booked';

            $schedule->save();
        }

        return $schedule;
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
        // get the fee from Teacher Rate table according to class_type_id

        $teacher_rate = TeacherRate::where('teacher_id', $schedule->user_id)
            ->where('student_provider_id', $schedule->student_provider_id)
            ->where('class_type_id', $schedule->class_type_id)
            ->first();

        ScheduleTeacherRate::updateOrCreate(
            ['schedule_id' => $schedule->id],
            [
                'fee' => $teacher_rate->rate,
                'currency_code' => $teacher_rate->currency_code,
                'teacher_id' => $schedule->user_id,
                'schedule_id' => $schedule->id
            ]
        );

        return $teacher_rate;
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
                SendCancelledScheduleEmail::dispatch($data['student']->email, $data);
            }
        }
        // Incur the highest penalty for teacher
        $this->setTeacherPenalty($schedule, config('speakable.penalty3'), "Penalty 3 for being absent");
        
        return $this->respond($schedule->refresh());
    }

}
