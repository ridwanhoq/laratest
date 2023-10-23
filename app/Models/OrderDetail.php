<?php

namespace App\Models;

use App\Http\Components\Traits\CalendarHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory, CalendarHelperTrait;

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function scopeCreatedYesterday($query){
        return $query->whereDate('created_at', $this->getYesterday());
    }
}
