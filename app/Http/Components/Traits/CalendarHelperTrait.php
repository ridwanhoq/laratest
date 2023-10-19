<?php

namespace App\Http\Components\Traits;

use Carbon\Carbon;

trait CalendarHelperTrait{

    public function carbonNow(){
        return Carbon::now();
    }

    public function getCurrentTime(){
        return $this->carbonNow()->toDateTimeString();
    }

    public function getToday(){
        return $this->carbonNow()->toDateString(); 
    }
    
    public function getYesterday(){
        return Carbon::yesterday()->toDateString(); 
    }
}