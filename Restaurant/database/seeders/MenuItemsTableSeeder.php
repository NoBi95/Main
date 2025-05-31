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

        foreach (range(1, 50) as $index) {
            DB::table('menuitems')->insert([
                'name' => $faker->words(2, true),
                'description' => $faker->sentence(),
                'price' => $faker->randomFloat(2, 5, 100),
                'category' => $faker->randomElement(['Appetizer', 'Main Course', 'Dessert', 'Drink']),
                'active' => $faker->boolean(90),
            ]);
        }
    }
}
