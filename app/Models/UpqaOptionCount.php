<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UpqaOptionCount extends Model
{
    use HasFactory;

    public function upqaCount(){
        return $this->belongsTo(self::class, 'pq_id', 'pq_id');
    }
}
