<?php

use Illuminate\Database\Seeder;
use App\Models\ClassSession;

class ClassSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClassSession::create([
            'system_name' => 'trial',
            'name' => 'Trial'
        ]);

        ClassSession::create([
            'system_name' => 'regular',
            'name' => 'Regular'
        ]);

        ClassSession::create([
            'system_name' => 'special',
            'name' => 'Trial'
        ]);
    }
}
