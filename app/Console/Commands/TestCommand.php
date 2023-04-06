<?php

namespace App\Console\Commands;

use App\Http\Controllers\UprController;
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

        $uopqas = UopqaPubResSub::query()
            ->select('id', 'pqa_option_id')
            ->where('date', date('Y-m-d'))
            ->with([
                'upqaOptionCount' => function ($upqaOptionCount) {
                    $upqaOptionCount
                    ->selectRaw('id, pqa_option_id, percentage, max(percentage) as mxp')
                    ->where('date', date('Y-m-d'))
                    ->groupBy('id', 'pqa_option_id', 'percentage');
                    // ->where();
                }
            ])
            ->limit(1)
            ->get()
            ->toArray();

        dd($uopqas[0]['upqa_option_count']['percentage']);
    }
}
