<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $roles = ['Waiter', 'Chef', 'Manager', 'Cleaner', 'Cashier'];

        foreach (range(1, 40) as $index) {
            DB::table('staff')->insert([
                'name' => $faker->unique()->name,
                'role' => $faker->randomElement($roles),
                'hire_date' => $faker->dateTimeBetween('-2 years', 'now'),
                'active' => $faker->boolean(90),
            ]);
        }
    }
}
