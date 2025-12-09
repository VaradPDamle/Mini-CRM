<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB; // Used for SUM calculation
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 1. Total Customers (Count)
        $totalCustomers = Customer::count();

        // 2. Total Orders (Count)
        $totalOrders = Order::count();

        // 3. Total Revenue (Sum of 'amount' from completed orders)
        $totalRevenue = Order::where('status', 'Completed')->sum('amount');
        
        // 4. Recent 5 Customers
        $recentCustomers = Customer::latest()->take(5)->get();

        // Format revenue for display
        $formattedRevenue = number_format($totalRevenue, 2);

        // Pass all metrics to the view
        return view('dashboard', compact(
            'totalCustomers', 
            'totalOrders', 
            'formattedRevenue', 
            'recentCustomers'
        ));
    }
}