<?php

namespace Database\Seeders;

use App\Models\Po;
use Illuminate\Database\Seeder;

class PoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Po::factory()->count(15)->create();
    }
}
