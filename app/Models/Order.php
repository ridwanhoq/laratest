<?php

namespace App\Models;

use App\Http\Components\Traits\CalendarHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, CalendarHelperTrait;

    /**
     * scope functions 
     */
    public function scopeRunning($query)
    {
        return $query->whereNotNull('expired_at')
            ->where('expired_at', '<', $this->getToday());
    }
}
