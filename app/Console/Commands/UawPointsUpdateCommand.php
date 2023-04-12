<?php

namespace App\Console\Commands;

use App\Http\Components\Crons\UawUpdateCron\UawPointsUpdateCron;
use Illuminate\Console\Command;

class UawPointsUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uaw-points:update';

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
        // return 0;
        (new UawPointsUpdateCron())->index();
    }
}
