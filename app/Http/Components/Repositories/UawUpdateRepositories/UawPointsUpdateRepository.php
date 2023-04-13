<?php

namespace App\Http\Components\Repositories\UawUpdateRepositories;

use App\Models\Aw;
use Illuminate\Support\Facades\DB;

class UawPointsUpdateRepository
{

    public function uawPoints()
    {
        return DB::table("urs as ur")
            ->join("aws as a", function ($join) {
                $join->on(function ($q) {
                    $q->whereBetween('ur.rizz_points', [DB::raw('a.range_start'), DB::raw('a.range_end')]);
                });
            })
            ->join("users as u", function ($join) {
                $join->on("u.id", "=", "ur.user_id");
            })
            ->select("a.id", "ur.user_id", "a.range_start", "a.range_end")
            ->where("a.type", "=", Aw::$typeIdForPoints)
            ->where(function ($wh) {
                $wh->whereNull('u.last_award_id_for_points')->orWhereColumn('u.last_award_id_for_points', '!=', 'a.id');
            });
    }
}
