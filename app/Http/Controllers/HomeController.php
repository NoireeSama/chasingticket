<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $categories = Category::all();

        $partners = Partner::all();

        $query = Event::with('category')
                      ->where('date', '>=', now())
                      ->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END ASC')
                      ->orderBy('date', 'asc');

        if ($request->has('category') && $request->category != '') {

            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $events = $query->get();

        return view('welcome', compact('events', 'categories', 'partners'));
    }

    public function organizerProfile(User $user)
    {
        if ($user->role !== 'merchant' && $user->role !== 'admin') {
            abort(404, 'Penyelenggara tidak ditemukan.');
        }

        $categories = Category::all();
        
        $upcomingEvents = $user->events()
            ->with('category')
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->get();
            
        $pastEvents = $user->events()
            ->with('category')
            ->where('date', '<', now())
            ->orderBy('date', 'desc')
            ->get();
            
        $user->load(['merchantReviews.user', 'merchantReviews.event']);
        
        return view('organizer-profile', compact('user', 'upcomingEvents', 'pastEvents', 'categories'));
    }

    public function about()
    {
        $categories = Category::all();
        return view('about', compact('categories'));
    }
}

