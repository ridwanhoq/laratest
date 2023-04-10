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
        $necessary_rizz_points      = [[1000, 5000], [5001, 15000], [15001, 150000000]];
        $necessary_accuracy         = [[10, 40], [41, 80], [81, 100]];
        $necessary_streak           = [[1, 30], [31, 100], [100, 100000]];

        $data = [];
        foreach (range(1, 3) as $key) {
            foreach (range(1, 3) as $index) {
                $data[] = [
                    'title'                         => 'Title '.$key*$index,
                    'necessary_rizz_points_start'   => $necessary_rizz_points[$index-1][0],
                    'necessary_rizz_points_end'     => $necessary_rizz_points[$index-1][1],
                    'necessary_accuracy_start'      => $necessary_accuracy[$index-1][0],
                    'necessary_accuracy_end'        => $necessary_accuracy[$index-1][1],
                    'necessary_streak_start'        => $necessary_streak[$index-1][0],
                    'necessary_streak_end'          => $necessary_streak[$index-1][1],
                ];
            }
        }

        Badge::insert($data);
    }
}
