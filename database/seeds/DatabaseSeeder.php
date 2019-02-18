<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(EntityTypeSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(EntitySeeder::class);
        $this->call(ClassTypeSeeder::class);
        $this->call(StudentAccountTypeSeeder::class);
        $this->call(TeacherAccountTypeSeeder::class);
        $this->call(BalanceTypeSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(ClassSessionSeeder::class);
    }
}
