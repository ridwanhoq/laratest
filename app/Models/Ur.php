<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ur extends Model
{
    use HasFactory;

    public function aws(){
        return $this->hasMany(Aw::class)->where;
    }
    
}
