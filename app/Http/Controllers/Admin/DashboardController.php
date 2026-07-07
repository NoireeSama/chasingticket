<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index()
    {
        $totalRevenue = Transaction::whereIn('status', ['success', 'settlement'])->sum('total_price');
        $ticketsSold = Transaction::whereIn('status', ['success', 'settlement'])->count();
        $activeEvents = Event::where('date', '>=', now())->count();
        $pendingOrders = Transaction::where('status', 'pending')->count();
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions'
        ));
    }

    function indexEvent(){
        return view('admin.events');
    }

    function indexTransaction(){
        return view('admin.transactions');
    }
}
