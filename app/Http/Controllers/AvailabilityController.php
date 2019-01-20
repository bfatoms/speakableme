<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;
use App\Availability;
use App\BookClass;
use App\User;

use App\Order;
use App\TeacherAccountType;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AvailabilityController extends Controller
{
    public function index(Request $request)
    {
        return $this->response("Available Classes", QueryBuilder::for(Availability::class)
            ->allowedIncludes('teacher')
            ->allowedFilters([
                Filter::scope('starts_after'),
            ])
            ->get());

    }

    public function searchAvailable(Request $request)
    {
        $newDateTime = new \DateTime($request->start_datetime, new \DateTimeZone(auth()->user()->timezone));

        $today = new \DateTime("now", new \DateTimeZone( auth()->user()->timezone ) );
        $today->add(new \DateInterval("PT30M"));

        $datetime = explode(" ", $newDateTime->format("Y-m-d 00:00:00"));
        

        // we always receive date and no time so we need to fill time to current time if it is today
        if( $today->format("d") == $newDateTime->format("d") ) {
            $datetime = explode(" ", $today->format("Y-m-d H:i:s"));
        }

        $list = DB::table('users')
            ->join('availabilities', 'users.id', '=', 'availabilities.teacher_id')
            ->groupBy('users.id','nick','avatar','users.timezone')
            ->select('users.id','nick', 'avatar','users.timezone')
            ->where("start_at",">=", implode($datetime," ") )
            ->where("start_at","<=", $datetime[0]." 23:59")
            ->where("status","open")
            ->get();

        return $list;
    }

    public function getAvailableTeacher(Request $request)
    {

        $today = new \DateTime("now", new \DateTimeZone( auth()->user()->timezone ));
        $today->add(new \DateInterval("PT30M"));

        $user = BookClass::select('start_at')
                ->where("start_at", ">=", $today->format("Y-m-d 00:00:00"))
                ->where('student_id', auth()->user()->id)->where("status","booked")->get();

        $list = Availability::whereNotIn('start_at', $user)->where("start_at",">=", $today->format("Y-m-d H:i:s"))->where('status','open')->where('teacher_id', $request->id)->get();
        
        $json = [];

        foreach($list as $item){
            $data = [];
            $data["title"] = $item->status;
            $data["status"] = $item->status;
            $data["start"] = date("c",strtotime($item->start_at));
            $data["end"] = $item->end_at;
            $data["id"] = $item->id;
            $now = new \DateTime($data["start"]);
            $end = $now->format("Y-m-d 23:59:00");
            $start = $now->format("Y-m-d 00:00:00");
            // check if this user has 2 booked class that has a free-trial session
            $count = Availability::where("session","free-trial")->where("start_at",">",$start)->where("end_at","<",$end)->count();
            $data["free_trial_count"] = $count;
            $json[] = $data;
        }
        //2018-04-26T04:21:13.942Z
        //Y-M-dTH:i:s.
        return json_encode($json);
    }

    public function bookAvailableSchedule(Request $request)
    {
        $data = json_decode(json_encode($request->post()));
        $total_booked = count($data->classes);
        //return json_encode($data);
        $order = "";
        $remaining = 0;
        if($data->order_id == "0"){
            $order = User::find( auth()->user()->id );
            $remaining = $order->immortal;
        }
        elseif($data->order_id == "free"){
            $order = User::find(auth()->user()->id );
            $remaining = $order->free_trial_consumable;
        }
        elseif($data->order_id[0]=="r"){
            $ref = explode("-",$data->order_id);
            $order = Referral::find($ref[1]);
            $remaining = $order->referral_consumable;
        }
        else{
            $order = Order::find($data->order_id);                
            $remaining = $order->remaining_reservation;
        }


        // if the remaining class on order is greater means, it can still fit all of the booked classes so we use the total booked class
        //else we use the remaining classes only so that it will discard the other classes
        $schedule = [];

        $teacher_data = User::where('id', $data->teacher_id)->first(['teacher_account_type_id','nick','email',"lang","timezone"]);
        // dd($teacher_data);
        $student_data = User::where('id', auth()->user()->id)->first(["nick","email","lang","timezone"]);
        // dd($student_data);
        $account_type = TeacherAccountType::where("id", $teacher_data->teacher_account_type_id)->first();
        // dd($account_type);
        foreach($data->classes as $class) {
            if($remaining > 0) {

                try{
                    $class->start = str_replace(".000Z", "", str_replace("T"," ", $class->start));
                    $class->end = str_replace(".000Z", "", str_replace("T"," ", $class->end));
                    // dd($class->end);
                    // check if this teacher has had a booked, penalty 1, penalty 2, penalty 3
                    $result = BookClass::where("status", "<>", "cancelled")
                        ->where("start_at", $class->start)
                        ->where("teacher_id", $data->teacher_id)
                        ->count();
                    if($result == 0) {

                        $plot = new BookClass();
                        $plot->start_at = $class->start;
                        $plot->end_at = $class->end;
                        $plot->status = $class->status;
                        $plot->availability_id = $class->id;
                        $plot->teacher_id = $data->teacher_id;
                        $plot->teacher_timezone = $teacher_data->timezone;
                        $plot->class_fee = $account_type->rate;
                        if($data->order_id =="free") {
                            $plot->session = "free-trial";
                            $plot->class_fee = null;
                        }
                        $plot->order_id = $data->order_id;
                        $schedule [] = $class->start;
                        $plot->student_id = auth()->user()->id;
                        $plot->student_timezone = $student_data->timezone;

                        $success = $plot->save();

                        if($success == true) {

                            // also update teacher availability
                            $availability = Availability::find($class->id);
                            $availability->status = "booked";
                            if($data->order_id =="free") {
                                $availability->session = "free-trial";
                            }
                            $availability->save();
                            // subtract from App\Orders remaining Classes
                            $remaining--;

                            // Notify both Teacher and student on the 2 hrs before the indicated class start
                        
                            // send an email before the class starts to students and teachers first
                            $teacher = new \stdClass();
                            $teacher->nick = $teacher_data->nick;

                            $student = new \stdClass();
                            $student->nick = $student_data->nick;


                            $class_start = new \DateTime($class->start);
                            $class_end = new \DateTime($class->end);
                            $class_id = $class_start->format("d-M-y-H:i")."-". $class_end->format("H:i") ."-".$class->id;

                            $body = new \stdClass();
                            $body->teacher_data = $teacher;
                            $body->student_data = $student;
                            $body->schedule = $class->start;
                            $body->class_id = $class_id;

                            // send email to teacher
                            $now =  new \DateTime($class->start, new \DateTimeZone(auth()->user()->timezone));
                            $now->sub(new \DateInterval("PT2H"));
                            $now->setTimeZone( new \DateTimeZone("UTC") );

                            $id = SendEmailJob::dispatch($teacher_data->email, "book_class_teacher", $body)->delay(now());
                            // $emailJob = (new SendEmailJob($teacher_data->email, "book_class_teacher", $body))->delay($now);
                            // $id = $emailJob->dispatch();

                            // $id  = app(Dispatcher::class)->dispatch($emailJob);

                            if($student_data->lang == "zh-cn"){
                                // send email to students
                                $id2 = SendEmailJob::dispatch($student_data->email, "book_class_student_zh_cn", $body)->delay(now());
                                // $emailJob = (new SendEmailJob($student_data->email, "book_class_student_zh_cn", $body))->delay($now);
                            }else{
                                // send email to students
                                $id2 = SendEmailJob::dispatch($student_data->email, "book_class_student_zh_cn", $body)->delay(now());
                                // $emailJob = (new SendEmailJob($student_data->email, "book_class_student", $body))->delay($now);
                            }
                            
                            // $id2 = $emailJob->dispatch();
                            // $id2  = app(Dispatcher::class)->dispatch($emailJob);

                            $job_ids = new \stdClass();
                            $job_ids->id = $id;
                            $job_ids->id2 = $id2;

                            $job_id = json_encode($job_ids);
                            $plot->job_ids = $job_id;
                            $plot->save();
                        }

                    } // send email

                }catch(QueryException $qe) {}

            }// if remaining is greater than 0
            

        }// end for


        // save the data before returning
        if($data->order_id == "0") {
            $order->immortal = $remaining;
        }
        elseif($data->order_id == "free") {
            $order->free_trial_consumable = $remaining;
        }
        elseif($data->order_id[0] == "r") {
            $order->referral_consumable = $remaining;
        }
        else{
            $order->remaining_reservation = $remaining;
        }

        $success = $order->save();
        $result = "Some Error Occurred";
        if($success == true ){
            $result = "true";
        }

        // to save bandwidth; we only send 1 immediate email when you book a class to the teacher and the student

        // send to teacher the date and time of all the class booked by the student
        //return new BookClassMail($teacher_data,$student_data,$schedule);
        $now = new \DateTime(null, new \DateTimeZone("UTC"));
        $now->add(new \DateInterval("PT1H"));
        $body = new \stdClass();
        $body->teacher_data = $teacher_data;
        $body->student_data = $student_data;
        $body->schedule = $schedule;

        SendEmailJob::dispatch($teacher_data->email, "book_class", $body)->delay(now());
        // $emailJob = (new SendEmailJob($teacher_data->email, "book_class", $body))->delay($now);
        // $emailJob->dispatch();
        // dispatch($emailJob);

        return $result;

    }

}
