<?php

namespace Database\Seeders;

use App\Models\Ur;
use Illuminate\Database\Seeder;

class UrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ur::factory()->count(15)->create();
    }
}
