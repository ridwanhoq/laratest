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

    public function scopeOnce($query)
    {
        return $query->where('order_frequency', 'once');
    }

    public function scopeDaily($query)
    {
        return $query->where('order_frequency', 'daily');
    }

    public function scopeRunning($query)
    {
        return $query
            ->whereNotNull('started_at')
            ->where('started_at', '<=', $this->getCurrentTime())
            ->whereNotNull('expired_at')
            ->where('expired_at', '>=', $this->getCurrentTime());
    }

    public function scopeNeedToCreateOrderDetails($query)
    {
        return $query
            ->daily()
            ->running();
    }
}
