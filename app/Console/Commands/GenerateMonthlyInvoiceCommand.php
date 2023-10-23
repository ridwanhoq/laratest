<?php

namespace App\Console\Commands;

use App\Http\Components\Traits\CalendarHelperTrait;
use App\Jobs\GenerateMonthlyInvoiceJob;
use App\Jobs\SendMonthlyInvoiceSmsJob;
use App\Models\MonthlyInvoice;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateMonthlyInvoiceCommand extends Command
{
    use CalendarHelperTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate_invoice:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will generate monthly invoice for regular (daily, weekly) customers.';

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


        // dd(
        //     OrderDetail::query()
        //     ->where('order_id', 1)
        //     ->groupBy(DB::raw('DATE(created_at)'))
        //     ->count()
        // );

        $totalOrders = Order::query()
            ->totalOrderDetailsOfCurrentMonth()
            // ->daily()
            // ->running()
            ->invoiceIsNotCreated()
            ->count();

        $chunkSize = 10;
        $loopEndLimit = ceil($totalOrders / $chunkSize);

        foreach (range(1, $loopEndLimit) as $range) {
            $skip = $range - 1 * $chunkSize;

            GenerateMonthlyInvoiceJob::dispatch(
                $skip,
                $chunkSize
            );
     

            SendMonthlyInvoiceSmsJob::dispatch(
                $skip,
                $chunkSize
            );
        }


        dd($totalOrders);

        return;

        // return 0;

        // this command should be run on first day 00 of each month
        // count total how many order details are created
        $totalDaysDelivered = OrderDetail::query()
            ->withinDateRange()
            ->whereHas('order', function ($order) {
                $order
                    ->daily()
                    ->running()
                    ->invoiceIsNotCreated();
            })
            ->groupByDate('created_at')
            ->count();

        $orders = Order::query()
            ->daily()
            ->running()
            ->invoiceIsNotCreated()
            ->skip()
            ->take()
            ->get();

        $data = [];
        foreach ($orders as $order) {
            $data[] = [
                [
                    'order_id' => $order->id,
                    'client_id' => optional($order->client)->id,
                    'invoice_date' => $this->getLastDayOfLastMonth(),
                    'invoice_amount' => $order->grand_total * $totalDaysDelivered,
                    'paid_amount' => 0,
                    'is_fully_paid' => false
                ]
            ];
        }


        // make invoice
        /**
         * number of invoices should be = number active orders active in this month 
         */

        MonthlyInvoice::upsert(
            $data,
            [
                'invoice_date',
                'order_id'
            ]
        );

        $order->update([
            'is_invoice_created' => false
        ]);
    }
}
