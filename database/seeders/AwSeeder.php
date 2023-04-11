<?php

namespace Database\Seeders;

use App\Models\Aw;
use Illuminate\Database\Seeder;

class AwSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $necessary_rizz_points_accuracy_streak      =
            [
                [
                    [1000, 5000],
                    [5001, 15000],
                    [15001, 150000000]
                ],
                [
                    [10, 40],
                    [41, 80],
                    [81, 100]
                ],
                [
                    [1, 30],
                    [31, 100],
                    [101, 100000]
                ]
            ];
        $necessary_accuracy         = [[10, 40], [41, 80], [81, 100]];
        $necessary_streak           = [[1, 30], [31, 100], [100, 100000]];

        $data = [];
        foreach (range(1, 3) as $key) {
            foreach (range(1, 3) as $index) {
                $data[] = [
                    'title'         => 'Title ' . $key * $index,
                    'type'          => $key,
                    'range_start'   => $necessary_rizz_points_accuracy_streak[$key - 1][$index - 1][0],
                    'range_end'     => $necessary_rizz_points_accuracy_streak[$key - 1][$index - 1][1],
                ];
            }
        }

        Aw::insert($data);
    }
}
