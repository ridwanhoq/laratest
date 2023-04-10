<?php

namespace App\Console\Commands;

use App\Http\Components\Crons\BadgeNotifyCron;
use App\Http\Components\Crons\BadgeUpdateCron;
use App\Http\Controllers\UprController;
use App\Models\Badge;
use App\Models\P;
use App\Models\Po;
use App\Models\UopqaPubResSub;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $count = 0;


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

        dd($count);
    }
}
