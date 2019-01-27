<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Order;
use App\Referral;
use App\User;
use App\Student;
use App\BookClass;
use App\StudentAccountType;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;

class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        
    }
    
    public function getLanguage($lang = false)
    {
        if($lang != false){
            $filepath = resource_path("lang")."/".$lang."/language.json";
            return $this->response('User Language', json_decode(file_get_contents($filepath)));    
        }
        $filepath = resource_path("lang")."/".auth()->user()->lang."/language.json";
        return $this->response('User Language', json_decode(file_get_contents($filepath)));
    }

    public function getBalance()
    {

        $referrals = Referral::where('referrer_id', auth()->user()->id)
            ->where('referral_consumable','>',0)
            ->get(["id","referral_consumable as balance","referral_valid_until as validity"]) ?? [];
        
        $referral = $referrals->map(function($item, $key) {
            $data["id"] = "r-".$item["id"]; 
            $data["balance"] = $item["balance"];
            $data["validity"] = $item["validity"];
            $data["name"] = "Active Referral";
            return $data;
        });

        $orders = Order::where('student_id', auth()->user()->id)
            ->where('status', 'active')
            ->where('remaining_reservation','>', 0)
            ->get(["id","remaining_reservation as balance", "effective_until as validity", "name"]) ?? [];

        $order = $orders->map(function($item, $key) {
            $data["id"] = (string)$item["id"]; 
            $data["balance"] = $item["balance"];
            $data["validity"] = $item["validity"];
            $data["name"] = $item["name"];
            return $data;
        });
    
        
        return $this->response("Get Balance",[
            'free' => [
                "id" => "free",
                "balance" => auth()->user()->free_trial_consumable ?? 0,
                "validity" => auth()->user()->free_trial_valid_until,
                "name" => "free-trial"
            ],
            'immortal' => [
                "id" => "0" ,
                "balance" => auth()->user()->immortal ?? 0,
                "validity" => "0000-00-00 00:00:00",
                "name" => "immortal"
            ],
            'referrals' => $referral,
            'orders' => $order,
        ]);
    }

    public function getClassSchedule(){

        $list = BookClass::where("student_id", auth()->user()->id)
            ->whereIn("status", [
                "booked",
                "completed",
                "penalty 3",
                "lesson memo delay"])
            ->where("teacher_absent","no")
            ->get();

        $json = [];
        foreach($list as $item) {
            if($item->teacher_reason_for_absence == null) {        
                $teacher = User::where("id", $item->teacher_id)->first(["email","nick"]);
                $data = [];
                $data["title"] = "Teacher ".$teacher->nick;
                $data["teacher_id"] = $item->teacher_id;
                $data["status"] = $item->status;
                $data["start"] = date("c",strtotime($item->start_at));
                $data["end"] = $item->end_at;
                $data["id"] = $item->id;
                if($data["status"] == "open"){
                    $data["color"] = "#019875";
                    $data["textColor"] = "white";
                }
                else if($data["status"] == "booked") {
                    $data["color"] = "blue";
                }
                else if($data["status"] == "cancelled") {
                    $data["color"] = "red";
                }
                else if($data["status"] == "penalty 1") {
                    $data["color"] = "#01730d";
                }
                else if($data["status"] == "penalty 2") {
                    $data["color"] = "#01730d";
                }
                else if($data["status"] == "penalty 3") {
                    $data["color"] = "#01730d";
                }
                else if($data["status"] == "completed") {
                    $data["color"] = "#01730d";
                }
                else if($data["status"] == "teacher is absent") {
                    $data["color"] = "red"; //violet
                }
                else if($data["status"] == "student is absent") {
                    $data["color"] = "red"; //violet
                }
                $json[] = $data;
            }
        }
        //2018-04-26T04:21:13.942Z
        //Y-M-dTH:i:s.
        return $this->response("Class Schedule", $json);
    }

    public function studentProfile()
    {

    }

    public function storeProfile(Request $request)
    {
        $user = Student::find(auth()->user()->id);
        if(isset($request->password) && $request->password != "")
        {
            $request->password = Hash::make($request->password);
        }

        $result = array_filter($request->all());
        $user->update($result);
        return $user->find($user->id);
    }

    public function uploadAvatar(Request $request)
    {
        $now = Carbon::now();
        $monthYear = $now->englishMonth.$now->year;
        $filepath = "users/$monthYear";
        $path = $request->file('avatar')->store($filepath);
        $user = User::find(auth()->user()->id);
        $user->avatar = $path;
        $user->save();
        return $this->response("Profile Picture Uploaded Successfully!", ["url" => $path]);
    }

    public function studentDashboard()
    {
        $balance = Order::where("status","active")
            ->where("student_id", auth()->user()->id)
            ->selectRaw("sum(remaining_reservation) as remaining")
            ->first();

        $regularBalance = isset($balance->remaining) ? $balance->remaining:0;
        $balance = Referral::where("referrer_id", auth()->user()->id)
            ->selectRaw("sum(referral_consumable) as remaining")
            ->first();

        $referralBalance = ($balance->remaining) ? $balance->remaining: "0";
        
        $immortalBalance = auth()->user()->immortal;
        
        $completedClass = BookClass::whereIn("status",["lesson memo delay","completed"])
                ->where("student_id", auth()->user()->id)
                ->count();
        $user = auth()->user();
        $data = [
            "account_number" => $user->created_at."-".$user->id,
            "name" => $user->first_name. " " .$user->last_name,
            "qq" => $user->qq,
            "wechat" => $user->wechat,
            "account_type" => StudentAccountType::find($user->student_account_type_id)->name,
            "immortal_balance" => $immortalBalance,
            "regular_balance" => $regularBalance,
            "referral_balance" => $referralBalance,
            "completed_class" => $completedClass
        ];

        return $data;
    }

    public function changeStudentPassword()
    {
        
    }

    public function changePass(Request $request, $id) {

        if( isset($request->password) ) {
            $samePass = Hash::check( $request->password, auth()->user()->password );
            if($samePass === true) {
                Session::flash("error", "New password and Old password are the same.");
            }else{
                //Session::put("tour", "yes"); 
                $res = $this->updateSelfPass($request->password);
            }
        }
        return redirect("/");
    }
}
