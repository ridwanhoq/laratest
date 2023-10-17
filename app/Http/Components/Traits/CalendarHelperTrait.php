<?php

namespace App\Http\Components\Traits;

use Carbon\Carbon;

trait CalendarHelperTrait{
    public function getToday(){
        return Carbon::now()->toDateString(); 
    }
}