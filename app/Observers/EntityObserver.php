<?php

namespace App\Observers;
use App\Models\Entity;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Permission;
use Illuminate\Support\Str;

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
        $user = $this->createUser($entity);
        $this->createUserRole();

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
            'email' => $entity->default_email,
            'password' => Hash::make($password),
            'lang' => $entity->default_lang,
            'role_id' => $role->id
        ]);
        // send Registration Data 
    }

}
