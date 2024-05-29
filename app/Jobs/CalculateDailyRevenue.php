<?php

namespace App\Jobs;

use App\Models\CareOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CalculateDailyRevenue implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $yesterday = now()->subDay()->toDateString();
        $week = now()->subWeek()->toDateString();
        $month = now()->subMonth()->toDateString();

        if ($this->type === 'daily') {
            $revenue = CareOrder::whereDate('created_at', $yesterday)
                ->sum('order_total_price');

            DB::table('daily_revenues')->updateOrInsert(
                ['date' => $yesterday],
                ['revenue' => $revenue, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        if ($this->type === 'weekly') {
            $revenue = CareOrder::whereDate('created_at', '>=', $week)
                ->whereDate('created_at', '<=', $yesterday)
                ->sum('order_total_price');

            Cache::put('weekly_revenue', $revenue, now()->addWeek());
        }

        if ($this->type === 'monthly') {
            $revenue = CareOrder::whereDate('created_at', '>=', $month)
                ->whereDate('created_at', '<=', $yesterday)
                ->sum('order_total_price');

            Cache::put('monthly_revenue', $revenue, now()->addMonth());
        }
    }
}
