<?php

namespace App\Http\Components\Crons\UawUpdateCron;

use App\Http\Components\Repositories\UawUpdateRepositories\UawStreakUpdateRepository;
use App\Http\Components\Setting;
use App\Jobs\UawStreakUpdateJob;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UawStreakUpdateCron{


    public function index(){

        try {
            $uawPointsCount = (new UawStreakUpdateRepository())->uawStreak()->count();

            $chunkSize = Setting::$chunk_size;
            $loopEnd = ceil($uawPointsCount / $chunkSize);
    
            for ($i = 1; $i <= $loopEnd; $i++) {
                UawStreakUpdateJob::dispatch($chunkSize);
            }
                
        } catch (Exception $error) {
            Log::info($error);
        }

        
    }

   


}