<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PoSub extends Model
{
    use HasFactory;

    public function poSubs()
    {
        return $this->hasMany(self::class, 'user_id', 'user_id');
    }

    public function poSubsPoints()
    {
        return $this->hasMany(self::class, 'user_id', 'user_id');
    }
    public function poSubsAccuracy()
    {
        return $this->hasMany(self::class, 'user_id', 'user_id');
    }
    public function poSubsStreak()
    {
        return $this->hasMany(self::class, 'user_id', 'user_id');
    }

    // public function scopePoSubPoints($query, $minPoints)
    // {
    //     return $query->orWhere(function ($q) use ($minPoints, $query) {
    //         $q->selectRaw('user_id, sum(points) as sumPoints, sum(accuracy) as sumAccuracy, sum(streak) as sumStreak')
    //             ->groupBy('user_id')
    //             ->having('sumPoints', '>', $minPoints);
    //     }) ?? $query;
    // }

    // public function scopePoSubAccuracy($query, $minAccuracy)
    // {
    //     return $query->orWhere(function ($q) use ($minAccuracy, $query) {
    //         $q->selectRaw('user_id, sum(accuracy) as sumAccuracy')
    //             ->groupBy('user_id')
    //             ->having('sumAccuracy', '>', $minAccuracy);
    //     }) ?? $query;
    // }

    // public function scopePoSubStreak($query, $minStreak)
    // {
    //     return $query->orWhere(function ($q) use ($minStreak, $query) {
    //         $q->selectRaw('user_id, sum(streak) as sumStreak')
    //             ->groupBy('user_id')
    //             ->having('sumStreak', '>', $minStreak);
    //     }) ?? $query;
    // }
}
