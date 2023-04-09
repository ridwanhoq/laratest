<?php

namespace Database\Seeders;

use App\Models\PoSub;
use Illuminate\Database\Seeder;

class PoSubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        foreach(range(1, 15) as $key){
            $data[] = [
                'user_id'   => $key,
                'po_id'     => $key,
                'p_cat_id' => rand(1, 5)
            ];
        }

        PoSub::insert($data);
    }
}
