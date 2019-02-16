<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize();
        $create = array_merge($request->all(),[
            'role_id' => Role::where('entity_id', auth()->user()->entity_id)
                ->where('name', 'student')->first(),
            'trial_balance' => 1,
            'trial_validity' => now()->addDays(30)
        ]);
        Student::create([
            'name', 'email', 'password', 'role_id', 'entity_id',
            'first_name', 'last_name', 'middle_name', 'nick',
            'email', 'avatar', 'password', 'remember_token',
            'gender', 'qq', 'mobile', 'wechat', 'address',
            'timezone', 'lang', 'birth_date', 'disabled', 
            'immortal', 'student_account_type_id', , 
        ]);
    }
}
