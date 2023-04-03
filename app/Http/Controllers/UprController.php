<?php

namespace App\Http\Controllers;

use App\Models\Upr;
use Illuminate\Http\Request;

class UprController extends Controller
{
    public function index()
    {

        $upr = Upr::query()
            ->first();

            return $upr;
    }
}
