<?php

use Illuminate\Database\Seeder;
use App\Models\StudentAccountType;


class StudentAccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentAccountType::create([
            'name' => 'trial'
        ]);
        StudentAccountType::create([
            'name' => 'regular'
        ]);
    }
}
