<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isGestionnaire()) {
            $totalOrders = Order::count();
            $totalSales = Order::where('status', 'paid')->sum('total_amount');
            $pendingOrders = Order::where('status', 'pending')->count();
            return view('dashboard.gestionnaire', compact('totalOrders', 'totalSales', 'pendingOrders'));
        } else {
            $orders = Order::where('user_id', auth()->id())->get();
            return view('dashboard.client', compact('orders'));
        }
    }
}
