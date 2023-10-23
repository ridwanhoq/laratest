<?php

namespace App\Http\Components\Services;

class SmsTemplateService
{

    public function makeMonthlyDueInvoice($data)
    {
        return "Dear {$data['client_name']}, your current due is {$data['invoice_due']} and your total due is {$data['total_due']}, Please pay as soon as possible.";
    }
}
