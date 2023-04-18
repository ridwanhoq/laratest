<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function getAttendanceData()
    {
        // Fetch attendance, leave, absent, and other events data from the database
        // using Laravel's query builder or Eloquent ORM

        $data = [
            'title'     => "Present",
            'start'     => '1',
            'end'       => '20'
        ];

        // Return the data in a format that can be consumed by FullCalendar
        return response()->json($data);
    }
}
