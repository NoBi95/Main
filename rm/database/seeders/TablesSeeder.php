<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TablesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 50; $i++) {
            DB::table('tables')->insert([
                'table_number' => $i,
                'capacity' => $faker->numberBetween(2, 12),
                'status' => $faker->randomElement(['Available', 'Occupied', 'Reserved', 'Out of Service']),
            ]);
        }
    }
}
