<?php

use Illuminate\Database\Seeder;
use App\Models\Entity;
use App\Models\EntityType;
use Illuminate\Support\Str;


class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Entity::create([
            'id' => Str::uuid(),
            'entity_type_id' => EntityType::where('name', 'Corporate')->first()->id,
            'name' => 'Online Learning Incorporated',
            'prefix' => 'OLI',
            'manage_students' => false,
            'manage_teachers' => false,
            'manage_clients' => true,
            'default_email' => 'forondalouie@gmail.com',
            'default_lang' => 'en',
            'default_timezone' => 'Asia/Manila'
        ]);
    }
}
