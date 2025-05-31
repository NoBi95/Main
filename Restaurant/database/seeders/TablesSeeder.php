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

        foreach (range(1, 30) as $index) {
            DB::table('tables')->insert([
                'table_number' => str_pad($index, 3, '0', STR_PAD_LEFT), // No 'T' prefix
                'capacity' => $faker->numberBetween(2, 10),
                'status' => $faker->randomElement(['Available', 'Occupied', 'Reserved']),
                'active' => $faker->boolean(90),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
