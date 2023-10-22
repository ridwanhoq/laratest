<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{

    protected $guarded = ['id'];

    public function scopeWithinDateRange($query, $dateRange = null)
    {
        $fieldName = $this->useDefault($dateRange, 'date_field') ? 'created_at' : $dateRange['date_field'];

        $fromDate = $this->useDefault($dateRange, 'from_date') ? Carbon::now()->firstOfMonth()->toDateTimeString() : $dateRange['from_date'] . ' 00:00:00';
        $toDate = $this->useDefault($dateRange, 'to_date') ? Carbon::now()->endOfMonth()->toDateTimeString() : $dateRange['to_date'] . ' 23:59:59';

        return $query
            ->where($fieldName, '>=', $fromDate)
            ->where($fieldName, '<=', $toDate);
    }

    /**
     * private functions
     *
     */
    private function useDefault($dateRange, $fieldName)
    {
        return $dateRange == null || array_key_exists($fieldName, $dateRange);
    }
}
