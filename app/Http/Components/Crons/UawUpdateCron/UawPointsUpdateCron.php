<?php

namespace App\Http\Components\Crons\UawUpdateCron;

use App\Http\Components\Repositories\UawUpdateRepositories\UawPointsUpdateRepository;
use App\Http\Components\Setting;
use App\Jobs\UawPointsUpdateJob;
use App\Models\Aw;
use App\Models\Badge;
use App\Models\Ur;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UawPointsUpdateCron
{

    public function index()
    {

        try {
            $uawPointsCount = (new UawPointsUpdateRepository())->uawPoints()->count();

            $chunkSize = Setting::$chunk_size;
            $loopEnd = ceil($uawPointsCount / $chunkSize);
    
            for ($i = 1; $i <= $loopEnd; $i++) {
                UawPointsUpdateJob::dispatch($chunkSize);
            }            
        } catch (Exception $error) {
            Log::info($error);
        }

    }



}
