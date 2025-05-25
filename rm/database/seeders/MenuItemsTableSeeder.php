<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MenuItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $i) {
            DB::table('menuitems')->insert([
                'name' => $faker->words(2, true),
                'description' => $faker->sentence(),
                'price' => $faker->randomFloat(2, 50, 500), // Price between 50.00 and 500.00
                'category' => $faker->randomElement(['Appetizer', 'Main Course', 'Dessert', 'Drinks']),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
