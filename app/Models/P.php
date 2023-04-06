<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class P extends Model
{
    use HasFactory;

    protected $table = "p_s";

    public function pSubs(){
        return $this->hasMany(PSub::class, 'id', 'p_id');
    }
}
