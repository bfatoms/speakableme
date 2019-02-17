<?php

use Illuminate\Database\Seeder;
use App\Models\BalanceType;

class BalanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BalanceType::create([
            'name' => 'trial'
        ]);

        BalanceType::create([
            'name' => 'immortal'
        ]);

        BalanceType::create([
            'name' => 'order'
        ]);

        BalanceType::create([
            'name' => 'incentives'
        ]);
    }
}
