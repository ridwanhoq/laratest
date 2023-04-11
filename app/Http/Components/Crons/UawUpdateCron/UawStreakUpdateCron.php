<?php

namespace App\Http\Components\Crons\UawUpdateCron;

use App\Http\Components\Setting;
use App\Jobs\UawStreakUpdateJob;
use Illuminate\Support\Facades\DB;

class UawStreakUpdateCron{


    public function index(){
        $uawPointsCount = $this->uawStreakCount();

        $chunkSize = Setting::$chunk_size;
        $loopEnd = ceil($uawPointsCount / $chunkSize);

        for ($i = 1; $i <= $loopEnd; $i++) {
            UawStreakUpdateJob::dispatch($chunkSize);
        }
        
    }

    private function uawStreakCount(){
        return DB::table("urs as ur")
        ->join("aws as a", function ($join) {
            $join->on(function ($q) {
                $q->whereBetween('ur.streak', [DB::raw('a.range_start'), DB::raw('a.range_end')]);
            });
        })
        ->join("users as u", function ($join) {
            $join->on("u.id", "=", "ur.user_id");
        })
        ->select("a.id", "ur.user_id", "a.range_start", "a.range_end")
        ->where("ur.user_id", "=", 6)
        ->where("a.type", "=", 3)
        ->where(function ($wh) {
            $wh->whereNull('u.last_award_id_for_points')->orWhere('u.last_award_id_for_points', '!=', 'a.id');
        })
        ->count();
    }


}