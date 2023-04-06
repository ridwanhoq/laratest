<?php

namespace App\Http\Components\Repositories;

use App\Http\Components\Setting;
use App\Jobs\UopqaPubResSubUpdateJob;
use App\Models\CronJobConfig;
use App\Models\UopqaPubResSub;
use Exception;
use Illuminate\Support\Facades\Log;

class UopqaPubResSubUpdateCron
{
    public function index()
    {

        try {



            $total_to_be_updated = UopqaPubResSub::query()
                ->where('date', date('Y-m-d'))
                ->count();

            $chunkSize = Setting::$chunk_size;

            $loopEndLimit = (int) ceil($total_to_be_updated / $chunkSize);

            for ($i = 1; $i <= $loopEndLimit; $i++) {
                UopqaPubResSubUpdateJob::dispatch($chunkSize);
            }

            CronJobConfig::updateOrCreate(
                [
                    'cron_date' => date("Y-m-d")
                ],
                [
                    'total_uopqa_pub_res_sub_rows_to_be_updated' => $total_to_be_updated
                ]
            );


        } catch (Exception $error) {
            Log::info($error);
            dd($error);
        }
    }
}
