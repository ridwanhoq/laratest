<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class BadgeNotifyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $count = DB::select("SELECT
        ps.user_id, b.id, psp.sumP
    FROM
        po_subs as ps
        INNER JOIN (
            SELECT
                user_id,
                SUM(points) as sumP
            FROM
                po_subs
            GROUP BY
                user_id
            HAVING(sumP > 0)
        ) as psp on psp.user_id = ps.user_id
        INNER JOIN badges as b on sumP BETWEEN b.necessary_rizz_points_start
        AND b.necessary_rizz_points_end
    GROUP BY
        ps.user_id
        ");
    }
}
