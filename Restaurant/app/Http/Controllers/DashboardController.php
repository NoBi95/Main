<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $startOfWeek = Carbon::now()->startOfWeek()->toDateTimeString();
        $startOfMonth = Carbon::now()->startOfMonth()->toDateTimeString();

        // Count distinct customers who placed orders this week
        $weeklyCustomers = DB::table('orders')
            ->where('order_time', '>=', $startOfWeek)
            ->distinct('customer_id')
            ->count('customer_id');

        // Count distinct customers who placed orders this month
        $monthlyCustomers = DB::table('orders')
            ->where('order_time', '>=', $startOfMonth)
            ->distinct('customer_id')
            ->count('customer_id');

        // Weekly orders grouped by day name
        $weeklyData = DB::table('orders')
            ->selectRaw('DAYNAME(order_time) as day, COUNT(*) as total')
            ->where('order_time', '>=', $startOfWeek)
            ->groupBy('day')
            ->pluck('total', 'day');

        // Monthly orders grouped by week number of the month
        $monthlyData = DB::table('orders')
            ->selectRaw("WEEK(order_time) - WEEK(DATE_SUB(order_time, INTERVAL DAYOFMONTH(order_time)-1 DAY)) + 1 as week, COUNT(*) as total")
            ->where('order_time', '>=', $startOfMonth)
            ->groupBy('week')
            ->pluck('total', 'week')
            ->mapWithKeys(fn ($val, $key) => ["Week $key" => $val]);

        // Weekly best sellers (top 3 menu items sold this week)
        $weeklyBestSellers = DB::table('orderitems')
            ->select('menuitems.name as name', DB::raw('SUM(orderitems.quantity) as total_sold'))
            ->join('orders', 'orderitems.order_id', '=', 'orders.order_id')
            ->join('menuitems', 'orderitems.item_id', '=', 'menuitems.item_id')
            ->where('orders.order_time', '>=', $startOfWeek)
            ->groupBy('menuitems.name')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();

        // Monthly best sellers (top 3 menu items sold this month)
        $monthlyBestSellers = DB::table('orderitems')
            ->select('menuitems.name as name', DB::raw('SUM(orderitems.quantity) as total_sold'))
            ->join('orders', 'orderitems.order_id', '=', 'orders.order_id')
            ->join('menuitems', 'orderitems.item_id', '=', 'menuitems.item_id')
            ->where('orders.order_time', '>=', $startOfMonth)
            ->groupBy('menuitems.name')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();

        return view('dashboard', [
            'weeklyCustomers' => $weeklyCustomers,
            'monthlyCustomers' => $monthlyCustomers,
            'weeklyData' => $weeklyData,
            'monthlyData' => $monthlyData,
            'weeklyBestSellers' => $weeklyBestSellers,
            'monthlyBestSellers' => $monthlyBestSellers
        ]);
    }
}
