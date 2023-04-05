<?php

namespace App\Console\Commands;

use App\Http\Components\Repositories\UopqaPubResSubUpdateRepository;
use Illuminate\Console\Command;

class UopqaPubResSubUpdateCommand extends Command
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
        // return 0;
        (new UopqaPubResSubUpdateRepository())->index();
    }
}
