<?php

namespace App\Http\Controllers;

use Hash;

use App\Models\Role;
use App\Models\Entity;
use App\Models\Student;
use App\Models\Balance;
use App\Models\BalanceType;

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
            'student_account_type_id' => StudentAccountType::where('name', 'trial')->first()->id,
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

        // we also add free trial and immortal to the balances
        Balance::create([
            'user_id' => $data->id,
            'balance_type_id' => BalanceType::where('name', 'immortal')->first()->id,
            'remaining' => 0,
            // for immortal Total is the total number of immortal that has been given for this user
            'total' => 0
        ]);

        if($data->student_account_type_id == StudentAccountType::where('name', 'trial')->first()->id)
        {
            Balance::create([
                'user_id' => $data->id,
                'balance_type_id' => BalanceType::where('name', 'trial')->first()->id,
                'validity' => now()->addDays(config('speakable.trial-validity')),
                'remaining' => config('speakable.trial-validity'),
                'total' => config('speakable.trial-validity')
            ]);
        }
        
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

            $student = $student->refresh();
            
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

        return $this->respond($student->refresh(), "Student Successfully Updated!");
    }

    public function index()
    {
        $this->authorize('browse', Student::class);
        return $this->respond(Student::where('entity_id', eid())->where('role_id', role('student'))->get());
    }

    public function show($id)
    {
        $student = Student::where('entity_id', eid())->where('id', $id)->firstOrFail();
        $this->authorize('view', $student);
        return $this->respond($student);
    }

}
