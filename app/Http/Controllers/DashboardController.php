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

    public function showPetServiceUsage()
    {
        $serviceUsageData = DB::table('care_order_detail')
            ->join(
                'pet_services',
                'care_order_detail.pet_service_id',
                '=',
                'pet_services.pet_service_id'
            )
            ->select(DB::raw('pet_services.pet_service_name, COUNT(care_order_detail.pet_service_id) as usage_count'))
            ->groupBy('pet_services.pet_service_name')
            ->orderBy('usage_count', 'desc')
            ->get();

        return response()->json($serviceUsageData);
    }

    public function showMonthlyRevenue()
    {
        $monthlyRevenueData = DB::table('care_orders')
            ->select(
                DB::raw('DATE_FORMAT(order_received_date, "%Y-%m") as month'),
                DB::raw('SUM(order_total_price) as total_revenue')
            )
            ->groupBy(DB::raw('DATE_FORMAT(order_received_date, "%Y-%m")'))
            ->orderBy(
                DB::raw('DATE_FORMAT(order_received_date, "%Y-%m")'),
                'desc'
            )
            ->limit(12)
            ->get()
            ->reverse()
            ->values();

        return response()->json($monthlyRevenueData);
    }
}
