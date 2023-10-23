<?php

namespace App\Jobs;

use App\Http\Components\Traits\CalendarHelperTrait;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderDetailsCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CalendarHelperTrait;

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
            // ->createdYesterday() //unhide it after test
            ->where('date', '2023-10-03') // hide it after test
            ->limit($this->limit)
            ->get();

        $data = [];
        foreach ($orderDetailsToBeCreated as $orderDetail) {
            $data[] = [
                'order_id' => $orderDetail->order_id,
                'product_id' => $orderDetail->product_id,
                'date' => Carbon::parse($orderDetail->date)->addDay(1),
                'unit_price' => $orderDetail->unit_price,
                'quantity' => $orderDetail->quantity,
                'cron_updated_at' => $this->getCurrentTime(),
                'cron_updated_by' => get_class($this)
            ];
        }

        OrderDetail::upsert(
            $data,
            ['date', 'order_id', 'product_id']
        );
    }
}
