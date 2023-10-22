<?php

namespace App\Jobs;

use App\Http\Components\Traits\CalendarHelperTrait;
use App\Models\MonthlyInvoice;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateMonthlyInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CalendarHelperTrait;

    private $skip, $take;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($skip = 0, $take = 10)
    {
        $this->skip = $skip;
        $this->take = $take;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orders = Order::query()
        ->totalOrderDetailsOfCurrentMonth()
        // ->daily()
        // ->running()
        ->invoiceIsNotCreated()
        ->skip($this->skip)
        ->take($this->take)
        ->get();

        // dd($orders);
        $data = [];
        foreach($orders as $order){
            $data[] = 
                [
                    'order_id' => $order->id,
                    'client_id' => optional($order->client)->id,
                    'invoice_date' => $this->getLastDayOfLastMonth(),
                    'invoice_amount' => $order->grand_total * $order->order_details_count,
                    'paid_amount' => 0,
                    'is_fully_paid' => false
                ]        
            ;
        }

        MonthlyInvoice::upsert($data, ['invoice_date', 'order_id']);

        

    }
}
