<?php

namespace App\Http\Components\Crons;

use App\Http\Components\Setting;
use App\Jobs\PUpdateJob;
use App\Models\P;
use Exception;
use Illuminate\Support\Facades\Log;

class PUpdateCron
{


    public function index()
    {

        try {

            $total_to_be_updated = P::query()
                ->where('date', date('Y-m-d'))
                ->count();

            $chunkSize = Setting::$chunk_size;
            $loopEnd = ceil($total_to_be_updated / $chunkSize);

            for ($i = 1; $i <= $loopEnd; $i++) {
                PUpdateJob::dispatch($chunkSize);
            }
        } catch (Exception $error) {
            Log::error($error);
        }
    }
}
