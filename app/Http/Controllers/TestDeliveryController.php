<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Exception;
use Illuminate\Http\Request;

class TestDeliveryController extends Controller
{
    public function index()
    {

        try {

            $clients = Client::query()
                ->paginate(2);

            return view(
                'test_delivery.index',
                compact(
                    'clients'
                )
            );
        } catch (Exception $error) {
            dd($error);
        }
    }

    public function storeOrderDetail(){
        try {
            
        } catch (Exception $error) {
            return $error;
        }
    }
}
