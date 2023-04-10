 // return 0;

        // return 'test';
        // dd(
        //     // Http::get(
        //     //     route('tt')
        //     // )

        //     (new UprController())->index()
        // );


        // dd(P::with('poSubs')->get());

        // $test = Po::query()
        //     ->withCount([
        //         'poSubs' => function ($poSub) {
        //             $poSub->where('p_cat_id', 1)
        //                 ->where('date', date('Y-m-d'))
        //                 ->groupBy('user_id');
        //         }
        //     ])
        //     ->get();

        // $test = (new BadgeNotifyCron())->index();

        // dd($test);

        $badgeByPoints = Badge::query()
        ->selectRaw('min(necessary_rizz_points_start) as minPoints, min(necessary_accuracy_start) as minAccuracy, min(necessary_streak_start) as minSteak')
        ->first();

        // $count = DB::table('po_subs as ps')
        // ->leftJoinSub( 
        //     DB::table(function ($ps_points) use($badgeByPoints) {
        //         $ps_points->from('po_subs')
        //             ->selectRaw('user_id, sum(points) as sumPoints')
        //             ->groupBy('user_id')
        //             ->having('sumPoints', '>', $badgeByPoints->minPoints);
        //     }),
        //     'psp',
        //     function ($join) {
        //         $join->on('psp.user_id', '=', 'ps.user_id');
        //     }
        // )
        // ->leftJoinSub( 
        //     DB::table(function ($ps_points) use($badgeByPoints) {
        //         $ps_points->from('po_subs')
        //             ->selectRaw('user_id, sum(accuracy) as sumAccuracy')
        //             ->groupBy('user_id')
        //             ->having('sumAccuracy', '>', $badgeByPoints->minAccuracy);
        //     }),
        //     'psa',
        //     function ($join) {
        //         $join->on('psa.user_id', '=', 'ps.user_id');
        //     }
        // )
        // ->selectRaw('ps.user_id, count(ps.user_id) as cu, sumPoints')
        // ->groupBy('ps.user_id')
        // // ->selectRaw('ps.user_id, count(psp.user_id)')
        // // ->where('ps.user_id', 1)
        // // ->having('sumPoints', '!=', null)
        // ->get();

   //     SELECT
            //     ps.user_id, b.id, psp.sumP
            // FROM
            //     po_subs as ps
            //     INNER JOIN (
            //         SELECT
            //             user_id,
            //             SUM(points) as sumP
            //         FROM
            //             po_subs
            //         GROUP BY
            //             user_id
            //         HAVING(sumP > 0)
            //     ) as psp on psp.user_id = ps.user_id
            //     INNER JOIN badges as b on sumP BETWEEN b.necessary_rizz_points_start
            //     AND b.necessary_rizz_points_end
            // GROUP BY
            //     ps.user_id
                

            // DB::table('orders')
            // ->join(DB::raw('(SELECT id FROM customers WHERE email LIKE "joh%") AS c'), function ($join) {
            //     $join->on('orders.customer_id', '=', 'c.id');
            // })
            // ->whereBetween('orders.total_price', [100, 200])
            // ->select('orders.*')
            // ->get();

        $count = DB::table('po_subs as ps')
        ->selectRaw('ps.user_id')
        ->joinSub( 
            DB::table(function ($ps_points) use($badgeByPoints) {
                $ps_points->from('po_subs')
                    ->selectRaw('user_id, sum(points) as sumP')
                    ->groupBy('user_id')
                    ->having('sumP', '>', $badgeByPoints->minPoints);
            }),
            'psp',
            function ($join) {
                $join->on('psp.user_id', '=', 'ps.user_id');
            }
        )
        ->join('badges as b', 'sumP', 'between', ['b.necessary_rizz_points_start', 'b.necessary_rizz_points_end'])
        ->groupBy('ps.user_id')
        ->get();