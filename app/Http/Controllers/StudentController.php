<?php

namespace App\Http\Controllers;

use Hash;

use App\Models\Role;
use App\Models\Entity;
use App\Models\Student;
use App\Jobs\SystemLogger;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\SendRegistrationEmail;
use App\Jobs\SendChangePasswordEmail;
use App\Models\StudentAccountType;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', Student::class);

        $entity = Entity::find(request('entity_id', auth()->user()->entity_id));

        $role = Role::where('entity_id', $entity->id)
            ->where('system_name', 'student')
            ->first();
        
        $password = str_random(18);

        $student = array_merge($request->all(), [
            'id' => Str::uuid(),
            'password' => Hash::make($password),
            'entity_id' => $entity->id,
            'lang' => $entity->default_lang,
            'timezone' => $entity->default_timezone,
            'role_id' => $role->id,
            'student_account_type_id' => StudentAccountType::where('name', 'trial')->first(),
        ]);

        $data = Student::create($student);

        SystemLogger::dispatch([
            'actor_id' => (empty(auth()->user())) ? 0: auth()->user()->id,
            'actor' => ( empty(auth()->user()) ) ? 'system' : 'user',
            'description' => "A new User with email". $data['email'] ." was created for Entity ".$entity->name,
            'system_loggable_id' => $data['id'],
            'system_loggable_type' => 'user',
            'data' => json_encode($data)
        ])
        ->delay(now()->addSeconds(5));

        $email_data = array_merge(
            ['users' => $data],
            ['entity' => $entity],
            ['password'=> $password]
        );

        // send Registration Data to email
        SendRegistrationEmail::dispatch($email_data['users']->email, $email_data)
            ->delay(now()->addSeconds(10));

        SystemLogger::dispatch([
            'actor_id' => (empty(auth()->user())) ? 0: auth()->user()->id,
            'actor' => ( empty(auth()->user()) ) ? 'system' : 'user',
            'description' => "Registration email was sent to ". $data['email'],
            'system_loggable_id' => $data['id'],
            'system_loggable_type' => 'user',
            'data' => json_encode($data)
        ])
        ->delay(now()->addSeconds(5));
        
        return $this->respond($data, "Student Successfully Created!");
    }

    public function update($id)
    {
        $student = Student::find($id);
        
        $this->authorize('update', $student);

        $update = array_filter(request()->all());

        if(array_key_exists('password',$update)) {
            $update['password'] = Hash::make(request('password'));
        }

        if($student->update($update)){

            $student = $student->fresh();
            
            if(array_key_exists('password', $update)) {

                // send Password to student email
                $email_data = array_merge(
                    ['users' => $student],
                    ['password'=> request('password')]
                );
        
                // send Registration Data to email
                SendChangePasswordEmail::dispatch($email_data['users']->email, $email_data)
                    ->delay(now()->addSeconds(10));
        
                SystemLogger::dispatch([
                    'actor_id' => (empty(auth()->user())) ? 0: auth()->user()->id,
                    'actor' => ( empty(auth()->user()) ) ? 'system' : 'user',
                    'description' => "A password was sent to " . $student['email'],
                    'system_loggable_id' => $student['id'],
                    'system_loggable_type' => 'user',
                    'data' => json_encode($student)
                ])
                ->delay(now()->addSeconds(5));
            }
        }

        return $this->respond($student->fresh(), "Student Successfully Updated!");
    }

}
