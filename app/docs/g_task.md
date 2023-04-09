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


>> awards calculation cron based on given condition --
    >> run cron on each sunday of week (if days = 7)
    >> run cron on each first day of month (if days = 30)
>> 