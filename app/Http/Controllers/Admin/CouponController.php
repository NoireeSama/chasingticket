<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $query = Coupon::with('user');

        if (auth()->user()->role === 'merchant') {
            $query->where('user_id', auth()->id());
        }

        $coupons = $query->latest()->paginate(20);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code|max:50',
            'value' => 'required|integer|min:1|max:100',
            'expires_at' => 'nullable|date',
            'is_limited' => 'required|boolean',
            'limit_count' => $request->is_limited ? 'required|integer|min:1' : 'nullable|integer',
        ]);

        $coupon = new Coupon([
            'code' => strtoupper(trim($request->code)),
            'type' => 'percent',
            'value' => $request->value,
            'expires_at' => $request->expires_at,
            'is_limited' => $request->is_limited ? true : false,
            'limit_count' => $request->is_limited ? $request->limit_count : 0,
            'used_count' => 0,
        ]);
        $coupon->user_id = auth()->id();
        $coupon->save();

        return redirect()->route('admin.coupons.index')->with('success', 'Kupon berhasil ditambahkan.');
    }

    public function edit(Coupon $coupon)
    {
        if (auth()->user()->role === 'merchant' && $coupon->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        if (auth()->user()->role === 'merchant' && $coupon->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'value' => 'required|integer|min:1|max:100',
            'expires_at' => 'nullable|date',
            'is_limited' => 'required|boolean',
            'limit_count' => $request->is_limited ? 'required|integer|min:1' : 'nullable|integer',
        ]);

        $coupon->update([
            'code' => strtoupper(trim($request->code)),
            'value' => $request->value,
            'expires_at' => $request->expires_at,
            'is_limited' => $request->is_limited ? true : false,
            'limit_count' => $request->is_limited ? $request->limit_count : 0,
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Kupon berhasil diperbarui.');
    }

    public function destroy(Coupon $coupon)
    {
        if (auth()->user()->role === 'merchant' && $coupon->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Kupon berhasil dihapus.');
    }
}
