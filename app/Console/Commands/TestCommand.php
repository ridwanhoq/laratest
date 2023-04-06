<?php

namespace App\Console\Commands;

use App\Http\Controllers\UprController;
use App\Models\P;
use App\Models\Po;
use App\Models\UopqaPubResSub;
use Illuminate\Console\Command;
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
        // return 0;

        // return 'test';
        // dd(
        //     // Http::get(
        //     //     route('tt')
        //     // )

        //     (new UprController())->index()
        // );


        // dd(P::with('pSubs')->get());

        $test = Po::query()
            ->withCount([
                'poSubs' => function ($pSub) {
                    $pSub->where('p_cat_id', 1)
                        ->where('date', date('Y-m-d'))
                        ->groupBy('user_id');
                }
            ])
            ->get();

        dd($test);
    }
}
