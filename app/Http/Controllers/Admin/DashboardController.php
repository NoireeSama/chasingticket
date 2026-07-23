<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index()
    {
        $role = auth()->user()->role;
        $userId = auth()->id();

        $chartMonths = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthKey = now()->subMonths($i)->format('Y-m');
            $chartMonths[$monthKey] = [
                'label' => now()->subMonths($i)->format('M Y'),
                'customers' => 0,
                'merchants' => 0,
                'events' => 0,
                'tickets' => 0,
                'revenue' => 0,
            ];
        }

        if ($role === 'merchant') {

            $totalRevenue = Transaction::whereIn('status', ['success', 'settlement'])
                ->whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->sum('total_price');

            $ticketsSold = Transaction::whereIn('status', ['success', 'settlement'])
                ->whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->count();

            $activeEvents = Event::where('user_id', $userId)
                ->where('date', '>=', now())
                ->count();

            $pendingOrders = Transaction::where('status', 'pending')
                ->whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->count();

            $recentTransactions = Transaction::with('event')
                ->whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->latest()->take(5)->get();

            $eventsData = Event::where('user_id', $userId)
                ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
                ->get();
            foreach ($eventsData as $event) {
                $monthKey = $event->created_at->format('Y-m');
                if (isset($chartMonths[$monthKey])) {
                    $chartMonths[$monthKey]['events']++;
                }
            }

            $transactionsData = Transaction::whereIn('status', ['success', 'settlement'])
                ->whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
                ->get();
            foreach ($transactionsData as $trx) {
                $monthKey = $trx->created_at->format('Y-m');
                if (isset($chartMonths[$monthKey])) {
                    $chartMonths[$monthKey]['tickets'] += $trx->quantity;
                    $chartMonths[$monthKey]['revenue'] += $trx->total_price;
                }
            }

        } else {

            $totalRevenue = Transaction::whereIn('status', ['success', 'settlement'])->sum('total_price');
            $ticketsSold = Transaction::whereIn('status', ['success', 'settlement'])->count();
            $activeEvents = Event::where('date', '>=', now())->count();
            $pendingOrders = Transaction::where('status', 'pending')->count();
            $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

            $usersData = User::whereIn('role', ['customer', 'merchant'])
                ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
                ->get();
            foreach ($usersData as $user) {
                $monthKey = $user->created_at->format('Y-m');
                if (isset($chartMonths[$monthKey])) {
                    if ($user->role === 'customer') {
                        $chartMonths[$monthKey]['customers']++;
                    } elseif ($user->role === 'merchant') {
                        $chartMonths[$monthKey]['merchants']++;
                    }
                }
            }

            $eventsData = Event::where('created_at', '>=', now()->subMonths(5)->startOfMonth())
                ->get();
            foreach ($eventsData as $event) {
                $monthKey = $event->created_at->format('Y-m');
                if (isset($chartMonths[$monthKey])) {
                    $chartMonths[$monthKey]['events']++;
                }
            }
        }

        $activeCustomers = User::where('role', 'customer')->count();
        $activeMerchants = User::where('role', 'merchant')->count();
        $activityLogs = ActivityLog::with('user')->latest()->take(10)->get();

        $chartLabels = array_values(array_column($chartMonths, 'label'));
        $chartCustomers = array_values(array_column($chartMonths, 'customers'));
        $chartMerchants = array_values(array_column($chartMonths, 'merchants'));
        $chartEvents = array_values(array_column($chartMonths, 'events'));
        $chartTickets = array_values(array_column($chartMonths, 'tickets'));
        $chartRevenue = array_values(array_column($chartMonths, 'revenue'));

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions',
            'activeCustomers',
            'activeMerchants',
            'activityLogs',
            'role',
            'chartLabels',
            'chartCustomers',
            'chartMerchants',
            'chartEvents',
            'chartTickets',
            'chartRevenue'
        ));
    }

    function indexEvent(){
        return view('admin.events');
    }

    function indexTransaction(){
        return view('admin.transactions');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {

        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        if ($request->hasFile('avatar')) {

            if ($user->avatar_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar_path);
            }

            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');
            $data['avatar_path'] = $path;
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        \App\Models\ActivityLog::log(auth()->user()->name . " memperbarui profil.");

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
