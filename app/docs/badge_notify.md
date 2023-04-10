
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



 
    $test = DB::table('institutions as inst')
    ->joinSub(
        DB::table(function($sec){
                    $sec->from('sections as s')
                    ->select(['institution_id', DB::raw('count(institution_id) as c_inst')])
                    ->where('institution_id', '=', 22016)
                    ->groupBy('institution_id');
                })
                , 'sec_count',
                function($join){
                            $join->on('sec_count.institution_id', '=', 'inst.id');
    })
    ->joinSub(
        DB::table(function($teachers){
                    $teachers->from('teachers as t')
                    ->select(['institution_id', DB::raw('count(institution_id) as t_inst')])
                    ->where('institution_id', '=', 22016)
                    ->groupBy('institution_id');
                })
                , 'teacher_count',
                function($join){
                            $join->on('teacher_count.institution_id', '=', 'inst.id');
    })
    ->joinSub(
        DB::table(function($student_progress){
                    $student_progress->from('student_progress as sp')
                    ->select(['institution_id', DB::raw('count(institution_id) as sp_inst')])
                    ->where('institution_id', '=', 22016)
                    ->where('academic_year', '=', 2022)
                    ->groupBy('institution_id');
                })
                , 'sp_count',
                function($join){
                            $join->on('sp_count.institution_id', '=', 'inst.id');
    })
    ->select('c_inst', 't_inst', 'sp_inst')
    ->first();



DB::table('po_subs as ps')
->joinSub(
    DB::table(function($ps_points){
        $ps_points->from('po_subs as psp')
        ->selectRaw('psp.user_id, sum(psp.points) as sumPoints')
        ->having('sumPoints', '>', $badgeByPoints->minPoints)
    })
)
->groupBy('user_id)
->first();






//             SELECT
// --     count(ps.user_id), ps.user_id, COUNT(psp.user_id), COUNT(psa.user_id)
// -- ps.user_id, cp, ca
// sumP, sumA, COUNT(IF(sumA is not NULL, 1, 0)) as c
// FROM
//     po_subs as ps
//     LEFT JOIN (
//         SELECT
//             user_id
//             ,
//             sum(points) as sumP
// --             ,
// --             COUNT(IF(sum(points) > 1000, 1, 0 )) as cp
//         FROM
//             po_subs
//         GROUP BY
//             user_id
//             HAVING (sumP > 1000)
//     ) as psp on psp.user_id = ps.user_id
//     LEFT JOIN (
//         SELECT
//             user_id,
//             sum(accuracy) as sumA
// --             A,
// --             COUNT( user_id) as ca
//         FROM
//             po_subs
//         GROUP BY
//             user_id
//         HAVING(sumA > 10)
//     ) as psa on psa.user_id = ps.user_id
// -- WHERE
// --     ps.user_id = 1
// GROUP BY
//     ps.user_id
//     HAVING (sumA is not NULL || sumP is not NULL)
// -- HAVING(ps.user_id > 1 && ps.user_id < 13)


