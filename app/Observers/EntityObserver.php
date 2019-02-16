<?php

namespace App\Observers;
use App\Models\Entity;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Permission;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\SystemLog;
use App\Jobs\SystemLogger;

use Illuminate\Support\Facades\Hash;
use App\Jobs\SendRegistrationEmail;

use App\Events\UserRegisteredEvent;

class EntityObserver
{
    public function created(Entity $entity)
    {
        // Create Default Roles for this Entity
        $role = Role::create([
            'id' => Str::uuid(),
            'entity_id' => $entity->id,
            'system_name' => 'superadmin',
            'name' => 'Superadmin',
        ]);

        $this->createRolePermissions($role);
        $user = $this->createUser($entity, $role);
        // $this->createUserRole();

        // create student permission if manage_users === true
        if($entity->manage_students === true){
            $role = Role::create([
                'id' => Str::uuid(),
                'entity_id' => $entity->id, 
                'system_name' => 'student',
                'name' => 'Student',
            ]);    

            $this->createRolePermissions($role);
        }

        if($entity->manage_teachers === true){
            $role = Role::create([
                'id' => Str::uuid(),
                'entity_id' => $entity->id, 
                'system_name' => 'teacher',
                'name' => 'Teacher',
            ]);

            $this->createRolePermissions($role);
        }

    }

    public function createRolePermissions($role)
    {
        // dd($role_id);
        $name = $role->system_name;
        foreach(config("speakable.permissions.$name") as $permission) {
            RolePermission::create([
                'role_id' => $role->id,
                'permission_id' => $permission
            ]);
        }
    }

    public function createUser($entity, $role)
    {
        $password = str_random(18);

        $data = User::create([
            'id' => Str::uuid(),
            'email' => $entity->default_email,
            'password' => Hash::make($password),
            'entity_id' => $entity->id,
            'lang' => $entity->default_lang,
            'timezone' => $entity->default_timezone,
            'role_id' => $role->id,
        ]);

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
        ->delay(now()->addSeconds(3));
        

        return $data;
    }

}
