<?php

namespace App\Jobs;

use App\Models\UopqaPubResSub;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UopqaPubResSubUpdateJob implements ShouldQueue
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
        // CronJobLog::create([
        //     'log_name'          => 'Mgml Unit Score Upgrade',
        //     'affected_tables'   => 'mgml_unit_scores',
        //     'description'       => 'Upgraded unit, unit start, end date',
        //     'class_name'        => get_class($this)
        // ]);

        $uopqas = UopqaPubResSub::query()
                ->where('date', date('Y-m-d'))
                ->where('user_id', auth()->user()->id)
                ->limit()
                ->get()
                ->toArray();

                $data = array_reduce($uopqas, function($carry, $uopqa){
                    $data = [
                        '' => $uopqa['']
                    ];

                    array_push($carry, $data);

                    return $carry;
                }, []);

                if(!empty($data)){
                    try {
                        DB::table('uopqa_pub_res_subs')->upsert(
                            $data,
                            ['user_id', 'uopqa_option_id', 'date'],
                            ['is_correct']
                        );
                    } catch (Exception $error) {
                        Log::error($error);
                    }
                }


    }
}
