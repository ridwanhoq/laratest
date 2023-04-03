<?php

namespace App\Http\Controllers;

use App\Models\Upr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UprController extends Controller
{
    public function index()
    {

        $upr = Upr::query()
            ->withCount([
                'upr as a' => function($upr){
                    $upr->whereColumn('points', '>', 'uprs.points');
                }
            ])
            ->where('user_id', 3)
            ->first();

        return $upr;
    }
}
