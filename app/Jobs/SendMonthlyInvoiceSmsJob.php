<?php

namespace App\Jobs;

use App\Http\Components\Services\SendSmsService;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMonthlyInvoiceSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
            ->invoiceSmsNotSent()
            ->skip($this->skip)
            ->take($this->take)
            ->get();


        foreach ($orders as $order) {

            $client = Client::find($order->client_id);

            if (!empty($client)) {
                $invoice_amount = $order->grand_total * $order->order_details_count;
                $total_due = $client->balance + $invoice_amount;

                $data = [
                    'client_name' => $client->name,
                    'client_phone' => optional($client->profile)->phone ?? '',
                    'invoice_due' => $invoice_amount,
                    'total_due' => $total_due
                ];

                $sendSms = (new SendSmsService())->sendSingleSms(
                    $data
                );

                if($sendSms){
                    $order->update([
                        'is_sms_sent' => true
                    ]);
                }
                
            }
        }




        // $data = [
        //     'skip' => $skip,
        //     'take' => $chunkSize,
        //     'invoice_due' => ,
        //     'total_due' => 0,
        //     'order_id' => 0        
        // ];  



        // $skip = $this->data['skip'];
        // $take = $this->data['take'];
        // $invoice_due = $this->data['invoice_due'];
        // // $total_due = $this->data['total_due'];
        // $order_id = $this->data['order_id'];



    }
}
