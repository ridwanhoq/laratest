<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderDetailsCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $limit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($limit = 10)
    {
        $this->limit = $limit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orderDetailsToBeCreated = OrderDetail::query()
            ->whereHas(
                'order',
                function ($order) {
                    $order->needToCreateOrderDetails();
                }
            )
            ->createdYesterday()
            ->limit($this->limit)
            ->get();

        $data = [];
        foreach ($orderDetailsToBeCreated as $orderDetail) {
            $data[] = [
                'order_id' => $orderDetail->order_id,
                'product_id' => $orderDetail->product_id,
                'unit_price' => $orderDetail->unitPrice,
                'quantity' => $orderDetail->quantity
            ];
        }

        OrderDetail::insert($data);

    }
}
