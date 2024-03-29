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
            'name' => 'Speakable Me',
            'prefix' => 'SM',
            'manage_students' => true,
            'manage_teachers' => true,
            'manage_clients' => true,
        ]);

        // Entity::create([
        //     'id' => Str::uuid(),
        //     'entity_type_id' => EntityType::where('name', 'School')->first()->id,
        //     'name' => 'KidSong',
        //     'prefix' => 'KS',
        //     'manage_students' => true,
        //     'manage_teachers' => false,
        //     'manage_clients' => false,
        // ]);
    }
}
