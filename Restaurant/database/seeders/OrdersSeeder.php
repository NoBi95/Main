<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrdersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Get all menu items
        $menuItems = DB::table('menuitems')->where('active', 1)->get();
        
        // Get all customers
        $customers = DB::table('customers')->get();
        
        // Get all tables
        $tables = DB::table('tables')->where('active', 1)->get();

        // Create 100 orders
        foreach (range(1, 100) as $index) {
            // Create order
            $orderId = DB::table('orders')->insertGetId([
                'customer_id' => $faker->randomElement($customers)->customer_id,
                'table_id' => $faker->randomElement($tables)->table_id,
                'total_amount' => 0, // Will be updated after adding items
                'status' => $faker->randomElement(['pending', 'completed', 'cancelled']),
                'order_time' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);

            // Add 1-5 items to each order
            $totalAmount = 0;
            $numItems = $faker->numberBetween(1, 5);
            $selectedItems = $faker->randomElements($menuItems, $numItems);

            foreach ($selectedItems as $item) {
                $quantity = $faker->numberBetween(1, 3);
                $price = $item->price;
                $totalAmount += $quantity * $price;

                DB::table('orderitems')->insert([
                    'order_id' => $orderId,
                    'item_id' => $item->item_id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Update order total amount
            DB::table('orders')
                ->where('order_id', $orderId)
                ->update(['total_amount' => $totalAmount]);
        }
    }
} 