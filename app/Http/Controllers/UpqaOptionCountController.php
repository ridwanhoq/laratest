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

        // 25/(25+20+55)*100

        /**
         * $related = Related::with(['main' => function ($query) {
         * $query->select('id', 'selected_column');
         * }])->withSum('main:selected_column')->get();
         * Pques [id], PquesOption[id, pques_id], UpqaOptionCount [id, pques_option_id, total_votes, percentage]
         * 
         * 

         */
        $pqa_option_id = request()->pqa_option_id;
        $data = UpqaOptionCount::query()
            ->select(DB::raw('sum(total_count) as sc'))
            ->with([
                'UpqaOptionCount' => function ($query) use ($pqa_option_id) {
                    $query->selectRaw('sc/total_count*100 as percentage')
                        ->where('pqa_option_id', $pqa_option_id);
                }
            ])
            ->groupBy('pq_id')
            ->where('pq_id', 1)
            ->get();

        $row = UpqaOptionCount::query()
            ->select('percentage')
            ->first();

        $is_selected_answer_correct = $row->percentage >= 100 / $row->options_count ?: false;

        // 

        $data = UpqaOptionCount::with([
            'upqaCount' => function ($query) {
                $query->select('id');
            }
        ])
            ->get();


        return $data;
    }
}
