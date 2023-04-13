<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aw extends Model
{
    use HasFactory;

    public static $typeIdForPoints = 1;
    public static $typeIdForAccuracy = 1;
    public static $typeIdForStreak = 1;
}
