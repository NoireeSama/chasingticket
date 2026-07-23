<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Event $event)
    {

        if (Auth::user()->role !== 'customer') {
            return back()->with('error', 'Hanya customer yang dapat memberikan rating dan ulasan.');
        }

        if (now()->lessThan($event->date->copy()->addDay())) {
            return back()->with('error', 'Ulasan hanya dapat diberikan mulai dari satu hari setelah acara selesai.');
        }

        $hasTicket = \App\Models\Transaction::where('event_id', $event->id)
            ->where('customer_email', Auth::user()->email)
            ->whereIn('status', ['success', 'settlement', 'Success', 'Settlement'])
            ->exists();

        if (!$hasTicket) {
            return back()->with('error', 'Anda harus membeli tiket event ini untuk dapat memberikan ulasan.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:280',
        ], [
            'rating.required' => 'Rating wajib dipilih.',
            'rating.integer' => 'Rating tidak valid.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'review.max' => 'Ulasan tidak boleh lebih dari 280 karakter.',
        ]);

        $existingReview = Review::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan rating dan ulasan untuk event ini.');
        }

        Review::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Ulasan dan rating Anda berhasil disimpan!');
    }
}
