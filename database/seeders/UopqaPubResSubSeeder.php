<?php

namespace Database\Seeders;

use App\Models\UopqaPubResSub;
use Illuminate\Database\Seeder;

class UopqaPubResSubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // UopqaPubResSub::factory()->count(15)->create();
        foreach (range(1, 15) as $user_id) {
            foreach (range(1, 3) as $pq_id) {
                UopqaPubResSub::create([
                    'user_id'                   => $user_id,
                    'pq_id'                     => $pq_id,
                    'pqa_option_id'             => rand($pq_id * 3 - 2, $pq_id * 3),
                    'is_ans_match_with_maj_pub' => array_rand([true, false]),
                    'date'                      => date('Y-m-d'),
                ]);
            }
        }
    }
}
