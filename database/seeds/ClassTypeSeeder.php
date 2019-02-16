<?php

use Illuminate\Database\Seeder;

use App\Models\ClassType;

class ClassTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClassType::create([
            'name' => 'Tutoring'
        ]);

        ClassType::create([
            'name' => 'Classroom'
        ]);
    }
}
