<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UopqaPubResSub extends Model
{
    use HasFactory;

    public function upqaOptionCount(){
        return $this->belongsTo(UpqaOptionCount::class, 'pqa_option_id', 'pqa_option_id');
    }
}
