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
        Product::factory()->count(10)->create();
        Client::factory()->count(10)->create();
        Order::factory()->count(10)->create();
        OrderDetail::factory()->count(40)->create();
    }
}
