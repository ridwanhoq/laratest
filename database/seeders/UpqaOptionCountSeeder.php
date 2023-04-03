<?php

namespace Database\Seeders;

use App\Models\UpqaOptionCount;
use Illuminate\Database\Seeder;

class UpqaOptionCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UpqaOptionCount::factory()->count(15)->create();
    }
}
