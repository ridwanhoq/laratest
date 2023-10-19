<?php

use App\Jobs\OrderDetailsCreateJob;
use App\Models\Order;
use App\Models\OrderDetail;

class GenerateOrderDetailsRepository
{

    public function generate()
    {

        try {


            $chunkSize = 10;

            $totalOrderDetailsToBeCreated = OrderDetail::query()
                ->whereHas(
                    'order',
                    function ($order) {
                        $order->needToCreateOrderDetails();
                    }
                )
                ->createdYesterday()
                ->count();

            $loopEndLimit = ceil($totalOrderDetailsToBeCreated / $chunkSize);

            foreach(range(1, $loopEndLimit) as $range){
                OrderDetailsCreateJob::dispatch($chunkSize);
            }

        } catch (Exception $error) {
        }
    }
}
