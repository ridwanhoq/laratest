<?php

namespace App\Jobs;

use App\Http\Components\Setting;
use App\Models\CronJobLog;
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

    private $chunk_size;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chunk_size)
    {
        $this->chunk_size = $chunk_size;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            // CronJobLog::create([
            //     'log_name'          => 'Mgml Unit Score Upgrade',
            //     'affected_tables'   => 'mgml_unit_scores',
            //     'description'       => 'Upgraded unit, unit start, end date',
            //     'class_name'        => get_class($this)
            // ]);

            $uopqas = UopqaPubResSub::query()
                ->select('id', 'pqa_option_id', 'user_id', 'date')
                ->where('date', date('Y-m-d'))
                ->with([
                    'upqaOptionCount' => function ($upqaOptionCount) {
                        $upqaOptionCount
                            // ->select('id', 'pqa_option_id', 'percentage')
                            ->selectRaw('id, pqa_option_id, percentage, max(percentage) as mxp')
                            ->where('date', date('Y-m-d'))
                            ->groupBy('id', 'pqa_option_id', 'percentage');
                        // ->where();
                    }
                ])
                ->limit($this->chunk_size)
                ->get()
                ->toArray();

            $data = array_reduce($uopqas, function ($carry, $uopqa) {

                $is_ans_match_with_maj_pub = false;

                if ($uopqa['upqa_option_count'] !== null) {
                    $is_ans_match_with_maj_pub = $uopqa['upqa_option_count']['percentage'] == $uopqa['upqa_option_count']['mxp'];
                }

                $data = [
                    'is_ans_match_with_maj_pub' => $is_ans_match_with_maj_pub,
                    'user_id'                   => $uopqa['user_id'],
                    'pqa_option_id'             => $uopqa['pqa_option_id'],
                    'date'                      => $uopqa['date']
                ];

                array_push($carry, $data);

                return $carry;
            }, []);

            if (!empty($data)) {
                try {

                    $this->uopqaPubResSubUpdate($data);

                    $this->resetAutoIncrementUopqaPubSub();

                    $this->cronJobLogUpdateByUopqaPubResSub();
                } catch (Exception $error) {
                    Log::error($error);
                    dd($error);
                }
            }
        } catch (Exception $error) {
            dd($error);
        }
    }

    private function uopqaPubResSubUpdate($data)
    {
        DB::table('uopqa_pub_res_subs')->upsert(
            $data,
            ['user_id', 'pqa_option_id', 'date'],
            ['is_ans_match_with_maj_pub']
        );
    }

    private function resetAutoIncrementUopqaPubSub()
    {
        /**
         * reset auto increment to 0 or last id
         * cause upsert increases unnecessary ids
         */
        $last_uopqa_pub_res_sub_id = UopqaPubResSub::last()->id;
        $last_id = $last_uopqa_pub_res_sub_id > 0 ? $last_uopqa_pub_res_sub_id + 1 : 1;
        DB::statement("ALTER TABLE uopqa_pub_res_subs AUTO_INCREMENT = {$last_id};"); //dd('test132');
    }

    private function cronJobLogUpdateByUopqaPubResSub()
    {
        CronJobLog::create([
            'log_name'          => 'UopqaPubResSub Update',
            'affected_tables'   => 'uopqa_pub_res_subs',
            'description'       => 'Updated is_ans_match_with_maj_pub for each [user_id, pqa_option_id, date] set',
            'class_name'        => get_class($this)
        ]);
    }
}
