<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $yesterday = now()->subDay()->toDateString();
        $dailyRevenue = DB::table('daily_revenues')
            ->where('date', $yesterday)
            ->value('revenue');

        $weeklyRevenue = Cache::get('weekly_revenue', 0);

        $monthlyRevenue = Cache::get('monthly_revenue', 0);

        return view(
            'dashboard.index',
            [
                'dailyRevenue' => $dailyRevenue,
                'weeklyRevenue' => $weeklyRevenue,
                'monthlyRevenue' => $monthlyRevenue,
            ]
        );
    }
}
