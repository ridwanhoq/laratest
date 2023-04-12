<?php

namespace App\Http\Components\Traits;

use App\Models\CronJobFailLog;

trait CronJobFailLogTrait
{

    public function CronFailLogCreate($error){
        CronJobFailLog::create([
            'model'             => get_class($this),
            'error_code'        => $error->getCode(),
            'error_details'     => $error
        ]);
    }


}
