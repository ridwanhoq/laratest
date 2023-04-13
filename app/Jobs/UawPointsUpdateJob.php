<?php

namespace App\Jobs;

use App\Http\Components\Repositories\UawUpdateRepositories\UawPointsUpdateRepository;
use App\Http\Components\Traits\CronJobFailLogTrait;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UawPointsUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CronJobFailLogTrait;

    private $chunkSize;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chunkSize)
    {
        $this->chunkSize = $chunkSize;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            $uawPonitsToBeUpdated = (new UawPointsUpdateRepository())
                ->uawPoints()
                ->limit($this->chunkSize)
                ->get()
                ->toArray();
            $data = [];
            foreach ($uawPonitsToBeUpdated as $uawPonit) {
                $data[] = [
                    'aw_id'     => $uawPonit->id,
                    'user_id'   => $uawPonit->user_id
                ];

                User::find($uawPonit->user_id)->update([
                    'last_award_id_for_points' => $uawPonit->id
                ]);
            }
            
            try {
                DB::table('uaws')->upsert(
                    $data,
                    ['user_id', 'aw_id'],
                    ['user_id', 'aw_id']
                );

                
            } catch (Exception $error) {
                $this->CronFailLogCreate($error);
            }
        } catch (Exception $error) {
            Log::info($error);
        }
    }
}
