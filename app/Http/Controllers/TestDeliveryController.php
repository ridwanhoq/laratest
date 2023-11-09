<?php

namespace App\Http\Controllers;

use App\Http\Components\Traits\CalendarHelperTrait;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestDeliveryController extends Controller
{
    use CalendarHelperTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {

            $serviceFrequencies = [
                'daily' => 'Daily',
                'weekly' => 'Weekly'
            ];

            $zones = [
                1 => 'Zone 1',
                2 => 'Zone 2',
                3 => 'Zone 3',
                4 => 'Zone 4',
                5 => 'Zone 5',
            ];

            $orders = Order::query()
                ->with(['lastOrderDetails' => function($lastOrderDetails){
                    $lastOrderDetails->lastOrderByOrderType(
                        DB::raw('orders.service_frequency')
                    );
                }])
                ->paginate(2);

            return view(
                'test_delivery.index',
                compact(
                    'orders',
                    'serviceFrequencies',
                    'zones'
                )
            );
        } catch (Exception $error) {
            dd($error);
        }
    }

    public function storeOrderDetail()
    {
        try {
            $orderDetail = OrderDetail::find(
                request()->orderDetailId
            );


            if(request()->isOrderDetailChecked){
                $quantity = $orderDetail->quantity;
                $additional_charge = $orderDetail->additional_charge;
                $discount = $orderDetail->discount;                    
            }else{
                $quantity = 0;
                $additional_charge = 0;
                $discount = 0; 
            }

            $orderDetail = OrderDetail::updateOrCreate(
                [
                    'date' => $this->getToday(),
                    'order_id' => $orderDetail->order_id,
                    'product_id' => $orderDetail->product_id
                ],
                [
                    'order_id' => $orderDetail->order_id,
                    'product_id' => $orderDetail->product_id,
                    'date' => $this->getToday(),
                    'unit_price' => $orderDetail->unit_price,
                    'quantity' => $quantity,
                    'additional_charge' => $additional_charge,
                    'discount' => $discount
                ]
            );

            return $orderDetail->id;
            
        } catch (Exception $error) {
            return $error;
        }
    }
}
