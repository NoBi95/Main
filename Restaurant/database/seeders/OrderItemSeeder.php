<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderItemSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get all existing order_ids and item_ids to maintain FK constraints
        $orderIds = DB::table('orders')->pluck('order_id')->toArray();
        $itemIds = DB::table('menuitems')->pluck('item_id')->toArray();

        // Generate 50 fake orderitems
        for ($i = 0; $i < 50; $i++) {
            // Random order_id and item_id from existing records
            $order_id = $faker->randomElement($orderIds);
            $item_id = $faker->randomElement($itemIds);

            // Random quantity between 1 and 10
            $quantity = $faker->numberBetween(1, 10);

            // Fake price (e.g., between 10.00 and 100.00)
            $price = $faker->randomFloat(2, 10, 100);

            DB::table('orderitems')->insert([
                'order_id' => $order_id,
                'item_id' => $item_id,
                'quantity' => $quantity,
                'price' => $price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
