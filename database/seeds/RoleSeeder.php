<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Entity;
use Illuminate\Support\Str;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entity = Entity::where('name', 'Speakable Me')->first();

        Role::insert([
            'id' => Str::uuid(),
            'entity_id' => $entity->id,
            'system_name' => 'superadmin',
            'name' => 'Superadmin',

        ]);

        Role::insert([
            'id' => Str::uuid(),
            'entity_id' => $entity->id, 
            'system_name' => 'student',
            'name' => 'Admin',
        ]);

        Role::insert([
            'id' => Str::uuid(),
            'entity_id' => $entity->id, 
            'system_name' => 'student',
            'name' => 'Student',
        ]);

        Role::insert([
            'id' => Str::uuid(),
            'entity_id' => $entity->id, 
            'system_name' => 'teacher',
            'name' => 'Teacher',
        ]);


        // // FOR KIDSONG
        // $entity = Entity::where('name', 'KidSong')->first();

        // Role::insert([
        //     'id' => Str::uuid(),
        //     'entity_id' => $entity->id,
        //     'system_name' => 'superadmin',
        //     'name' => 'Superadmin',

        // ]);

        // Role::insert([
        //     'id' => Str::uuid(),
        //     'entity_id' => $entity->id, 
        //     'system_name' => 'student',
        //     'name' => 'Admin',
        // ]);

        // Role::insert([
        //     'id' => Str::uuid(),
        //     'entity_id' => $entity->id, 
        //     'system_name' => 'student',
        //     'name' => 'Student',
        // ]);

        // Role::insert([
        //     'id' => Str::uuid(),
        //     'entity_id' => $entity->id, 
        //     'system_name' => 'teacher',
        //     'name' => 'Teacher',
        // ]);

    }
}
