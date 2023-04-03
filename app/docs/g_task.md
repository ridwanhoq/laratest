>> upqa_option_counts --> percentage from total counts
>> 

$counts = DB::table('my_table')
            ->select('my_field', DB::raw('COUNT(*) as total'))
            ->groupBy('my_field')
            ->get();

$totals = $counts->sum('total');

$percentageCounts = $counts->map(function ($count) use ($totals) {
    $count->percentage = round(($count->total / $totals) * 100, 2);
    return $count;
});


