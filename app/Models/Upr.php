<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Upr extends Model
{
    use HasFactory;

    public static $badge_by_points = 1;
    public static $badge_by_accuracy = 2;
    public static $badge_by_streak = 3;

    public function upr(){
        return $this->hasMany(self::class, 'p_id', 'p_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
