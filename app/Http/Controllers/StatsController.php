<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:gestionnaire');
    }

    public function index()
    {
        $today = Carbon::today();

        $ordersToday = Order::whereDate('created_at', $today)->count();
        $completedOrdersToday = Order::whereDate('created_at', $today)
            ->where('status', 'Payée')
            ->count();
        $revenueToday = Payment::whereDate('payment_date', $today)
            ->sum('amount');

        $ordersPerMonth = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $today->year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $booksSoldByCategory = Order::join('book_order', 'orders.id', '=', 'book_order.order_id')
            ->join('books', 'book_order.book_id', '=', 'books.id')
            ->selectRaw('books.category, COUNT(*) as count')
            ->whereYear('orders.created_at', $today->year)
            ->groupBy('books.category')
            ->pluck('count', 'books.category')
            ->toArray();

        return view('stats.index', compact(
            'ordersToday',
            'completedOrdersToday',
            'revenueToday',
            'ordersPerMonth',
            'booksSoldByCategory'
        ));
    }
}
