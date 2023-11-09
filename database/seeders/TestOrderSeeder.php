<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Seeder;

class TestOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::factory()->count(10)->create();
        foreach ($orders as $order) {
            OrderDetail::factory()->count(2)->create([
                'order_id' => $order->id,
            ]);
        }
    }
}
