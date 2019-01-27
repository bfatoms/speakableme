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
        // DO NOT CHANGE the Orders
        $this->call(EntityTypeSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(EntitySeeder::class);
        $this->call(RoleSeeder::class);

        // $this->call(UsersTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
