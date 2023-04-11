<?php

namespace App\Http\Components\Crons\UawUpdateCron;

use App\Http\Components\Setting;
use App\Jobs\UawAccuracyUpdateJob;
use Illuminate\Support\Facades\DB;

class UawAccuracyUpdateCron{

    public function index()
    {
        $uawAccuracyCount = $this->uawAccuracyCount();

        $chunkSize = Setting::$chunk_size;
        $loopEnd = ceil($uawAccuracyCount / $chunkSize);

        for ($i = 1; $i <= $loopEnd; $i++) {
            UawAccuracyUpdateJob::dispatch($chunkSize);
        }

        
    }

    
    public function uawAccuracyCount(){
        return DB::table("urs as ur")
        ->join("aws as a", function ($join) {
            $join->on(function ($q) {
                $q->whereBetween('ur.accuracy', [DB::raw('a.range_start'), DB::raw('a.range_end')]);
            });
        })
        ->join("users as u", function ($join) {
            $join->on("u.id", "=", "ur.user_id");
        })
        ->select("a.id", "ur.user_id", "a.range_start", "a.range_end")
        ->where("ur.user_id", "=", 6)
        ->where("a.type", "=", 2)
        ->where(function ($wh) {
            $wh->whereNull('u.last_award_id_for_points')->orWhere('u.last_award_id_for_points', '!=', 'a.id');
        })
        ->count();
    }




}