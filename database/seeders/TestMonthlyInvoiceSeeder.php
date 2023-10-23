<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Seeder;

class TestMonthlyInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 10 random products and 10 random clients
        Product::factory()->count(10)->create();
        Client::factory()->count(10)->create();

        // create 10 random orders and 10 random order details
        // Order::factory()->count(10)->create();
        // OrderDetail::factory()->count(40)->create();

        // create 2 orders with 2 products each
        
        foreach (range(1, 2) as $range) {
            $order = Order::factory()->create([
                'order_frequency' => 'daily',
                'started_at' => '2023-10-01',
                'expired_at' => '2023-10-31'
            ]);

            OrderDetail::factory()->count(2)->create([
                'order_id' => $order->id,
                'date' => '2023-10-01'
            ]);
        }
    }
}
