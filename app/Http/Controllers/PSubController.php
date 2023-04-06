<?php

namespace App\Http\Controllers;

use App\Models\P;
use App\Models\PSub;
use Illuminate\Http\Request;

class PSubController extends Controller
{
    public function index()
    {

        PSub::query()
            ->groupBy('p_cat_id')
            ->count('p_cat_id');

        PSub::query()
            ->groupBy('p_cat_id')
            ->avg('p_cat_id');


        $pollPoints = P::query()
            ->with('pqs')
            ->get();



        //             >> pollParticipants 
        // >> totalPoints
        // >> allPoints
        // >> avgPoints

        P::query()
            ->withCount([
                'pSubs' => function ($pSub) {
                    $pSub->where('p_cat_id', 1)
                        ->where('date', date('Y-m-d'))
                        ->first();
                }
            ])
            ->get();
    }
}
