<?php

namespace App\Http\Controllers;

use App\Events\NewTradeEvent;
use Exception;
use Illuminate\Http\Request;

class SendMessageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        try {
            event(new NewTradeEvent('Test message'));
            // broadcast(new NewTradeEvent(['msg' => 'Test msg']))->toOthers();
        } catch (Exception $error) {
            // dd($error);
            return $error;
        }
    }
}
