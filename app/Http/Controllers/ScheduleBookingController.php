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
        $ids = request('ids');

        if(!is_array($ids))
        {
            $ids = explode(",", $ids);
        }

        $schedules = Schedule::whereIn('id', $ids)->where('status', 'open')->get()->filter();
        // get his/her balance
        $balance = Balance::find(request('balance_id'));

        if(empty($balance) || $balance->remaining === 0)
        {
            throw new \Exception(__("BOOKING_WITH_ZERO_BALANCE_IS_FORBIDDEN"), 403);
        }

        $booked = [];

        foreach($schedules as $schedule)
        {
            // check if this schedule is group,
            if($schedule->class_type_id === 2)
            {
                // if group check the settings, min and max
                $bookings = ScheduleBooking::where('schedule_id', $schedule->class_type_id)->get();
                // if bookings is less than the max, then it is still available
                if(count($bookings) < $schedule->max)
                {
                    $booked[] = $this->bookSchedule($schedule, $balance);
                }
                // refresh the bookings after the above to get latest
                $bookings->fresh();
                // if its already full mark it as booked
                if(count($bookings) >= $schedule->max)
                {
                    $schedule->status = 'booked';

                    $schedule->save();

                    // once the schedule has been fully booked, we create the rate for this teacher
                    $this->createTeacherRate($schedule);
                }
            }
            else
            {
                if(!empty($booked[] = $this->bookSchedule($schedule, $balance)))
                {
                    $schedule->status = 'booked';

                    $schedule->save();

                    $this->createTeacherRate($schedule);
                }
            }

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
        if($created)
        {
            $balance->remaining = ($balance->remaining - 1);

            $balance->save();
            // save this created to the booked
            return $created;
        }

        return [];
    }

    public function createTeacherRate($schedule)
    {
        // get the fee from Subject Teacher Rate
        $subject_teacher = SubjectTeacherRate::find($schedule->user_id);

        ScheduleTeacherRate::updateOrCreate(
            ['schedule_id' => $schedule->id],
            [
                'fee' => $subject_teacher->rate,
                'currency_code' => $subject_teacher->currency_code,
                'teacher_id' => $schedule->user_id,
                'schedule_id' => $schedule->id
            ]
        );
    }

}
