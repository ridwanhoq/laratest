<?php

namespace App\Http\Components\Crons;

use App\Models\Aw;
use App\Models\Badge;
use App\Models\Ur;
use Illuminate\Support\Facades\DB;

class UawUpdateCron
{

    public function index()
    {

        $awMin = Badge::query()
            ->selectRaw('min(necessary_rizz_points_start) as minPoints, min(necessary_accuracy_start) as minAccuracy, min(necessary_streak_start) as minSteak')
            ->first();

        $test = Ur::query()
            ->get();

        //             SELECT
        // a.id, ur.user_id, a.range_start, a.range_end
        // -- *
        // FROM
        // urs as ur
        // INNER JOIN aws as a 
        // on ur.rizz_points BETWEEN a.range_start and a.range_end
        // INNER JOIN users as u on u.id = ur.user_id
        // WHERE 
        // ur.user_id = 6
        // AND `type` = 1
        // AND (u.last_award_id_for_points is NULL OR u.last_award_id_for_points != a.id)
        // ORDER by a.id DESC

        $uawPointsCount = DB::table("urs as ur")
            ->join("aws as a", function ($join) {
                $join->on(function ($q) {
                    $q->whereBetween('ur.rizz_points', [DB::raw('a.range_start'), DB::raw('a.range_end')]);
                });
            })
            ->join("users as u", function ($join) {
                $join->on("u.id", "=", "ur.user_id");
            })
            ->select("a.id", "ur.user_id", "a.range_start", "a.range_end")
            ->where("ur.user_id", "=", 6)
            ->where("a.type", "=", 1)
            ->where(function ($wh) {
                $wh->whereNull('u.last_award_id_for_points')->orWhere('u.last_award_id_for_points', '!=', 'a.id');
            })
            ->count();

        $uawAccuracyCount = DB::table("urs as ur")
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

        $uawStreakCount = DB::table("urs as ur")
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



        dd($uawPointsCount + $uawAccuracyCount + $uawStreakCount);

        // Ur::query()
        //     ->where('rizz_points', '>=', $awMin)
        //     ->whereNull('last_award_id')
        //     ->orWhereHas('uaw', function($uaw){
        //         // $uaw->whereNotIn('');
        //     })
        //     ->count();

        // Ur::query()
        // ->whereHas('user', function($user){
        //     $user->whereNull('last_badge_id')
        //     ->orWhere('last_badge_id');
        // })
        // ->count();




        $total_to_be_updated = 0;
    }
}
