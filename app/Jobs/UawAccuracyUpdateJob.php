<?php

namespace App\Jobs;

use App\Http\Components\Repositories\UawUpdateRepositories\UawAccuracyUpdateRepository;
use App\Http\Components\Traits\CronJobFailLogTrait;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UawAccuracyUpdateJob implements ShouldQueue
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
            $uawPonitsToBeUpdated = (new UawAccuracyUpdateRepository())
            ->uawAccuracy()
            ->limit($this->chunkSize)
            ->get()
            ->toArray();

        $data = array_reduce($uawPonitsToBeUpdated, function ($carry, $uawPonit) {
            $data = [
                'aw_id'     => $uawPonit['id'],
                'user_id'   => $uawPonit['user_id']
            ];

            array_push($carry, $data);

            return $carry;
        }, []);

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
