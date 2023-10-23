<?php

namespace App\Jobs;

use App\Http\Components\Traits\CalendarHelperTrait;
use App\Models\Client;
use App\Models\MonthlyInvoice;
use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

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
        $monthlyInvoiceData = [];
        $userBalance = [];
        foreach ($orders as $order) {
            $invoice_amount = $order->grand_total * $order->order_details_count;

            $monthlyInvoiceData[] =
                [
                    'order_id' => $order->id,
                    'client_id' => $order->client_id,
                    'invoice_date' => $this->getLastDayOfLastMonth(),
                    'invoice_amount' => $invoice_amount,
                    'paid_amount' => 0,
                    'is_fully_paid' => false
                ];

            $user = User::find($order->client->id);
            if(!empty($user)){
                $user->update([
                    'balance' => DB::raw('balance') + $invoice_amount
                ]); 
            }

            //create send sms job     
                SendMonthlyInvoiceSmsJob::dispatch(
                    $this->skip,
                    $this->take
                );
    
        }

        MonthlyInvoice::upsert($monthlyInvoiceData, ['invoice_date', 'order_id']);
    }
}
