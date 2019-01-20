<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon;

class BookClassController extends Controller
{
    protected $roles;

    public function __construct()
    {
        $this->roles = config('app.roles');
    }

    public function index()
    {
        return BookClass::where('student_id', auth()->user()->id)->get();
    }


    public function cancelBooking(Request $request) {
        $class = BookClass::where("id", $request->id)->first();
        $timezone = auth()->user()->timezone;
        $now = new \DateTime('now', new \DateTimeZone($timezone));
        $start = new \DateTime($class->start_at, new \DateTimeZone($timezone));
        $info = "Not Allowed to Cancel";
        if($this->roles[auth()->user()->role_id] == "student") {
            $class->actor = "student";

            $start->sub(new \DateInterval("PT1H"));
            if( ($now->getTimestamp() < $start->getTimestamp()) && $class->status =="booked") {
                // delete the 
                $class->status = "cancelled";

                // return to teacher the availability
                $availability = Availability::find($class->availability_id);
                $availability->status = "open";
                // return the credit to student respective packages

                if($class->order_id == "0"){
                    $order = User::find($class->student_id);
                    $order->immortal = (intval($order->immortal) + 1);

                }
                elseif($class->order_id == "free") {
                    $order = User::find($class->student_id);
                    $order->free_trial_consumable = (intval($order->free_trial_consumable ) + 1);
                }
                elseif($class->order_id[0]=="r"){
                    $ref = explode("-",$class->order_id);
                    $order = Referral::find($ref[1]);                    
                    $order->referral_consumable = (intval($order->referral_consumable) + 1);
                }
                else{
                    $order = Order::find($class->order_id);
                    $order->remaining_reservation = (intval($order->remaining_reservation) + 1);
                }

                $result1 = $availability->save(); // return availability
                $result2 = $order->save(); // return credit to student
                $result3 = $class->save();
                if( $result1 == true && $result2 == true && $result3 == true){
                    $info = "Class Successfully Cancelled";
                }
                // also remove the notification from the queue
                if($class->job_ids != null){
                    $job_ids = json_decode($class->job_ids);
                    $job = Job::find($job_ids->id);
                    if($job != null){ $job->delete(); }

                    $job = Job::find($job_ids->id2);
                    if($job != null){ $job->delete(); }
                }

                $teacher = User::where('id',$class->teacher_id)->first(['nick','email']);
                $student = User::where('id',$class->student_id)->first(['nick','email']);


                $class_start = new \DateTime($class->start_at);
                $class_end = new \DateTime($class->end_at);
                $class_id = $class_start->format("d-M-y-H:i")."-". $class_end->format("H:i") ."-".$class->id;

                // now lets send booking cancellation to teacher
                $now =  new \DateTime(null, new \DateTimeZone("UTC"));
                $now->add(new \DateInterval("PT1M"));
                $body = new \stdClass();
                $body->teacher_data = $teacher;
                $body->student_data = $student;
                $body->schedule = $class->start_at;
                $body->class_id = $class_id;
                $emailJob = (new SendEmailJob($teacher->email, "student_cancelled_class", $body))->delay($now);
                $id  = app(Dispatcher::class)->dispatch($emailJob);
                //$class->delete();

            }
        }
        
        else if( $this->roles[auth()->user()->role_id] == "teacher" ) {

            $class->actor = "teacher";
            $status = "penalty 3";
            $penalty = Penalty::where("name", $status)->where("actor",$class->actor)->first();
            $penalty_rate = $penalty->value_in_php;

            if($now->getTimestamp() <= $start->sub(new \DateInterval("PT2H"))->getTimestamp() ) {
                $status = "penalty 2";
                $penalty = Penalty::where("name", $status)->where("actor",$class->actor)->first();
                $penalty_rate = $penalty->value_in_php;
            }

            // now lets add 2 hrs again
            $start->add(new \DateInterval("PT2H"));

            if($now->getTimestamp() <= $start->sub(new \DateInterval("PT6H"))->getTimestamp() ){
                $status = "penalty 1";
                $penalty = Penalty::where("name", $status)->where("actor", $class->actor)->first();
                $penalty_rate = $penalty->value_in_php;
            }

            if( $status == "penalty 1" || $status == "penalty 2" || $status == "penalty 3") {
                $class->class_fee = null;

                //asdasd
            }

            //return $status;

            if($class->status =="booked") {
                // delete the 
                $class->status = $status;
                $class->penalty_fee = $penalty_rate;

                $availability = Availability::where("teacher_id", $class->teacher_id)
                    ->where('start_at', $class->start_at)
                    ->first();
                $availability->status = $status;
                // lets delete the availability to prevent from showing up on search results
                $result = $availability->save();
                $class->teacher_absent = "yes";
                $class->teacher_reason_for_absence = "notify absence";

                $order = "";
                // return the credit to student respective packages
                if($class->order_id == "free") {
                    $order = User::find($class->student_id);
                    $order->free_trial_consumable = (intval($order->free_trial_consumable ) + 1);
                }
                elseif($class->order_id[0]=="r"){
                    $ref = explode("-",$class->order_id);
                    $order = Referral::find($ref[1]);                    
                    $order->referral_consumable = (intval($order->referral_consumable) + 1);
                }
                else{
                    $order = User::find($class->student_id);
                    $order->immortal = (intval($order->immortal) + 1);
                }
                $result2 = $order->save();
                $result3 = $class->save();

                if($result2 == true && $result3 == true){
                    // also remove the notification from the queue
                    if($class->job_ids != null) {
                        $job_ids = json_decode($class->job_ids);
                        $job = Job::find($job_ids->id);
                        if($job != null){ $job->delete(); }

                        $job = Job::find($job_ids->id2);
                        if($job != null){ $job->delete(); }
                    }

                    // notify student and admin
                    $teacher = User::where('id', $class->teacher_id)->first(['nick','email']);
                    $student = User::where('id', $class->student_id)->first(['nick','email','lang']);

                    $class_start = new \DateTime($class->start_at);
                    $class_end = new \DateTime($class->end_at);
                    $class_id = $class_start->format("d-M-y-H:i")."-". $class_end->format("H:i") ."-".$class->id;

                    // now lets send booking cancellation to teacher
                    $now = new \DateTime(null, new \DateTimeZone("UTC"));
                    $now->add(new \DateInterval("PT1M"));
                    $body = new \stdClass();
                    $body->teacher_data = $teacher;
                    $body->student_data = $student;
                    $body->schedule = $class->start_at;
                    $body->class_id = $class_id;
                    if($student->lang == "zh-cn") {
                        $emailJob = (new SendEmailJob($student->email, "teacher_cancelled_class_zh_cn", $body))->delay($now);
                    }else{
                        $emailJob = (new SendEmailJob($student->email, "teacher_cancelled_class", $body))->delay($now);
                    }
                    
                    $id  = app(Dispatcher::class)->dispatch($emailJob);

                    $info = "Successfully marked this class as penalty";
                }
                
            }
            // if its booked dont cancel it...
            // "Cancelling a booking will become penalty status";
        }

        return $info;
    }
}
