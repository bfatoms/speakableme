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
            'id' => 1,
            'name' => 'trial',
            'class_type_id' => 1
        ]);

        BalanceType::create([
            'id' => 2,
            'name' => 'trial',
            'class_type_id' => 2
        ]);

        BalanceType::create([
            'id' => 3,
            'name' => 'immortal',
            'class_type_id' => 1
        ]);

        BalanceType::create([
            'id' => 4,
            'name' => 'immortal',
            'class_type_id' => 2
        ]);

        BalanceType::create([
            'id' => 5,
            'name' => 'order',
            'class_type_id' => 1
        ]);

        BalanceType::create([
            'id' => 6,
            'name' => 'order',
            'class_type_id' => 2
        ]);

        BalanceType::create([
            'id' => 7,
            'name' => 'incentive',
            'class_type_id' => 1
        ]);

        BalanceType::create([
            'id' => 8,
            'name' => 'incentive',
            'class_type_id' => 2
        ]);

    }
}
