<?php

namespace App\Http\Components\Crons;

use App\Http\Components\Setting;
use App\Http\Components\Traits\CalendarHelperTrait;
use App\Jobs\BadgeNotifyJob;
use App\Models\Badge;
use App\Models\PoSub;
use App\Models\Upr;
use Exception;
use Illuminate\Support\Facades\Log;

class BadgeNotifyCron
{

    use CalendarHelperTrait;

    public function index()
    {

        try {
            // PoSub = PollSubmission

            $badgeByPoints = Badge::query()
                ->selectRaw('min(necessary_rizz_points) as minPoints, min(necessary_accuracy) as minAccuracy, min(necessary_streak) as minSteak')
                ->first();
                
            $query = PoSub::query()
                ->poSubPoints($badgeByPoints->minPoints)
                ->poSubAccuracy($badgeByPoints->minAccuracy)
                // ->poSubStreak($badgeByPoints->minStreak)
                ;

            $countPoints = $query->count();
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
