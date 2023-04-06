<?php

namespace Database\Seeders;

use App\Models\PSub;
use Illuminate\Database\Seeder;

class PSubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PSub::factory()->count(15)->create();
    }
}
