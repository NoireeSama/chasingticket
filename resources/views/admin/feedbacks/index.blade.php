@extends('layouts.admin')
@section('title', 'Feedback & Ulasan - Admin')
@section('page_title', 'Feedback & Ulasan')
@section('page_subtitle', 'Pantau dan kelola ulasan serta rating dari pengunjung event.')

@section('content')
<div class="mb-6 flex flex-col md:flex-row gap-4 items-stretch md:items-center justify-between">
    <form method="GET" action="{{ route('admin.feedbacks.index') }}" class="flex flex-wrap md:flex-nowrap gap-3 items-center w-full flex-1">

        <input type="text" name="search" placeholder="Cari pembeli atau event..." value="{{ $search }}"
            class="flex-1 min-w-[200px] px-5 py-3 rounded-full border-2 border-[#f1f5f9] bg-white shadow-sm focus:ring-2 focus:ring-[#103370] focus:border-transparent outline-none transition font-medium text-sm">

        <select name="rating" onchange="this.form.submit()" class="px-5 py-3 rounded-full border-2 border-[#f1f5f9] bg-white text-slate-700 font-bold text-sm outline-none cursor-pointer shadow-sm">
            <option value="">Semua Rating</option>
            <option value="5" {{ $rating == '5' ? 'selected' : '' }}>5 Bintang</option>
            <option value="4" {{ $rating == '4' ? 'selected' : '' }}>4 Bintang</option>
            <option value="3" {{ $rating == '3' ? 'selected' : '' }}>3 Bintang</option>
            <option value="2" {{ $rating == '2' ? 'selected' : '' }}>2 Bintang</option>
            <option value="1" {{ $rating == '1' ? 'selected' : '' }}>1 Bintang</option>
        </select>

        <select name="sort_by" onchange="this.form.submit()" class="px-5 py-3 rounded-full border-2 border-[#f1f5f9] bg-white text-slate-700 font-bold text-sm outline-none cursor-pointer shadow-sm">
            <option value="latest" {{ $sortBy === 'latest' ? 'selected' : '' }}>Terbaru</option>
            <option value="oldest" {{ $sortBy === 'oldest' ? 'selected' : '' }}>Terlama</option>
            <option value="rating_desc" {{ $sortBy === 'rating_desc' ? 'selected' : '' }}>Rating Tertinggi</option>
            <option value="rating_asc" {{ $sortBy === 'rating_asc' ? 'selected' : '' }}>Rating Terendah</option>
        </select>

        <button type="submit" class="px-6 py-3 bg-[#103370] text-white rounded-full font-bold text-sm shadow-md hover:bg-[#F24781] transition">
            Cari
        </button>

        @if($search || $rating)
            <a href="{{ route('admin.feedbacks.index') }}" class="px-6 py-3 bg-slate-200 text-slate-700 rounded-full font-bold text-sm hover:bg-slate-300 transition">
                Reset
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-[35px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#103370] text-white uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Pembeli</th>
                    <th class="px-8 py-4">Rating</th>
                    <th class="px-8 py-4">Ulasan</th>
                    <th class="px-8 py-4 text-center w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($feedbacks as $index => $fb)
                <tr class="hover:bg-slate-50 transition">

                    <td class="px-8 py-6 font-bold text-slate-400">{{ $feedbacks->firstItem() + $index }}</td>

                    <td class="px-8 py-6">
                        @if($fb->event)
                            <p class="font-extrabold text-[#103370] text-base">{{ $fb->event->title }}</p>
                            <span class="inline-block mt-1 px-3 py-1 bg-[#b8ff00] text-[#103370] text-[10px] font-black rounded-full uppercase tracking-wider">
                                {{ $fb->event->category->name ?? '-' }}
                            </span>
                        @else
                            <p class="text-slate-400 italic text-sm">Event Terhapus</p>
                        @endif
                    </td>

                    <td class="px-8 py-6">
                        @if($fb->user)
                            <p class="font-bold text-slate-800 text-sm">{{ $fb->user->name }}</p>
                            <p class="text-xs text-slate-400 font-semibold">{{ '@' . $fb->user->username }}</p>
                        @else
                            <p class="text-slate-400 italic text-sm">User Terhapus</p>
                        @endif
                    </td>

                    <td class="px-8 py-6 whitespace-nowrap">
                        <div class="flex gap-0.5 text-amber-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fb->rating)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-slate-200 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-xs font-bold text-slate-500 mt-1 block">({{ $fb->rating }} / 5 Bintang)</span>
                    </td>

                    <td class="px-8 py-6 max-w-sm break-words">
                        @if($fb->review)
                            <p class="text-slate-700 text-sm font-medium leading-relaxed">{{ $fb->review }}</p>
                        @else
                            <p class="text-slate-400 italic text-xs">Hanya memberikan rating bintang.</p>
                        @endif
                        <span class="text-[10px] text-slate-400 font-semibold mt-1 block">{{ $fb->created_at->diffForHumans() }}</span>
                    </td>

                    <td class="px-8 py-6 text-center">
                        <form action="{{ route('admin.feedbacks.destroy', $fb->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini secara permanen?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-full hover:bg-rose-600 hover:text-white transition shadow-sm" title="Hapus Ulasan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-slate-400 font-medium">Belum ada data rating & ulasan yang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-100">
        {{ $feedbacks->links() }}
    </div>
</div>
@endsection
