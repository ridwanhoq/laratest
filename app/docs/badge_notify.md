
            // PoSub = PollSubmission

            $badgeByPoints = Badge::query()
                ->selectRaw('min(necessary_rizz_points) as minPoints, min(necessary_accuracy) as minAccuracy, min(necessary_streak) as minSteak')
                ->first();
// dd($badgeByPoints->minAccuracy);
            $query = PoSub::query()
                // ->poSubPoints($badgeByPoints->minPoints)
                // ->poSubAccuracy($badgeByPoints->minAccuracy)
                // ->poSubStreak($badgeByPoints->minStreak)
                ->whereHas('poSubsPoints', function ($poSubsPoints) use ($badgeByPoints) {
                    $poSubsPoints->selectRaw('user_id, sum(points) as sumPoints')
                        ->groupBy('user_id')
                        ->having('sumPoints', '>', $badgeByPoints->minPoints);
                })
                // ->orWhereHas('poSubsStreak', function ($poSubsStreak) use($badgeByPoints) {
                //     $poSubsStreak->selectRaw('user_id, sum(streak) as sumStreak')
                //         ->groupBy('user_id')
                //         ->having('sumStreak', '>', $badgeByPoints->minStreak);
                // })

            ;

            $query = DB::table('po_subs as ps')
                ->join('po_subs as psp', 'psp.user_id', '=', 'ps.user_id')
                ->join('po_subs as psa', 'psa.user_id', '=', 'ps.user_id')
                ->selectRaw('psp.user_id, sum(psp.points) as sumPoints, sum(psa.accuracy) as sumAccuracy')
                ->having('sumPoints', '>', $badgeByPoints->minPoints)
                // ->orHaving('sumAccuracy', '>', $badgeByPoints->minAccuracy)
                ;

            // $countPoints = $query->groupBy('user_id')->count();
            $countPoints = $query->groupBy('ps.user_id')->count();
            // dd($countPoints);

            