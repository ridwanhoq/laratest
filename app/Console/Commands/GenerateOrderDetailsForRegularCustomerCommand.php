<?php

namespace App\Console\Commands;

use App\Jobs\OrderDetailsCreateJob;
use App\Models\OrderDetail;
use Illuminate\Console\Command;

class GenerateOrderDetailsForRegularCustomerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:regular_orders';

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

        // create order details for daily customer


        $chunkSize = 10;

        $totalOrderDetailsToBeCreated = OrderDetail::query()
            ->whereHas(
                'order',
                function ($order) {
                    $order->needToCreateOrderDetails();
                }
            )
            // ->createdYesterday() //unhide it after test
            ->where('date', '2023-10-01')//hide it after test
            ->count();

        $loopEndLimit = ceil($totalOrderDetailsToBeCreated / $chunkSize);

        foreach (range(1, $loopEndLimit) as $range) {
            OrderDetailsCreateJob::dispatch($chunkSize);
        }
    }
}
