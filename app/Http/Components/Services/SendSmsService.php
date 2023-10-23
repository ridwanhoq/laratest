<?php

namespace App\Http\Components\Services;

class SendSmsService{
    public function sendSingleSms($data){

        $message = (new SmsTemplateService())->makeMonthlyDueInvoice($data);
        $receiver = $data['client_phone'];

        return true;
    }


}