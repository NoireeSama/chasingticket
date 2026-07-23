@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-16">
    
    <div class="mb-12 text-center max-w-3xl mx-auto">
        <span class="inline-block px-4 py-1.5 bg-[#b8ff00] text-[#103370] rounded-full text-xs font-black uppercase tracking-wider mb-3 shadow-sm">
            Katalog Lengkap
        </span>
        <h1 class="text-4xl md:text-5xl font-black text-[#103370] tracking-tight mb-4">Semua Event & Konser</h1>
        <p class="text-slate-500 font-medium text-base leading-relaxed">
            Jelajahi seluruh koleksi acara, konser musik, seminar IT, dan workshop terbaik. Temukan pengalaman tak terlupakan dan pesan tiketmu sekarang!
        </p>
    </div>

    <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[35px] p-6 md:p-8 mb-12">
        <form method="GET" action="{{ route('events.all') }}" class="space-y-4">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                
                <div class="md:col-span-5 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama event, lokasi, atau kata kunci..."
                        class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-2 border-[#f1f5f9] rounded-full text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#103370] transition">
                </div>

                <div class="md:col-span-3">
                    <select name="category" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-[#f1f5f9] rounded-full text-sm font-bold text-[#103370] focus:outline-none focus:ring-2 focus:ring-[#103370] cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <select name="type" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-[#f1f5f9] rounded-full text-sm font-bold text-[#103370] focus:outline-none focus:ring-2 focus:ring-[#103370] cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="upcoming" {{ request('type') === 'upcoming' ? 'selected' : '' }}>Event Mendatang</option>
                        <option value="past" {{ request('type') === 'past' ? 'selected' : '' }}>Event Selesai</option>
                        <option value="free" {{ request('type') === 'free' ? 'selected' : '' }}>Tiket Gratis</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <select name="sort_by" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-[#f1f5f9] rounded-full text-sm font-bold text-[#103370] focus:outline-none focus:ring-2 focus:ring-[#103370] cursor-pointer">
                        <option value="latest" {{ request('sort_by') === 'latest' || !request('sort_by') ? 'selected' : '' }}>Terbaru</option>
                        <option value="event_date" {{ request('sort_by') === 'event_date' ? 'selected' : '' }}>Event Terdekat</option>
                        <option value="price_low" {{ request('sort_by') === 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort_by') === 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="oldest" {{ request('sort_by') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                <p class="text-xs font-semibold text-slate-500">
                    Menampilkan <span class="font-bold text-[#103370]">{{ $events->total() }}</span> event ditemukan
                </p>
                
                <div class="flex items-center gap-3">
                    @if(request('search') || request('category') || request('type') || request('sort_by'))
                        <a href="{{ route('events.all') }}" class="px-5 py-2.5 bg-slate-200 text-slate-700 rounded-full text-xs font-bold hover:bg-slate-300 transition">
                            Reset Filter
                        </a>
                    @endif
                    <button type="submit" class="px-7 py-2.5 bg-[#F24781] text-white font-bold rounded-full text-xs shadow-[0_10px_20px_rgba(242,71,129,0.3)] hover:bg-[#103370] hover:shadow-[0_10px_20px_rgba(16,51,112,0.3)] transition">
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="events-grid-custom mb-12">
        @forelse ($events as $event)
            <a href="{{ url('event/' . $event->id) }}" style="text-decoration: none;">
                <div class="event-card-playful">
                    <div class="event-image-container">
                        <div class="event-category-badge">
                            {{ $event->category->name ?? 'Event' }}
                        </div>
                        
                        @php
                            $isPassed = $event->date->isPast();
                            $isOutOfStock = $event->stock <= 0;
                        @endphp

                        @if($event->poster_path)
                            <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}" style="{{ $isPassed || $isOutOfStock ? 'filter: grayscale(100%); opacity:0.8;' : '' }}">
                        @else
                            <img src="https://via.placeholder.com/400x500?text={{ urlencode($event->title) }}" alt="{{ $event->title }}" style="{{ $isPassed || $isOutOfStock ? 'filter: grayscale(100%); opacity:0.8;' : '' }}">
                        @endif

                        @if($isPassed)
                            <div class="event-empty-badge">
                                <span>Event Selesai</span>
                            </div>
                        @elseif($isOutOfStock)
                            <div class="event-empty-badge">
                                <span>Stok Habis</span>
                            </div>
                        @endif
                    </div>

                    <div class="event-info">
                        <h3>{{ $event->title }}</h3>
                        <div class="event-meta">
                            <svg class="w-5 h-5 text-[#F24781]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</span>
                        </div>
                    </div>

                    <div class="event-footer">
                        <span class="event-price">
                            @if($event->price == 0)
                                Gratis
                            @else
                                Rp {{ number_format($event->current_price, 0, ',', '.') }}
                            @endif
                        </span>
                        <div class="btn-buy">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            
            <div class="col-span-full bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[40px] p-12 md:p-16 text-center relative overflow-hidden my-6">
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-[#b8ff00]/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-10 -top-10 w-64 h-64 bg-[#F24781]/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="w-20 h-20 bg-[#103370] text-[#b8ff00] rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_15px_30px_rgba(16,51,112,0.25)]">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#103370] mb-2">Event Tidak Ditemukan</h3>
                    <p class="text-slate-500 max-w-md mx-auto text-sm font-medium mb-8">Tidak ada event yang cocok dengan kriteria pencarian atau filter yang Anda pilih. Coba sesuaikan kata kunci atau filter Anda!</p>
                    <a href="{{ route('events.all') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-[#F24781] text-white font-bold rounded-full shadow-[0_10px_25px_rgba(242,71,129,0.3)] hover:bg-[#103370] hover:shadow-[0_10px_25px_rgba(16,51,112,0.3)] transition-all">
                        <span>Reset Pencarian</span>
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $events->links() }}
    </div>
</main>
@endsection
