<?php

use Illuminate\Database\Seeder;
use App\Models\EntityType;
use Illuminate\Support\Str;

class EntityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EntityType::insert([
            'id' => Str::uuid(),
            'name' => 'School'
        ]);

        EntityType::insert([
            'id' => Str::uuid(),
            'name' => 'Corporate'
        ]);
    }
}
