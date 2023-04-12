<?php

namespace App\Http\Components\Crons\UawUpdateCron;

use App\Http\Components\Repositories\UawUpdateRepositories\UawAccuracyUpdateRepository;
use App\Http\Components\Setting;
use App\Jobs\UawAccuracyUpdateJob;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UawAccuracyUpdateCron{

    public function index()
    {
        
        try {
            $uawAccuracyCount = (new UawAccuracyUpdateRepository())->uawAccuracy()->count();

            $chunkSize = Setting::$chunk_size;
            $loopEnd = ceil($uawAccuracyCount / $chunkSize);
    
            for ($i = 1; $i <= $loopEnd; $i++) {
                UawAccuracyUpdateJob::dispatch($chunkSize);
            }
    
            
        } catch (Exception $error) {
            Log::info($error);
        }

     
    }

    



}