<?php

namespace App\Http\Components\Repositories;

use App\Jobs\UopqaPubResSubUpdateJob;
use App\Models\UopqaPubResSub;
use Exception;
use Illuminate\Support\Facades\Log;

class UopqaPubResSubUpdateRepository
{
    public function index()
    {

        try {


            // CronJobConfig::updateOrCreate(
            //     [
            //         'cron_date' => date("Y-m-d")
            //     ],
            //     [
            //         'mgml_unit_scores_cycle_unit_need_to_be_updated' => $total_mgml_unit_score_to_be_upgraded
            //     ]
            // );

            $total_to_be_updated = UopqaPubResSub::query()
                ->where('date', date('Y-m-d'))
                ->where('user_id', auth()->user()->id)
                ->count();

                UopqaPubResSubUpdateJob::dispatch($total_to_be_updated);
        } catch (Exception $error) {
            Log::info($error);
        }
    }
}
