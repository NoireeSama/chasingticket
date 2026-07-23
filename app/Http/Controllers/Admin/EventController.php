<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    public function index()
    {
        $search = request('search');
        $sortBy = request('sort_by', 'latest');

        $query = Event::with('category');

        if (Auth::user()->role === 'merchant') {
            $query->where('user_id', Auth::id());
        }

        if ($search) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        if ($sortBy === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $events = $query->paginate(10)->appends(request()->query());
        return view('admin.events.index', compact('events', 'search', 'sortBy'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $isDynamic = $request->boolean('is_dynamic_pricing');
        $rules = $request->input('dynamic_pricing_rules', []);

        $rules = array_values(array_filter($rules, function($r) {
            return !empty($r['date']) && isset($r['price']) && $r['price'] !== '';
        }));

        if ($isDynamic) {
            if (count($rules) > 5) {
                return back()->withInput()->withErrors(['dynamic_pricing_rules' => 'Maksimal 5 dynamic pricing yang diperbolehkan.']);
            }

            $eventDate = \Carbon\Carbon::parse($request->date);
            $basePrice = floatval($request->price);

            foreach ($rules as $rule) {
                $ruleDate = \Carbon\Carbon::parse($rule['date']);
                $rulePrice = floatval($rule['price']);

                if ($ruleDate->gt($eventDate)) {
                    return back()->withInput()->withErrors(['dynamic_pricing_rules' => 'Tanggal dynamic pricing tidak boleh melebihi tanggal event.']);
                }

                if ($rulePrice < $basePrice) {
                    return back()->withInput()->withErrors(['dynamic_pricing_rules' => 'Harga dynamic pricing tidak boleh kurang dari harga awal event.']);
                }
            }
        } else {
            $rules = [];
        }

        $data = [
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_dynamic_pricing' => $isDynamic,
            'dynamic_pricing_rules' => $rules,
            'user_id' => Auth::id()
        ];

        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $path = $file->store('events', 'public');
            $data['poster_path'] = $path;
        }

        $newEvent = \App\Models\Event::create($data);

        \App\Models\ActivityLog::log(auth()->user()->name . " (Role: " . auth()->user()->role . ") menambahkan event baru: " . $newEvent->title);

        return redirect()->route('admin.events.index')->with('success', 'Data Event berhasil ditambahkan.');
    }

    public function show(Event $event)
    {

    }

    public function edit(Event $event)
    {

        if (Auth::user()->role === 'merchant' && $event->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki akses ke event ini.');
        }

        $categories = \App\Models\Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        if (Auth::user()->role === 'merchant' && $event->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki akses ke event ini.');
        }

        $request->validate([
            'category_id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $isDynamic = $request->boolean('is_dynamic_pricing');
        $rules = $request->input('dynamic_pricing_rules', []);

        $rules = array_values(array_filter($rules, function($r) {
            return !empty($r['date']) && isset($r['price']) && $r['price'] !== '';
        }));

        if ($isDynamic) {
            if (count($rules) > 5) {
                return back()->withInput()->withErrors(['dynamic_pricing_rules' => 'Maksimal 5 dynamic pricing yang diperbolehkan.']);
            }

            $eventDate = \Carbon\Carbon::parse($request->date);
            $basePrice = floatval($request->price);

            foreach ($rules as $rule) {
                $ruleDate = \Carbon\Carbon::parse($rule['date']);
                $rulePrice = floatval($rule['price']);

                if ($ruleDate->gt($eventDate)) {
                    return back()->withInput()->withErrors(['dynamic_pricing_rules' => 'Tanggal dynamic pricing tidak boleh melebihi tanggal event.']);
                }

                if ($rulePrice < $basePrice) {
                    return back()->withInput()->withErrors(['dynamic_pricing_rules' => 'Harga dynamic pricing tidak boleh kurang dari harga awal event.']);
                }
            }
        } else {
            $rules = [];
        }

        $data = [
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_dynamic_pricing' => $isDynamic,
            'dynamic_pricing_rules' => $rules
        ];

        if ($request->hasFile('poster')) {
            if ($event->poster_path && Storage::disk('public')->exists($event->poster_path)) {
                Storage::disk('public')->delete($event->poster_path);
            }

            $file = $request->file('poster');
            $path = $file->store('events', 'public');
            $data['poster_path'] = $path;
        }

        $event->update($data);

        \App\Models\ActivityLog::log(auth()->user()->name . " (Role: " . auth()->user()->role . ") mengedit event: " . $event->title);

        return redirect()->route('admin.events.index')->with('success', 'Rincian data event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {

        if (Auth::user()->role === 'merchant' && $event->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki akses ke event ini.');
        }

        $title = $event->title;
        $event->delete();

        \App\Models\ActivityLog::log(auth()->user()->name . " (Role: " . auth()->user()->role . ") menghapus event secara permanen: " . $title);

        return redirect()->route('admin.events.index')->with('success', 'Data event berhasil dihapus secara permanen.');
    }
}
