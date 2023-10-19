<?php

namespace App\Models;

use App\Http\Components\Traits\CalendarHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory, CalendarHelperTrait;

    public function scopeCreatedYesterday($query){
        return $query->whereDate('created_at', $this->getYesterday());
    }
}
