<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch sales grouped by month for the last 12 months
        $salesData = Sale::selectRaw('SUM(amount) as total, MONTH(sale_date) as month, YEAR(sale_date) as year')
            ->whereRaw('YEAR(sale_date) = YEAR(NOW()) OR YEAR(sale_date) = YEAR(NOW()) - 1')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Create month labels
        $labels = $salesData->map(function ($item) {
            $date = Carbon::createFromDate($item->year, $item->month, 1);
            return $date->format('M Y');
        });

        $data = $salesData->pluck('total');

        // Calculate total sales and average
        $totalSales = $data->sum();
        $avgSales = $data->count() > 0 ? $data->avg() : 0;
        $maxSales = $data->count() > 0 ? $data->max() : 0;

        // Category distribution (simulated)
        $categories = ['Electronics', 'Fashion', 'Home & Garden', 'Sports', 'Books'];
        $categoryData = [45000, 32000, 28000, 18000, 15000];

        return view('dashboard', compact('labels', 'data', 'totalSales', 'avgSales', 'maxSales', 'categories', 'categoryData'));
    }
}
