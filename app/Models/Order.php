<?php

namespace App\Models;

use App\Http\Components\Traits\CalendarHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory, CalendarHelperTrait;

    /**
     * relations
     */
    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    public function lastOrderDetails(){
        return $this->hasMany(OrderDetail::class)->latest();
    }

    /**
     * scope functions 
     */

    public function scopeOnce($query)
    {
        return $query->where('service_frequency', 'once');
    }

    public function scopeDaily($query)
    {
        return $query->where('service_frequency', 'daily');
    }

    public function scopeWeekly($query)
    {
        return $query->where('service_frequency', 'weekly');
    }

    public function scopeMonthly($query)
    {
        return $query->where('service_frequency', 'monthly');
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

    public function scopeInvoiceIsCreated($query){
        return $query->where('is_invoice_created', true);
    }

    public function scopeInvoiceIsNotCreated($query){
        return $query->where('is_invoice_created', false);
    }
    
    public function scopeInvoiceSmsSent($query){
        return $query->where('is_invoice_sms_sent', true);
    }

    public function scopeInvoiceSmsNotSent($query){
        return $query->where('is_invoice_sms_sent', false);
    }

    public function scopeTotalOrderDetailsOfCurrentMonth($query){
        return $query->withCount(['orderDetails' => function($orderDetails){
            $orderDetails->withinDateRange()->groupBy(DB::raw('DATE(created_at)'));
        }]);
    }
}
