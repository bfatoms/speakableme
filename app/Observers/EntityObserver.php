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

        $this->createSuperAdminPermissions($role);

        $role = Role::create([
            'id' => Str::uuid(),
            'entity_id' => $entity->id, 
            'system_name' => 'admin',
            'name' => 'Admin',
        ]);

        $this->createAdminPermissions($role);

        // create student permission if manage_users === true
        if($entity->manage_students == true){
            $role = Role::create([
                'id' => Str::uuid(),
                'entity_id' => $entity->id, 
                'system_name' => 'student',
                'name' => 'Student',
            ]);    

            $this->createStudentPermissions($role);
        }

        if($entity->manage_teachers == true){
            $role = Role::create([
                'id' => Str::uuid(),
                'entity_id' => $entity->id, 
                'system_name' => 'teacher',
                'name' => 'Teacher',
            ]);

            $this->createTeacherPermissions($role);    
        }

    }

    public function getStudentPermissions()
    {
        return [
            'can_browse_schedule' => true,
            'can_edit_schedule' => true,
            'can_update_schedule' => true,
            'can_read_schedule' => true,
            'can_browse_order' => true,
            'can_create_order' => true,
            'can_store_order' => true,
            'can_edit_order' => true,
            'can_update_order' => true,
            'can_read_order' => true,
            'can_browse_profile' => true,
            'can_create_profile' => true,
            'can_store_profile' => true,
            'can_edit_profile' => true,
            'can_update_profile' => true,
            'can_read_profile' => true,
            'can_login' => true,
            'can_book_schedule' => true,
            'can_view_teacher_profile' => true,
        ];
    }


    public function createStudentPermissions($role)
    {
        $allowed = $this->getStudentPermissions();

        $list = array_keys($allowed);

        $permissions = Permission::whereIn('system_name', $list)
            ->get()
            ->groupBy('system_name');

        foreach($list as $permission)
        {
            RolePermission::create([
                'permission_id' => $permissions[$permission]->first()->id,
                'role_id' => $role->id,
                'allowed' => $allowed[$permission],
            ]);    
        }
    }


    public function getTeacherPermissions()
    {
        return [
            'can_browse_schedule' => true,
            'can_create_schedule' => true,
            'can_store_schedule' => true,
            'can_edit_schedule' => true,
            'can_update_schedule' => true,
            'can_delete_schedule' => true,
            'can_read_schedule' => true,
            'can_browse_profile' => true,
            'can_create_profile' => true,
            'can_store_profile' => true,
            'can_edit_profile' => true,
            'can_update_profile' => true,
            'can_read_profile' => true,
            'can_login' => true,
            'can_open_schedule' => true,
            'can_view_student_profile' => true,
        ];
    }


    public function createTeacherPermissions($role)
    {
        $allowed = $this->getTeacherPermissions();

        $list = array_keys($allowed);

        $permissions = Permission::whereIn('system_name', $list)
            ->get()
            ->groupBy('system_name');

        foreach($list as $permission)
        {
            RolePermission::create([
                'permission_id' => $permissions[$permission]->first()->id,
                'role_id' => $role->id,
                'allowed' => $allowed[$permission],
            ]);    
        }

    }


    public function getAdminPermissions()
    {
        return [
            'can_browse_role' => true,
            'can_create_role' => true,
            'can_store_role' => true,
            'can_edit_role' => true,
            'can_update_role' => true,
            'can_delete_role' => true,
            'can_read_role' => true,    

            'can_browse_user' => true,
            'can_create_user' => true,
            'can_store_user' => true,
            'can_edit_user' => true,
            'can_update_user' => true,
            'can_read_user' => true,

            'can_browse_schedule' => true,
            'can_create_schedule' => true,
            'can_store_schedule' => true,
            'can_edit_schedule' => true,
            'can_update_schedule' => true,

            'can_read_schedule' => true,
            'can_browse_order' => true,
            'can_create_order' => true,
            'can_store_order' => true,
            'can_edit_order' => true,
            'can_update_order' => true,

            'can_read_order' => true,
            'can_browse_profile' => true,
            'can_create_profile' => true,
            'can_store_profile' => true,
            'can_edit_profile' => true,
            'can_update_profile' => true,
            'can_read_profile' => true,

            'can_login' => true,

            'can_book_schedule' => true,
            'can_open_schedule' => true,

            'can_view_student_profile' => true,
            'can_view_teacher_profile' => true,
            'can_view_other_profile' => true,
            'can_assign_role' => true,
            'can_assign_permission' => true,
        ];
    }


    public function createAdminPermissions($role)
    {
        $allowed = $this->getAdminPermissions();

        $list = array_keys($allowed);

        $permissions = Permission::whereIn('system_name', $list)
            ->get()
            ->groupBy('system_name');
        
        foreach($list as $permission)
        {
            RolePermission::create([
                'permission_id' => $permissions[$permission]->first()->id,
                'role_id' => $role->id,
                'allowed' => $allowed[$permission],
            ]);    
        }

    }
    





    public function createSuperAdminPermissions($role)
    {
        $allowed = $this->getSuperAdminPermissions();

        $list = array_keys($allowed);

        $permissions = Permission::whereIn('system_name', $list)
            ->get()
            ->groupBy('system_name');

        foreach($list as $permission){
            RolePermission::create([
                'permission_id' => $permissions[$permission]->first()->id,
                'role_id' => $role->id,
                'allowed' => $allowed[$permission],
            ]);    
        }

    }

    public function getSuperAdminPermissions()
    {
        return [
            'can_browse_all' => true,
            'can_create_all' => true,
            'can_store_all' => true,
            'can_edit_all' => true,
            'can_update_all' => true,
            'can_delete_all' => true,
            'can_read_all' => true,
            'can_do_action_all' => true,
        ];
    }









































    // PERMISSION LIST

    public function getPermissions()
    {
        return [
            ['name' => 'can_browse_role', 'allowed' => true],
            ['name' => 'can_create_role', 'allowed' => true],
            ['name' => 'can_store_role', 'allowed' => true],
            ['name' => 'can_edit_role', 'allowed' => true],
            ['name' => 'can_update_role', 'allowed' => true],
            ['name' => 'can_delete_role', 'allowed' => true],
            ['name' => 'can_read_role', 'allowed' => true],    
            ['name' => 'can_browse_user', 'allowed' => true],
            ['name' => 'can_create_user', 'allowed' => true],
            ['name' => 'can_store_user', 'allowed' => true],
            ['name' => 'can_edit_user', 'allowed' => true],
            ['name' => 'can_update_user', 'allowed' => true],
            ['name' => 'can_delete_user', 'allowed' => true],
            ['name' => 'can_read_user', 'allowed' => true],
            ['name' => 'can_browse_schedule', 'allowed' => true],
            ['name' => 'can_create_schedule', 'allowed' => true],
            ['name' => 'can_store_schedule', 'allowed' => true],
            ['name' => 'can_edit_schedule', 'allowed' => true],
            ['name' => 'can_update_schedule', 'allowed' => true],
            ['name' => 'can_delete_schedule', 'allowed' => true],
            ['name' => 'can_read_schedule', 'allowed' => true],
            ['name' => 'can_browse_order', 'allowed' => true],
            ['name' => 'can_create_order', 'allowed' => true],
            ['name' => 'can_store_order', 'allowed' => true],
            ['name' => 'can_edit_order', 'allowed' => true],
            ['name' => 'can_update_order', 'allowed' => true],
            ['name' => 'can_delete_order', 'allowed' => true],
            ['name' => 'can_read_order', 'allowed' => true],
            ['name' => 'can_browse_profile', 'allowed' => true],
            ['name' => 'can_create_profile', 'allowed' => true],
            ['name' => 'can_store_profile', 'allowed' => true],
            ['name' => 'can_edit_profile', 'allowed' => true],
            ['name' => 'can_update_profile', 'allowed' => true],
            ['name' => 'can_delete_profile', 'allowed' => true],
            ['name' => 'can_read_profile', 'allowed' => true],
            ['name' => 'can_login', 'allowed' => true],
            ['name' => 'can_book_schedule', 'allowed' => true],
            ['name' => 'can_open_schedule', 'allowed' => true],
            ['name' => 'can_view_student_profile', 'allowed' => true],
            ['name' => 'can_view_teacher_profile', 'allowed' => true],
            ['name' => 'can_view_other_profile', 'allowed' => true],
            ['name' => 'can_assign_role', 'allowed' => true],
            ['name' => 'can_assign_permission', 'allowed' => true],
        ];
    }




}
