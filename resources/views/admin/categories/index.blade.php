@extends('layouts.admin')
@section('title', 'Kelola Kategori - Admin')
@section('page_title', 'Kelola Kategori')
@section('page_subtitle', 'Atur kategori event di sini.')

@section('content')
<div class="mb-6 flex flex-col md:flex-row gap-4 items-stretch md:items-center justify-between">
    <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-wrap md:flex-nowrap gap-3 items-center w-full md:w-auto flex-1">
        <input type="text" name="search" placeholder="Cari nama kategori..." value="{{ $search }}"
            class="flex-1 min-w-[200px] px-5 py-3 rounded-full border-2 border-[#f1f5f9] bg-white shadow-sm focus:ring-2 focus:ring-[#103370] focus:border-transparent outline-none transition font-medium text-sm">
        
        <select name="sort_by" onchange="this.form.submit()" class="px-5 py-3 rounded-full border-2 border-[#f1f5f9] bg-white text-slate-700 font-bold text-sm outline-none cursor-pointer shadow-sm">
            <option value="latest" {{ $sortBy === 'latest' ? 'selected' : '' }}>Terbaru</option>
            <option value="oldest" {{ $sortBy === 'oldest' ? 'selected' : '' }}>Terlama</option>
        </select>
        
        <button type="submit" class="px-6 py-3 bg-[#103370] text-white rounded-full font-bold text-sm shadow-md hover:bg-[#F24781] transition">
            Cari
        </button>
        @if($search)
            <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-slate-200 text-slate-700 rounded-full font-bold text-sm hover:bg-slate-300 transition">
                Reset
            </a>
        @endif
    </form>

    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#103370] text-white font-bold rounded-full shadow-[0_10px_20px_rgba(16,51,112,0.25)] hover:bg-[#F24781] hover:shadow-[0_10px_20px_rgba(242,71,129,0.35)] transition text-sm whitespace-nowrap self-stretch md:self-auto justify-center">
        <span>+ Tambah Kategori Baru</span>
    </a>
</div>

<div class="bg-white rounded-[35px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#103370] text-white uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Nama Kategori</th>
                    <th class="px-8 py-4">Slug</th>
                    <th class="px-8 py-4">Dibuat Pada</th>
                    <th class="px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($categories as $index => $category)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $categories->firstItem() + $index }}</td>
                    <td class="px-8 py-6">
                        <p class="font-extrabold text-[#103370] text-base">{{ $category->name }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <span class="inline-block px-3 py-1 bg-slate-100 text-slate-600 text-xs font-mono font-bold rounded-full">
                            {{ $category->slug }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-xs text-slate-500 font-medium">{{ $category->created_at->format('d M Y, H:i') }}</p>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-2.5 bg-[#103370]/10 text-[#103370] rounded-full hover:bg-[#103370] hover:text-white transition shadow-sm" title="Edit Kategori">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>

                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-full hover:bg-rose-600 hover:text-white transition shadow-sm" title="Hapus Kategori">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-10 text-center text-slate-400 font-medium">Belum ada kategori yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-100">
        {{ $categories->links() }}
    </div>
</div>
@endsection
