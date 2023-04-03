<?php

namespace App\Http\Controllers;

use App\Models\UpqaOptionCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpqaOptionCountController extends Controller
{
    public function index()
    {
        $upqaOptionId = 1;

        $data = UpqaOptionCount::query()
            ->select(DB::raw('sum(count) as sc'))
            ->with([
                'upqaCount' => function ($upqaCount) use ($upqaOptionId) {
                    $upqaCount
                    // ->selectRaw('sc/count')
                    ->where('pqa_option_id', $upqaOptionId)
                        // ->where('date', date('Y-m-d'))
                        ;
                }
            ])
            ->groupBy('pq_id')
            ->where('pq_id', 1)
            ->get();


        return $data;
    }
}
