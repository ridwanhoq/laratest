<?php

namespace App\Http\Components\Traits;

use Carbon\Carbon;

trait CalendarHelperTrait
{
    public function add_days_and_return_date_after_added_days($date = null, $total_days = 1)
    {

        $date = $date != null ? $date : $this->get_today();

        return Carbon::parse($date)->addDays($total_days)->toDateString();
    }

    public function sub_days_and_return_date_before_subtracted_days($date = null, $total_days = 1)
    {

        $date = $date != null ? $date : $this->get_today();

        return Carbon::parse($date)->subDays($total_days)->toDateString();
    }

    public function get_today()
    {
        return $this->carbon_now()->toDateString();
    }

    public function carbon_now()
    {
        return Carbon::now(); // unhide it after testing
        // return Carbon::now()->addMonth()->startOfMonth();//for testing purpose
        // return Carbon::now()->subMonth()->startOfMonth();//for testing purpose
        // return Carbon::now()->addMonth(18)->addDay();
        // return Carbon::now()->addMonth()->addDay(8);
        // return Carbon::now()->addDays(90);
        // return Carbon::now()->subDays(4);
    }
}
