<?php

namespace App\Http\Components;

class Setting{
    public static function get($key){
        return config($key);
    }

    public static function set($key, $value){
        return config()->set($key, $value);
    }

    public static function orderStatusesArray(){
        return [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'returned' => 'Returned',
            'refunded' => 'Refunded',
        ];
    }
    
    public static function paymentMethodsArray(){
        return [
            'cash' => 'Cash',
            'credit_card' => 'Credit Card',
            'bank_transfer' => 'Bank Transfer',
        ];
    }
    
    public static function orderStatuses(){
        return self::orderStatusesArray();
    }
    
    public static function paymentMethods(){
        return self::paymentMethodsArray();
    }
    
}