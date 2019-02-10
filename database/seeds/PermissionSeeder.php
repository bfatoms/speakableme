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
            // 'id' => Str::uuid(),
            'id' => 'browse-all',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'create-all',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'store-all',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'edit-all',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'update-all',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'delete-all',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'read-all',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);


        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'do-all',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        // ROLES
        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'browse-role',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'create-role',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'store-role',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'edit-role',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'update-role',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'delete-role',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'read-role',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);
    


        // PERMISSIONS FOR USERS
        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'browse-user',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'create-user',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'store-user',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'edit-user',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'update-user',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'delete-user',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'read-user',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        // PERMISSIONS FOR students
        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'browse-student',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'create-student',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'store-student',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'edit-student',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'update-student',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'delete-student',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'read-student',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        // PERMISSIONS FOR teachers
        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'browse-teacher',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'create-teacher',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'store-teacher',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'edit-teacher',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'update-teacher',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'delete-teacher',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'read-teacher',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => true,
        ]);

        // PERMISSIONS FOR base packages
        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'browse-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'create-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'store-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'edit-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'update-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'delete-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'read-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        // PERMISSIONS FOR entity packages
        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'browse-entity-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'create-entity-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'store-entity-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'edit-entity-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'update-entity-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'delete-entity-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'read-entity-package',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        // PERMISSIONS FOR entity
        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'browse-entity',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'create-entity',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'store-entity',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'edit-entity',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'update-entity',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'delete-entity',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'read-entity',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);


        // PERMISSIONS FOR entity types
        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'browse-entity-type',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'create-entity-type',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'store-entity-type',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'edit-entity-type',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'update-entity-type',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'delete-entity-type',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'read-entity-type',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => false,
        ]);


        // SCHEDULE

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'browse-schedule',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'create-schedule',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'store-schedule',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'edit-schedule',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'update-schedule',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'delete-schedule',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'read-schedule',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);


        // ORDERS
        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'browse-order',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'create-order',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'store-order',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'edit-order',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'update-order',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'delete-order',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'read-order',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'approve-order',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        


        // user profiles
        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'browse-profile',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'create-profile',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'store-profile',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'edit-profile',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'update-profile',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'delete-profile',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'read-profile',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        // CUSTOM PERMISSIONS
        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'login',
            'name' => 'Can Login',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'book-schedule',
            'name' => 'Can Book Schedule',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => false,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'open-schedule',
            'manage_clients' => true,
            'manage_students' => false,
            'manage_teachers' => true,
            'name' => 'Can Open Schedule'
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'view-student-profile',
            'name' => 'Can View Student Profile',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'view-teacher-profile',
            'name' => 'Can View Student Profile',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'view-other-profile',
            'name' => 'Can View Student Profile',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'assign-role',
            'name' => 'Can Assign Roles to users',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);

        Permission::insert([
            // 'id' => Str::uuid(),
            'id' => 'assign-permission',
            'name' => 'Can Assign Permissions to users',
            'manage_clients' => true,
            'manage_students' => true,
            'manage_teachers' => true,
        ]);


    }
}
