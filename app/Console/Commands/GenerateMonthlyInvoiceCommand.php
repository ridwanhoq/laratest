<?php

namespace App\Console\Commands;

use App\Http\Components\Traits\CalendarHelperTrait;
use App\Models\MonthlyInvoice;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;

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

        // return 0;

        // this command should be run on first day 00 of each month
        // count total how many order details are created
        OrderDetail::query()
            ->withinDateRange()
            ->whereHas('order', function ($order) {
                $order
                    ->daily()
                    ->running()
                    ->invoiceIsNotCreated();
            })->count();

        $order = Order::query()
            ->daily()
            ->running()
            ->invoiceIsNotCreated()
            ->first();

        // make invoice
        // $table->unsignedBigInteger('order_id');
        //     $table->foreign('order_id')->references('id')->on('orders');
        //     $table->unsignedBigInteger('client_id');
        //     $table->foreign('client_id')->references('id')->on('clients');
        //     $table->date('invoice_date');
        //     $table->decimal('invoice_amount', 20, 2)->default(0);
        //     $table->decimal('paid_amount', 20, 2)->default(0);

        $data = [
            [
                'order_id' => $order->id,
                'client_id' => optional($order->client)->id,
                'invoice_amount' => $order->grand_total ?? 0,
                'paid_amount' => 0,
                'invoice_date' => $this->getLastDayOfLastMonth()
            ],

        ];
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
