<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryIsoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country_isos = realpath(__DIR__.'/../data/country_isos.sql');
        DB::unprepared(file_get_contents($country_isos));
    }
}
