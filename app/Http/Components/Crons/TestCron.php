<?php

namespace App\Http\Components\Crons;

use App\Http\Components\Crons\UawUpdateCron\UawAccuracyUpdateCron;
use App\Http\Components\Crons\UawUpdateCron\UawPointsUpdateCron;
use App\Http\Components\Crons\UawUpdateCron\UawStreakUpdateCron;

class TestCron{
    public function index(){
        (new UawPointsUpdateCron())->index();
        (new UawAccuracyUpdateCron())->index();
        (new UawStreakUpdateCron())->index();
    }
}