<?php

namespace Database\Seeders;

use App\Models\Upr;
use Illuminate\Database\Seeder;

class UprSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Upr::factory()->count(15)->create();
    }
}
