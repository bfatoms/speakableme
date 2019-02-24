<?php

namespace App\Http\Controllers;

use Hash;

use App\Models\Role;
use App\Models\Entity;
use App\Models\Teacher;
use App\Jobs\SystemLogger;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\SendRegistrationEmail;
use App\Jobs\SendChangePasswordEmail;
use App\Models\TeacherAccountType;
use App\Models\TeacherRate;
use App\Models\EntityAssignment;
use App\Models\BaseTeacherRate;

class TeacherController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', Teacher::class);

        $entity = Entity::find(request('entity_id', auth()->user()->entity_id));
        dd($entity);

        $role = Role::where('entity_id', $entity->id)
            ->where('system_name', 'teacher')
            ->first();
        
        $password = str_random(18);

        $teacher = array_merge($request->all(), [
            'id' => Str::uuid(),
            'password' => Hash::make($password),
            'entity_id' => $entity->id,
            'lang' => $entity->default_lang,
            'timezone' => $entity->default_timezone,
            'role_id' => $role->id,
            'teacher_account_type_id' => request('teacher_account_type_id') ??
                TeacherAccountType::oldest()->first()->id,
        ]);

        $data = Teacher::create($teacher);

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
        ]);
        // ->delay(now()->addSeconds(5));

        // automatically create teacher rate for this teacher for each provider
        $rates = BaseTeacherRate::where('teacher_provider_id', $data->entity_id)->get();

        foreach($rates as $rate)
        {
            $new_rate = array_merge($rate->toArray(), ['teacher_id' => $data->id]);
            TeacherRate::create($new_rate);
        }
        
        return $this->respond($data, "Teacher Successfully Created!");
    }

    public function update($id)
    {
        $teacher = Teacher::find($id);
        
        $this->authorize('update', $teacher);

        $update = array_filter(request()->all());

        if(array_key_exists('password',$update)) {
            $update['password'] = Hash::make(request('password'));
        }

        if($teacher->update($update)){

            $teacher = $teacher->fresh();
            
            if(array_key_exists('password', $update)) {

                // send Password to teacher email
                $email_data = array_merge(
                    ['users' => $teacher],
                    ['password'=> request('password')]
                );
        
                // send Registration Data to email
                SendChangePasswordEmail::dispatch($email_data['users']->email, $email_data)
                    ->delay(now()->addSeconds(10));
        
                SystemLogger::dispatch([
                    'actor_id' => (empty(auth()->user())) ? 0: auth()->user()->id,
                    'actor' => ( empty(auth()->user()) ) ? 'system' : 'user',
                    'description' => "A password was sent to " . $teacher['email'],
                    'system_loggable_id' => $teacher['id'],
                    'system_loggable_type' => 'user',
                    'data' => json_encode($teacher)
                ])
                ->delay(now()->addSeconds(5));
            }
        }

        return $this->respond($teacher->refresh(), "Teacher Successfully Updated!");
    }

    public function index()
    {
        $this->authorize('browse', Teacher::class);
        return $this->respond(Teacher::where('entity_id', eid())->where('role_id', role('teacher'))->get());
    }

    public function show($id)
    {
        $teacher = Teacher::where('entity_id', eid())->where('id', $id)->firstOrFail();
        $this->authorize('view', $teacher);
        return $this->respond($teacher);
    }

}
