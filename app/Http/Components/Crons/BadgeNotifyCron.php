<?php

namespace App\Http\Components\Crons;

use App\Http\Components\Setting;
use App\Http\Components\Traits\CalendarHelperTrait;
use App\Jobs\BadgeNotifyJob;
use App\Models\Aw;
use App\Models\Badge;
use App\Models\PoSub;
use App\Models\Upr;
use App\Models\Ur;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BadgeNotifyCron
{

    use CalendarHelperTrait;

    public function index()
    {

        try {
            $awByPoints = Aw::query()
                ->selectRaw('min(necessary_rizz_points_start) as minPoints, min(necessary_accuracy_start) as minAccuracy, min(necessary_streak_start) as minSteak')
                ->first();

            $countPoints = Ur::query()
                ->where('rizz_points', '>=', $awByPoints->minPoints)
                ->whereHas('aws', function($aws){
                    $aws->where('is_notified', false);
                })
                ->count();

            $countAccuracy = Ur::query()
                ->where('accuracy', '>=', $awByPoints->minAccuracy)
                ->count();

            $countStreak = Ur::query()
                ->where('streak', '>=', $awByPoints->minStreak)
                ->count();



            dd($countPoints);
            $as = 1;
            $total_to_be_updated = PoSub::query()
                ->withCount([
                    'poSubsPoints' => function ($poSubPoints) use ($as) {
                        $poSubPoints->having("sum(points)", ">", $as);
                    }
                ])
                ->first();

            $chunkSize = Setting::$chunk_size;
            $loopEnd = ceil($total_to_be_updated / $chunkSize);

            for ($i = 1; $i <= $loopEnd; $i++) {
                BadgeNotifyJob::dispatch($chunkSize);
            }
        } catch (Exception $error) {
            Log::error($error);
        }
    }
}
