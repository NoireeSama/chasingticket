<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{

    public function index()
    {
        $search = request('search');
        $rating = request('rating');
        $sortBy = request('sort_by', 'latest');
        $eventId = request('event_id');

        $query = Review::with(['user', 'event']);

        if (Auth::user()->role === 'merchant') {
            $query->whereHas('event', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }

        if ($eventId) {
            $query->where('event_id', $eventId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'LIKE', '%' . $search . '%');
                })->orWhereHas('event', function ($eq) use ($search) {
                    $eq->where('title', 'LIKE', '%' . $search . '%');
                });
            });
        }

        if ($rating) {
            $query->where('rating', $rating);
        }

        if ($sortBy === 'oldest') {
            $query->oldest();
        } elseif ($sortBy === 'rating_desc') {
            $query->orderBy('rating', 'desc');
        } elseif ($sortBy === 'rating_asc') {
            $query->orderBy('rating', 'asc');
        } else {
            $query->latest();
        }

        $feedbacks = $query->paginate(10)->appends(request()->query());

        return view('admin.feedbacks.index', compact('feedbacks', 'search', 'rating', 'sortBy', 'eventId'));
    }

    public function destroy(Review $feedback)
    {

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('admin.feedbacks.index')->with('error', 'Akses ditolak. Hanya admin utama yang dapat menghapus ulasan.');
        }

        $feedback->delete();
        return redirect()->route('admin.feedbacks.index')->with('success', 'Ulasan/feedback berhasil dihapus secara permanen.');
    }
}
