@extends('layouts.admin')
@section('title', 'Tambah Kategori Baru - Admin')
@section('page_title', 'Tambah Kategori Baru')
@section('page_subtitle', 'Buat kategori event baru untuk mempermudah klasifikasi acara.')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#103370] transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span>Kembali ke Daftar Kategori</span>
    </a>
</div>

<div class="bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[35px] p-8 md:p-10 max-w-2xl relative overflow-hidden">
    <div class="absolute -right-12 -top-12 w-64 h-64 bg-[#b8ff00]/20 rounded-full blur-3xl pointer-events-none"></div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6 relative z-10">
        @csrf

        <div>
            <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800" placeholder="Contoh: Musik, Workshop, Seminar IT, Festival" required>
            <p class="text-xs text-slate-400 mt-2 font-medium">Slug kategori akan otomatis dibuat dari nama kategori ini.</p>
            @error('name') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 flex items-center justify-end gap-4 border-t border-slate-100">
            <a href="{{ route('admin.categories.index') }}" class="px-6 py-3.5 text-slate-500 font-bold hover:text-slate-800 transition text-sm">Batal</a>
            <button type="submit" class="px-8 py-4 bg-[#103370] text-white font-bold rounded-full text-sm shadow-[0_10px_25px_rgba(16,51,112,0.3)] hover:bg-[#F24781] hover:shadow-[0_10px_25px_rgba(242,71,129,0.35)] transition duration-300 transform active:scale-98">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection
