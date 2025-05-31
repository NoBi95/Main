<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Fetch available customer and table IDs
        $customerIds = DB::table('customers')->pluck('customer_id')->toArray();
        $tableIds = DB::table('tables')->pluck('table_id')->toArray();

        // Exit early if tables or customers are empty
        if (empty($customerIds) || empty($tableIds)) {
            echo "No customers or tables found.\n";
            return;
        }

        // Insert 30 sample reservations
        foreach (range(1, 30) as $i) {
            DB::table('reservations')->insert([
                'customer_id' => $faker->randomElement($customerIds),
                'table_id' => $faker->randomElement($tableIds),
                'reservation_time' => $faker->dateTimeBetween('+1 hour', '+10 days'),
                'status' => $faker->randomElement(['pending', 'confirmed', 'cancelled']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
