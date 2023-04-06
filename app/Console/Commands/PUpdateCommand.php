<?php

namespace App\Console\Commands;

use App\Models\P;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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

        try {

            P::query()
            ->where('date', date('Y-m-d'))
            ->update([
                'is_active' => true
            ]);

        } catch (Exception $error) {
            Log::error($error);
        }


    }
}
