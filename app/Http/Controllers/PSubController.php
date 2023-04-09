<?php

namespace App\Http\Controllers;

use App\Models\P;
use App\Models\PoSub;
use App\Models\User;
use Illuminate\Http\Request;

class PoSubController extends Controller
{
    public function index()
    {

        PoSub::query()
            ->groupBy('p_cat_id')
            ->count('p_cat_id');

        PoSub::query()
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
                'poSubs' => function ($poSub) {
                    $poSub->where('p_cat_id', 1)
                        ->where('date', date('Y-m-d'))
                        ->first();
                }
            ])
            ->get();


            $auth_id = auth()->user()->id;

            $user = User::find($auth_id);

            if($user->las){
                
            }




    }
}
