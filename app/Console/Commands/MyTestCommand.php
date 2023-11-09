<?php

namespace App\Console\Commands;

use App\Http\Components\Traits\CalendarHelperTrait;
use Illuminate\Console\Command;

class MyTestCommand extends Command
{
    use CalendarHelperTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test_cmd:run';

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
        dd($this->getDateOfLastFriday());
        // return 0;
        dd(date('D'));
    }
}
