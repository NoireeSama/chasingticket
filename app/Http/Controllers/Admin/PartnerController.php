<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $search = request('search');
        $sortBy = request('sort_by', 'latest');

        $query = Partner::query();

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        if ($sortBy === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $partners = $query->paginate(10)->appends(request()->query());
        return view('admin.partners.index', compact('partners', 'search', 'sortBy'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'url_Logo' => 'nullable|string',
        ]);

        if (!$request->hasFile('logo_file') && empty($request->url_Logo)) {
            return back()->withErrors(['logo_file' => 'Unggah berkas logo atau masukkan URL logo partner.'])->withInput();
        }

        $urlLogo = $request->url_Logo;

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('partners', 'public');
            $urlLogo = asset('storage/' . $path);
        }

        Partner::create([
            'name' => $request->name,
            'url_Logo' => $urlLogo,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'url_Logo' => 'nullable|string',
        ]);

        $urlLogo = $partner->url_Logo;

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('partners', 'public');
            $urlLogo = asset('storage/' . $path);
        } elseif ($request->filled('url_Logo')) {
            $urlLogo = $request->url_Logo;
        }

        $partner->update([
            'name' => $request->name,
            'url_Logo' => $urlLogo,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus secara permanen.');
    }
}
