<?php

use App\Models\Order;

class GenerateOrderDetailsRepository{

    public function generate(){

        try {
            
            $orderDetailsToBeCreated = Order::query()
            ->running()
            ->chunk();




        } catch (Exception $error) {
            
        }



    }




}