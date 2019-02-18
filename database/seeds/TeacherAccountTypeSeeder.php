<?php

use Illuminate\Database\Seeder;
use App\Models\TeacherAccountType;

class TeacherAccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TeacherAccountType::create([
            'name' => 'Level 1'
        ]);

        TeacherAccountType::create([
            'name' => 'Level 2'
        ]);
    }
}
