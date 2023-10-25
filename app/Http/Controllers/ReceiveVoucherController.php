<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReceiveVoucherRequest;
use App\Models\ReceiveVoucher;
use App\Models\PaymentTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiveVoucherController extends Controller
{
    public function store(ReceiveVoucherRequest $request)
    {
        DB::transaction(function () use ($request) {
            $clientId = $request->client_id;
            $amount = $request->amount;

            $receiveVoucher = ReceiveVoucher::create([
                'client_id' => $clientId,
                'amount' => $amount
            ]);

            PaymentTransaction::create([
                'transactional_model' => get_class($this),
                'transactional_id' => $receiveVoucher->id,
                'client_id' => $clientId,
                'money_in' => $amount,
            ]);

            $client = User::client()->find($clientId);
            if (!empty($client)) {
                $currentBalance = $client->balance;
                $client->update([
                    'balance' => $currentBalance - $amount
                ]);
            }
        });
    }
}
