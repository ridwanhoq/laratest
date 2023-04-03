<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Upr extends Model
{
    use HasFactory;

    public function upr(){
        return $this->hasMany(self::class, 'p_id', 'p_id');
    }
}
