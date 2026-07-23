<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function toggleWishlist(Event $event)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (Auth::user()->role !== 'customer') {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        if ($event->stock <= 0) {
            return response()->json(['error' => 'Wishlist tidak tersedia karena stok habis.'], 400);
        }

        $wishlist = Wishlist::where('user_id', Auth::id())
                            ->where('event_id', $event->id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json([
                'success' => true,
                'isWishlisted' => false,
                'message' => 'Event dihapus dari wishlist.'
            ]);
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'event_id' => $event->id
            ]);
            return response()->json([
                'success' => true,
                'isWishlisted' => true,
                'message' => 'Event ditambahkan ke wishlist.'
            ]);
        }
    }

    public function addToCart(Event $event)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (Auth::user()->role !== 'customer') {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        if ($event->stock <= 0) {
            return response()->json(['error' => 'Stok tiket sudah habis.'], 400);
        }

        $cart = Cart::where('user_id', Auth::id())
                    ->where('event_id', $event->id)
                    ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'event_id' => $event->id,
                'quantity' => 1
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil ditambahkan ke keranjang.'
        ]);
    }

    public function wishlist(Request $request)
    {
        $categories = \App\Models\Category::all();
        $query = Wishlist::with('event.category')->where('user_id', Auth::id());

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('event.category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $sortBy = $request->input('sort_by', 'latest');
        if ($sortBy === 'event_date') {
            $query->select('wishlists.*')
                  ->join('events', 'wishlists.event_id', '=', 'events.id')
                  ->orderBy('events.date', 'asc');
        } elseif ($sortBy === 'price_low') {
            $query->select('wishlists.*')
                  ->join('events', 'wishlists.event_id', '=', 'events.id')
                  ->orderBy('events.price', 'asc');
        } elseif ($sortBy === 'price_high') {
            $query->select('wishlists.*')
                  ->join('events', 'wishlists.event_id', '=', 'events.id')
                  ->orderBy('events.price', 'desc');
        } else {
            $query->latest('wishlists.created_at');
        }

        $wishlists = $query->get();
        return view('wishlist', compact('wishlists', 'categories'));
    }

    public function cart()
    {
        $categories = \App\Models\Category::all();
        $cartItems = Cart::with('event.category')
                         ->where('user_id', Auth::id())
                         ->latest()
                         ->get();

        $pendingTransactions = \App\Models\Transaction::where('customer_email', Auth::user()->email)
                                                     ->where('status', 'pending')
                                                     ->get()
                                                     ->keyBy('event_id');

        return view('cart', compact('cartItems', 'categories', 'pendingTransactions'));
    }

    public function removeFromCart(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $cart->delete();
        return back()->with('success', 'Event berhasil dihapus dari keranjang.');
    }

    public function removeByEvent(Event $event)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $cart = Cart::where('user_id', Auth::id())
                    ->where('event_id', $event->id)
                    ->first();

        if ($cart) {
            $cart->delete();
            return response()->json([
                'success' => true,
                'message' => 'Event berhasil dihapus dari keranjang.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Event tidak ditemukan di keranjang.'
        ]);
    }

    public function settings()
    {
        $categories = \App\Models\Category::all();
        $user = Auth::user();
        return view('settings', compact('user', 'categories'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $isGoogleUser = !empty($user->google_id);

        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if (!$isGoogleUser) {
            $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $user->id;
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'description' => $request->description,
        ];

        if (!$isGoogleUser) {
            $data['email'] = $request->email;
            
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar_path);
            }

            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');
            $data['avatar_path'] = $path;
        }

        $user->update($data);

        \App\Models\ActivityLog::log(auth()->user()->name . " memperbarui profil pengaturan akun.");

        return redirect()->route('settings')->with('success', 'Pengaturan akun Anda berhasil diperbarui.');
    }

    public function history()
    {
        $categories = \App\Models\Category::all();
        $transactions = \App\Models\Transaction::with('event.category')
            ->where('customer_email', Auth::user()->email)
            ->latest()
            ->get();
            
        return view('history', compact('transactions', 'categories'));
    }
}
