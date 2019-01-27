<?php

use Illuminate\Database\Seeder;

use App\Models\Permission;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // SUPERADMIN PERMISSIONS

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_browse_all',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_create_all',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_store_all',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_edit_all',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_update_all',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_delete_all',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_read_all',
            'name' => 'Can Login'
        ]);


        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_do_action_all',
            'name' => 'Can Login'
        ]);



        // ROLES
        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_browse_role',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_create_role',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_store_role',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_edit_role',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_update_role',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_delete_role',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_read_role',
            'name' => 'Can Login'
        ]);
    


        // PERMISSIONS FOR USERS
        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_browse_user',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_create_user',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_store_user',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_edit_user',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_update_user',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_delete_user',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_read_user',
            'name' => 'Can Login'
        ]);


        // SCHEDULE

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_browse_schedule',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_create_schedule',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_store_schedule',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_edit_schedule',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_update_schedule',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_delete_schedule',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_read_schedule',
            'name' => 'Can Login'
        ]);


        // ORDERS
        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_browse_order',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_create_order',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_store_order',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_edit_order',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_update_order',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_delete_order',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_read_order',
            'name' => 'Can Login'
        ]);


        // user profiles
        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_browse_profile',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_create_profile',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_store_profile',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_edit_profile',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_update_profile',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_delete_profile',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_read_profile',
            'name' => 'Can Login'
        ]);




        // CUSTOM PERMISSIONS
        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_login',
            'name' => 'Can Login'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_book_schedule',
            'name' => 'Can Book Schedule'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_open_schedule',
            'name' => 'Can Open Schedule'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_view_student_profile',
            'name' => 'Can View Student Profile'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_view_teacher_profile',
            'name' => 'Can View Student Profile'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_view_other_profile',
            'name' => 'Can View Student Profile'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_assign_role',
            'name' => 'Can Assign Roles to users'
        ]);

        Permission::insert([
            'id' => Str::uuid(),
            'system_name' => 'can_assign_permission',
            'name' => 'Can Assign Permissions to users'
        ]);


    }
}
