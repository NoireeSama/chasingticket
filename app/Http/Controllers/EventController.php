<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function allEvents(Request $request)
    {
        $categories = \App\Models\Category::all();

        $query = Event::with('category');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('type') && $request->type != '') {
            if ($request->type === 'upcoming') {
                $query->where('date', '>=', now());
            } elseif ($request->type === 'past') {
                $query->where('date', '<', now());
            } elseif ($request->type === 'free') {
                $query->where('price', 0);
            }
        }

        $query->orderByRaw('CASE WHEN date >= NOW() THEN 0 ELSE 1 END ASC');

        $sortBy = $request->get('sort_by', 'latest');
        if ($sortBy === 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($sortBy === 'price_high') {
            $query->orderBy('price', 'desc');
        } elseif ($sortBy === 'event_date') {
            $query->orderBy('date', 'asc');
        } elseif ($sortBy === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else { 
            $query->orderBy('created_at', 'desc');
        }

        $events = $query->paginate(12)->withQueryString();

        return view('events', compact('events', 'categories', 'sortBy'));
    }

    function show(Event $event){
        $event->load(['reviews.user', 'user']);
        $categories = \App\Models\Category::all();
        return view('event-detail', compact('event', 'categories'));
    }

    function checkout(){
        $categories = \App\Models\Category::all();
        return view('checkout', compact('categories'));
    }

    function ticket(){
        $categories = \App\Models\Category::all();
        $transaction = null;
        if (session()->has('transaction_id')) {
            $transaction = \App\Models\Transaction::with('event')->find(session('transaction_id'));
        }
        return view('ticket', compact('categories', 'transaction'));
    }

    function showTicket($order_id){
        $categories = \App\Models\Category::all();
        $transaction = \App\Models\Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        
        if (!auth()->check() || $transaction->customer_email !== auth()->user()->email) {
            abort(403, 'Akses ditolak. Tiket ini bukan milik Anda.');
        }
        
        return view('ticket', compact('categories', 'transaction'));
    }
}
