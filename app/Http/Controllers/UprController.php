<?php

namespace App\Http\Controllers;

use App\Models\Upr;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UprController extends Controller
{
    public function index()
    {

        $upr = Upr::query()
            ->withCount([
                'upr as a' => function ($upr) {
                    $upr->whereColumn('points', '>', 'uprs.points');
                }
            ])
            ->withCount([
                'upr as b' => function ($upr) {
                    $upr->whereColumn('points', '>', 'uprs.points')
                        ->whereHas('user', function ($user) {

                            $loggedUser = User::find(
                                auth()->user()->id
                            );
                            
                            $user->where('country_id', $loggedUser->country_id);
                        });
                }
            ])
            ->where('user_id', 3)
            ->first();

        return $upr;
    }

    public function getPercentage()
    {
    }
}
