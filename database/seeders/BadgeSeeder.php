<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $necessary_rizz_points      = [1000, 5000, 15000];
        $necessary_accuracy         = [10, 40, 80];
        $necessary_streak           = [1, 30, 100];

        $data = [];
        foreach (range(1, 3) as $key) {
            foreach (range(1, 3) as $index) {
                $data[] = [
                    'title'                 => 'Title '.$key*$index,
                    'necessary_rizz_points' => $necessary_rizz_points[$index-1],
                    'necessary_accuracy'    => $necessary_accuracy[$index-1],
                    'necessary_streak'      => $necessary_streak[$index-1],
                ];
            }
        }

        Badge::insert($data);
    }
}
