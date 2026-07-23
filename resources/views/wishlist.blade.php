@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-16">
    <div class="mb-10 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="text-4xl font-black text-[#103370] tracking-tight mb-2">Wishlist Saya</h1>
            <p class="text-slate-500 font-medium">Daftar event yang Anda simpan untuk nanti.</p>
        </div>
    </div>

    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4 px-8 py-4 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] rounded-full">
        <div class="flex items-center gap-3 w-full md:w-auto">
            <span class="text-xs font-black text-[#103370] uppercase tracking-wider whitespace-nowrap">Kategori:</span>
            <select onchange="window.location.href=this.value" class="w-full md:w-auto px-5 py-2.5 rounded-full border-2 border-[#f1f5f9] bg-slate-50 font-bold text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#103370] cursor-pointer">
                <option value="{{ request()->fullUrlWithQuery(['category' => null]) }}" {{ !request('category') ? 'selected' : '' }}>Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto md:justify-end">
            <span class="text-xs font-black text-[#103370] uppercase tracking-wider whitespace-nowrap">Urutkan:</span>
            <select onchange="window.location.href=this.value" class="w-full md:w-auto px-5 py-2.5 rounded-full border-2 border-[#f1f5f9] bg-slate-50 font-bold text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#103370] cursor-pointer">
                <option value="{{ request()->fullUrlWithQuery(['sort_by' => 'latest']) }}" {{ request('sort_by') === 'latest' || !request('sort_by') ? 'selected' : '' }}>Terakhir Ditambahkan</option>
                <option value="{{ request()->fullUrlWithQuery(['sort_by' => 'event_date']) }}" {{ request('sort_by') === 'event_date' ? 'selected' : '' }}>Event Terdekat</option>
                <option value="{{ request()->fullUrlWithQuery(['sort_by' => 'price_low']) }}" {{ request('sort_by') === 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                <option value="{{ request()->fullUrlWithQuery(['sort_by' => 'price_high']) }}" {{ request('sort_by') === 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
            </select>
        </div>
    </div>

    <div class="mb-6 px-2">
        <p class="text-sm text-slate-500 font-medium">
            Menampilkan <span class="font-bold text-[#103370]">{{ $wishlists->count() }}</span> event di wishlist Anda
        </p>
    </div>

    <div id="wishlistGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($wishlists as $wishlist)
            @if($wishlist->event)
                <div id="wishlist-card-{{ $wishlist->event->id }}" class="group bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] rounded-[40px] hover:shadow-[0_20px_50px_rgba(242,71,129,0.15)] hover:border-[#F24781] transition-all duration-300 overflow-hidden relative flex flex-col">

                    <div class="relative overflow-hidden aspect-[4/5] bg-slate-100">

                        <button type="button" onclick="removeWishlist({{ $wishlist->event->id }}, 'wishlist-card-{{ $wishlist->event->id }}')" class="absolute top-4 left-4 w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-rose-500 shadow-md hover:bg-rose-500 hover:text-white hover:scale-110 transition duration-300 focus:outline-none z-20" title="Hapus dari Wishlist">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>

                        <div class="absolute top-4 right-4 px-3.5 py-1 bg-[#b8ff00] text-[#103370] rounded-full text-xs font-black uppercase tracking-wider z-10 shadow-sm">
                            {{ $wishlist->event->category->name ?? 'Event' }}
                        </div>

                        @php
                            $isPassed = $wishlist->event->date->isPast();
                            $isOutOfStock = $wishlist->event->stock <= 0;
                        @endphp

                        @if($wishlist->event->poster_path)
                            <img src="{{ asset('storage/' . $wishlist->event->poster_path) }}" alt="{{ $wishlist->event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 {{ $isPassed || $isOutOfStock ? 'grayscale opacity-75' : '' }}">
                        @else
                            <img src="https://via.placeholder.com/400x500?text={{ urlencode($wishlist->event->title) }}" alt="{{ $wishlist->event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 {{ $isPassed || $isOutOfStock ? 'grayscale opacity-75' : '' }}">
                        @endif

                        @if($isPassed)
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <span class="px-4 py-2 bg-rose-600 text-white rounded-full font-black text-xs uppercase tracking-wider shadow-md">
                                    Event Selesai
                                </span>
                            </div>
                        @elseif($isOutOfStock)
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                <span class="px-4 py-2 bg-[#103370] text-white rounded-full font-black text-xs uppercase tracking-wider shadow-md">
                                    Stok Habis
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-black text-[#103370] mb-2 group-hover:text-[#F24781] transition leading-snug">
                                {{ $wishlist->event->title }}
                            </h3>

                            <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold mb-4">
                                <svg class="w-4 h-4 text-[#F24781]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>
                                    {{ \Carbon\Carbon::parse($wishlist->event->date)->format('d-m-Y H:i') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-slate-100 mt-2">
                            <span class="text-2xl font-black text-[#103370]">
                                Rp {{ number_format($wishlist->event->price, 0, ',', '.') }}
                            </span>

                            <a href="{{ url('event/' . $wishlist->event->id) }}" class="px-5 py-2.5 bg-[#103370] text-white rounded-full font-bold text-xs hover:bg-[#F24781] transition shadow-md">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            
            <div class="col-span-full bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[40px] p-12 md:p-16 text-center relative overflow-hidden my-6">
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-[#b8ff00]/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-10 -top-10 w-64 h-64 bg-[#F24781]/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="w-20 h-20 bg-[#F24781] text-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_15px_30px_rgba(242,71,129,0.3)]">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#103370] mb-2">Wishlist Masih Kosong</h3>
                    <p class="text-slate-500 max-w-md mx-auto text-sm font-medium mb-8">Anda belum menyimpan event impian apa pun ke daftar wishlist Anda. Temukan event favoritmu dan simpan sekarang!</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-[#F24781] text-white font-bold rounded-full shadow-[0_10px_25px_rgba(242,71,129,0.3)] hover:bg-[#103370] hover:shadow-[0_10px_25px_rgba(16,51,112,0.3)] transition-all">
                        <span>Jelajahi Event</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</main>

<script>
    function removeWishlist(eventId, cardId) {
        if (!confirm('Apakah Anda yakin ingin menghapus event ini dari wishlist Anda?')) {
            return;
        }

        const url = `/wishlist/toggle/${eventId}`;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (response.status === 401) {
                window.location.href = "{{ route('login') }}?redirect=" + encodeURIComponent(window.location.href);
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data && data.success && !data.isWishlisted) {
                const card = document.getElementById(cardId);
                if (card) {
                    card.style.transition = 'all 0.4s ease-out';
                    card.style.transform = 'scale(0.9)';
                    card.style.opacity = '0';
                    setTimeout(() => {
                        card.remove();
                        const grid = document.getElementById('wishlistGrid');
                        if (grid && grid.querySelectorAll('[id^="wishlist-card-"]').length === 0) {
                            location.reload();
                        }
                    }, 400);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menghapus wishlist.');
        });
    }
</script>
@endsection
