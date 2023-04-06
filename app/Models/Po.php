<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Po extends Model
{
    use HasFactory;

    public function poSubs(){
        return $this->hasMany(PSub::class, 'po_id', 'id');
    }
}
