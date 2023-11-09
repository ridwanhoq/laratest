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

    public function getDateBeforeYesterday(){
        return Carbon::yesterday()->subDay()->toDateString();
    }

    public function getDateOfLastFriday(){
        return Carbon::parse('last friday')->toDateString();
    }

    public function getLastDayOfLastMonth(){
        return $this->carbonNow()->subMonth()->endOfMonth()->toDateString();
    }

    /**
     * OrderDetail model related codes
     */
    public function getLastOrderDateByOrderType($orderType){
        switch($orderType){
            case 'weekly':
                $date = $this->getDateOfLastFriday();
                break;
            case 'day_after_day':
                $date = $this->getDateBeforeYesterday();
                break;
            default:
                $date = $this->getYesterday();
                break;
        }

        return $date;
    }
}