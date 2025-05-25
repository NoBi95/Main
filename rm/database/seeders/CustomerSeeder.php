<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $data = [];

        foreach (range(1, 1000) as $index) {
            $data[] = [
                'name' => $faker->unique()->name,
                'phone' => $faker->unique()->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'created_at' => now(),
            ];
        }

        // Insert all 1000 records in chunks (for performance & avoid memory issues)
        $chunks = array_chunk($data, 500);

        foreach ($chunks as $chunk) {
            DB::table('customers')->insert($chunk);
        }
    }
}
