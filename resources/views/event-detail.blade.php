@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">

        <div class="lg:col-span-1">
            <div class="sticky top-32">
                @if(isset($event) && $event->poster_path)
                    <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title ?? 'Event Poster' }}"
                        class="w-full aspect-[4/5] object-cover rounded-[40px] shadow-[0_20px_40px_rgba(16,51,112,0.2)] border-8 border-white transform -rotate-2 hover:rotate-0 transition-transform duration-300 {{ $event->stock <= 0 ? 'grayscale opacity-75' : '' }}">
                @else
                    <img src="{{url('assets/concert.png')}}" alt="Concert Poster"
                        class="w-full aspect-[4/5] object-cover rounded-[40px] shadow-[0_20px_40px_rgba(16,51,112,0.2)] border-8 border-white transform -rotate-2 hover:rotate-0 transition-transform duration-300 {{ $event->stock <= 0 ? 'grayscale opacity-75' : '' }}">
                @endif
                <div class="mt-8 p-6 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] rounded-[40px] border border-slate-100 shadow-sm">
                    <h4 class="font-bold mb-4">Penyelenggara</h4>
                    <div class="flex items-center gap-4">
                        @if($event->user)
                            <a href="{{ route('organizer.profile', $event->user) }}" class="block shrink-0">
                                @if($event->user->avatar_path)
                                    <img src="{{ asset('storage/' . $event->user->avatar_path) }}" alt="{{ $event->user->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-slate-100 shadow-sm">
                                @else
                                    <div class="w-12 h-12 bg-[#103370]/10 rounded-full flex items-center justify-center text-[#103370] font-bold">
                                        {{ strtoupper(substr($event->user->name, 0, 2)) }}
                                    </div>
                                @endif
                            </a>
                        @else
                            <div class="w-12 h-12 bg-[#103370]/10 rounded-full flex items-center justify-center text-[#103370] font-bold shrink-0">
                                AD
                            </div>
                        @endif
                        <div>
                            <p class="font-bold text-slate-800">
                                @if($event->user)
                                    <a href="{{ route('organizer.profile', $event->user) }}" class="hover:text-[#103370] transition">{{ $event->user->name }}</a>
                                @else
                                    Penyelenggara Utama
                                @endif
                            </p>
                            <p class="text-xs text-slate-500 flex items-center gap-1 mt-0.5 font-medium">
                                @if($event->user)
                                    <span class="text-amber-400 font-bold">★</span> 
                                    <span class="font-bold text-slate-700">{{ $event->user->merchant_rating }}</span> 
                                    <span class="text-slate-400">({{ $event->user->merchant_reviews_count }} ulasan)</span>
                                @else
                                    Official Organizer
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-12">
            <div class="space-y-4">
                <span
                    class="px-4 py-1.5 bg-[#103370]/10 text-[#103370] rounded-full text-sm font-bold uppercase tracking-wider">{{ $event->category->name ?? 'Event' }}</span>
                <div class="flex items-center gap-4 flex-wrap">
                    <h1 class="text-4xl md:text-5xl font-black leading-tight">{{ $event->title }}</h1>

                    @if($event->stock <= 0)
                        <button type="button" class="p-2 cursor-not-allowed opacity-50" title="Stok Habis" disabled>
                            <svg class="w-8 h-8 text-slate-400 fill-none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    @else
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <button type="button" onclick="alert('kamu adalah admin')" class="p-2 hover:scale-110 transition-transform focus:outline-none" title="Tambah ke Wishlist">
                                    <svg class="w-8 h-8 text-rose-500 fill-none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            @elseif(Auth::user()->role === 'merchant')
                                <button type="button" onclick="alert('kamu adalah merchant')" class="p-2 hover:scale-110 transition-transform focus:outline-none" title="Tambah ke Wishlist">
                                    <svg class="w-8 h-8 text-rose-500 fill-none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            @else
                                @php
                                    $isWishlisted = \App\Models\Wishlist::where('user_id', Auth::id())->where('event_id', $event->id)->exists();
                                @endphp
                                <button type="button" onclick="toggleWishlist()" id="wishlistBtn" class="p-2 hover:scale-110 transition-transform focus:outline-none" title="Tambah ke Wishlist">
                                    <svg id="wishlistHeart" class="w-8 h-8 text-rose-500 transition-all duration-300 {{ $isWishlisted ? 'fill-rose-500' : 'fill-none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="p-2 hover:scale-110 transition-transform focus:outline-none" title="Tambah ke Wishlist">
                                <svg class="w-8 h-8 text-rose-500 fill-none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </a>
                        @endauth
                    @endif
                </div>
                <div class="flex flex-wrap gap-6 text-slate-500 font-medium">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#103370]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>{{ $event->date->format('l, d M Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#103370]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $event->location }}</span>
                    </div>
                </div>
            </div>

            <div class="prose prose-slate max-w-none">
                <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>
                <p class="text-lg text-slate-600 leading-relaxed">
                    {{ $event->description }}
                </p>
            </div>

            @if(now()->lessThan($event->date))
            <div
                class="bg-[#103370] rounded-[40px] p-8 md:p-12 text-white shadow-2xl shadow-[0_15px_35px_rgba(16,51,112,0.3)]/20 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        <p class="text-[#b8ff00] font-bold uppercase tracking-widest text-sm mb-2">Harga Tiket</p>
                        @if($event->price == 0)
                            <h2 class="text-5xl font-black">Gratis</h2>
                        @else
                            <h2 class="text-5xl font-black">Rp {{ number_format($event->current_price, 0, ',', '.') }} <span class="text-lg font-medium text-[#b8ff00]">/ orang</span></h2>
                            @if($event->is_dynamic_pricing && !empty($event->dynamic_pricing_rules))
                                <div class="mt-2 flex flex-wrap items-center gap-2">
                                    <span class="px-2 py-0.5 bg-[#103370]/50 border border-[#103370]/40 text-white rounded-md text-[10px] font-bold uppercase tracking-wider">Dynamic Pricing Aktif</span>
                                    @php
                                        $upcomingRules = collect($event->dynamic_pricing_rules)
                                            ->map(fn($r) => ['date' => \Carbon\Carbon::parse($r['date']), 'price' => intval($r['price'])])
                                            ->filter(fn($r) => $r['date']->isFuture())
                                            ->sortBy('date');
                                    @endphp
                                    @if($upcomingRules->count() > 0)
                                        @php $nextRule = $upcomingRules->first(); @endphp
                                        <span class="text-xs text-[#b8ff00]/70 font-medium">Harga akan naik menjadi Rp {{ number_format($nextRule['price'], 0, ',', '.') }} pada {{ $nextRule['date']->format('d M Y H:i') }}!</span>
                                    @endif
                                </div>
                            @endif
                        @endif
                        <p class="mt-4 text-[#b8ff00]/70 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Sisa stok: <span class="font-bold underline">{{ $event->stock }} Tiket lagi!</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        @if($event->stock <= 0)
                            <button type="button" class="inline-block px-10 py-5 bg-slate-400 text-white rounded-[40px] font-black text-xl cursor-not-allowed shadow-md" disabled>
                                Stok Habis
                            </button>
                        @else
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <button type="button" onclick="alert('kamu adalah admin')" class="inline-block px-10 py-5 bg-[#F24781] text-white rounded-[40px] font-black text-xl hover:-translate-y-1 hover:shadow-[0_15px_30px_rgba(242,71,129,0.4)] transition-all shadow-[0_10px_20px_rgba(242,71,129,0.3)]">
                                        Pesan Sekarang
                                    </button>
                                    <button type="button" onclick="alert('kamu adalah admin')" class="group relative flex items-center justify-center w-16 h-16 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] text-[#103370] rounded-[40px] border border-slate-200/50 shadow-xl transition-all duration-300 hover:scale-110 hover:bg-green-500 hover:text-white focus:outline-none">
                                        <svg class="w-7 h-7 transition-all duration-300 group-hover:scale-0 group-hover:opacity-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <svg class="absolute w-7 h-7 scale-0 opacity-0 transition-all duration-300 group-hover:scale-100 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                @elseif(Auth::user()->role === 'merchant')
                                    <button type="button" onclick="alert('kamu adalah merchant')" class="inline-block px-10 py-5 bg-[#F24781] text-white rounded-[40px] font-black text-xl hover:-translate-y-1 hover:shadow-[0_15px_30px_rgba(242,71,129,0.4)] transition-all shadow-[0_10px_20px_rgba(242,71,129,0.3)]">
                                        Pesan Sekarang
                                    </button>
                                    <button type="button" onclick="alert('kamu adalah merchant')" class="group relative flex items-center justify-center w-16 h-16 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] text-[#103370] rounded-[40px] border border-slate-200/50 shadow-xl transition-all duration-300 hover:scale-110 hover:bg-green-500 hover:text-white focus:outline-none">
                                        <svg class="w-7 h-7 transition-all duration-300 group-hover:scale-0 group-hover:opacity-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <svg class="absolute w-7 h-7 scale-0 opacity-0 transition-all duration-300 group-hover:scale-100 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                @else
                                    <a href="{{ route('checkout.create', $event) }}"
                                        class="inline-block px-10 py-5 bg-[#F24781] text-white rounded-[40px] font-black text-xl hover:-translate-y-1 hover:shadow-[0_15px_30px_rgba(242,71,129,0.4)] transition-all shadow-[0_10px_20px_rgba(242,71,129,0.3)]">
                                        Pesan Sekarang
                                    </a>
                                    @php
                                        $isInCart = Auth::check() && \App\Models\Cart::where('user_id', Auth::id())->where('event_id', $event->id)->exists();
                                    @endphp
                                    <button type="button" onclick="addToCart()" id="cartBtn" class="group relative flex items-center justify-center w-16 h-16 rounded-[40px] border border-slate-200/50 shadow-xl transition-all duration-300 hover:scale-110 focus:outline-none {{ $isInCart ? 'bg-green-500 text-white' : 'bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] text-[#103370] hover:bg-green-500 hover:text-white' }}" title="Tambah ke Keranjang">
                                        <svg id="cartIcon" class="w-7 h-7 transition-all duration-300 {{ $isInCart ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <svg id="checkIcon" class="w-7 h-7 transition-all duration-300 {{ $isInCart ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}"
                                    class="inline-block px-10 py-5 bg-[#F24781] text-white rounded-[40px] font-black text-xl hover:-translate-y-1 hover:shadow-[0_15px_30px_rgba(242,71,129,0.4)] transition-all shadow-[0_10px_20px_rgba(242,71,129,0.3)]">
                                    Pesan Sekarang
                                </a>
                                <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="group relative flex items-center justify-center w-16 h-16 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] text-[#103370] rounded-[40px] border border-slate-200/50 shadow-xl transition-all duration-300 hover:scale-110 hover:bg-green-500 hover:text-white focus:outline-none" title="Tambah ke Keranjang">
                                    <svg class="w-7 h-7 transition-all duration-300 group-hover:scale-0 group-hover:opacity-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <svg class="absolute w-7 h-7 scale-0 opacity-0 transition-all duration-300 group-hover:scale-100 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>

                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] opacity-10 rounded-full"></div>
                <div class="absolute -left-10 -top-10 w-32 h-32 bg-[#103370]/40 opacity-20 rounded-full"></div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-bold">Kebijakan Tiket</h3>
                <ul class="space-y-3 text-slate-500">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Tiket dapat discan di pintu masuk (Check-in).
                    </li>
                    <li class="flex items-start gap-2 text-rose-500">
                        <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tiket yang sudah dibeli tidak dapat direfund.
                    </li>
                </ul>
            </div>
            @endif

            <div class="border-t border-slate-100 pt-12 space-y-8">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-2xl font-bold text-slate-800">Rating & Ulasan</h3>
                    <span class="px-3 py-1 bg-[#103370]/5 text-[#103370] text-xs font-bold rounded-full uppercase tracking-wider">
                        {{ $event->reviews->count() }} Ulasan
                    </span>
                </div>

                @if(session('success'))
                    <div class="p-4 bg-green-50 text-green-700 border border-green-200 rounded-[40px] flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="font-medium text-sm">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 bg-rose-50 text-rose-700 border border-rose-200 rounded-[40px] flex items-center gap-3">
                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="font-medium text-sm">{{ session('error') }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-[#103370] p-6 rounded-[40px] border border-slate-100 items-center">
                    <div class="text-center md:border-r border-white/20 py-4">
                        <p class="text-white/70 text-sm font-bold uppercase tracking-wider mb-1">Rata-rata Rating</p>
                        <h2 class="text-5xl font-black text-white">{{ $event->average_rating }}</h2>
                        <div class="flex justify-center gap-1 my-3 text-[#b8ff00]">
                            @php
                                $avg = $event->average_rating;
                                $fullStars = floor($avg);
                                $hasHalf = ($avg - $fullStars) >= 0.5;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @elseif($i == $fullStars + 1 && $hasHalf)
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                        <defs>
                                            <linearGradient id="halfGrad">
                                                <stop offset="50%" stop-color="currentColor"/>
                                                <stop offset="50%" stop-color="rgba(255,255,255,0.2)" stop-opacity="1"/>
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#halfGrad)" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-white/20 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <p class="text-xs text-white/60">Berdasarkan {{ $event->reviews->count() }} ulasan</p>
                    </div>

                    <div class="md:col-span-2 space-y-2.5 px-2 md:px-6">

                        @php
                            $totalReviews = $event->reviews->count();
                        @endphp
                        @for($ratingVal = 5; $ratingVal >= 1; $ratingVal--)
                            @php
                                $countVal = $event->reviews->where('rating', $ratingVal)->count();
                                $pct = $totalReviews > 0 ? ($countVal / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="flex items-center gap-4 text-sm font-medium">
                                <span class="w-3 text-white/70">{{ $ratingVal }}</span>
                                <svg class="w-4 h-4 text-[#b8ff00] fill-current" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                                <div class="flex-1 h-2 bg-white/20 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#b8ff00] rounded-full" style="width: {{ $pct }}%"></div>
                                </div>
                                <span class="w-8 text-right text-white/70 text-xs">{{ $countVal }}</span>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="space-y-4">
                    @if($event->reviews->isEmpty())
                        <div class="text-center py-10 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-slate-100 rounded-[40px] shadow-sm space-y-3">
                            <div class="w-16 h-16 bg-[#F24781] text-slate-400 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-8 h-8" fill="none" stroke="#ffffff" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <p class="text-slate-500 font-medium">Belum ada ulasan untuk event ini.</p>
                            <p class="text-xs text-slate-400">Jadilah yang pertama memberikan ulasan!</p>
                        </div>
                    @else
                        <div class="max-h-[500px] overflow-y-auto pr-2 space-y-4" style="scrollbar-width: thin;">
                            @foreach($event->reviews as $review)
                                <div class="p-6 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-slate-100 rounded-[40px] shadow-sm space-y-3 hover:shadow-md transition">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center gap-3">
                                            @if($review->user->avatar_path)
                                                <img src="{{ asset('storage/' . $review->user->avatar_path) }}" alt="{{ $review->user->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-100 shadow-sm shrink-0">
                                            @else
                                                <div class="w-10 h-10 bg-[#103370]/10 rounded-full flex items-center justify-center text-[#103370] font-bold text-sm shrink-0">
                                                    {{ strtoupper(substr($review->user->name, 0, 2)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <h5 class="font-bold text-slate-800 text-sm">{{ $review->user->name }}</h5>
                                                <p class="text-xs text-slate-400">{{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-0.5 text-amber-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
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
                                    </div>
                                    @if($review->review)
                                        <p class="text-slate-600 text-sm leading-relaxed">{{ $review->review }}</p>
                                    @else
                                        <p class="text-slate-400 italic text-xs">Hanya memberikan rating bintang.</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>                <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-slate-100 rounded-[40px] p-6 shadow-sm">
                    @auth
                        @if(Auth::user()->role === 'customer')
                            @php
                                $userReview = $event->reviews->where('user_id', Auth::id())->first();
                                $eventFinished = now()->greaterThanOrEqualTo($event->date->copy()->addDay());
                                $hasTicket = \App\Models\Transaction::where('event_id', $event->id)
                                    ->where('customer_email', Auth::user()->email)
                                    ->whereIn('status', ['success', 'settlement', 'Success', 'Settlement'])
                                    ->exists();
                            @endphp

                            @if(!$eventFinished)
                                <div class="text-center py-6 space-y-3">
                                    <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-slate-800">Ulasan Belum Dibuka</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto">Rating & ulasan baru dapat diberikan mulai dari satu hari setelah acara selesai (Mulai: {{ $event->date->copy()->addDay()->format('d M Y, H:i') }}).</p>
                                </div>
                            @elseif(!$hasTicket)
                                <div class="text-center py-6 space-y-3">
                                    <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-slate-800">Akses Terbatas</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto">Hanya pembeli yang memiliki tiket sukses/lunas untuk event ini yang dapat memberikan rating dan ulasan.</p>
                                </div>
                            @elseif($userReview)
                                <div class="text-center py-4 space-y-3">
                                    <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-slate-800">Terima kasih atas ulasan Anda!</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto">Anda telah memberikan rating <strong>{{ $userReview->rating }} bintang</strong> untuk event ini. Setiap pengguna hanya dapat mengirimkan satu ulasan per event.</p>
                                </div>
                            @else
                                <form action="{{ route('reviews.store', $event) }}" method="POST" id="reviewForm" class="space-y-5">
                                    @csrf
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-lg mb-1">Berikan Ulasan Anda</h4>
                                        <p class="text-xs text-slate-400">Bagikan pengalaman Anda tentang event ini dengan yang lain.</p>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-slate-700">Rating Anda <span class="text-rose-500">*</span></label>
                                        <div class="flex items-center gap-1.5">
                                            <input type="hidden" name="rating" id="ratingInput" value="0">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" data-star-value="{{ $i }}" class="star-btn p-1 text-slate-300 hover:scale-110 transition-transform focus:outline-none">
                                                    <svg class="w-8 h-8 fill-current transition-colors duration-200" viewBox="0 0 24 24">
                                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                    </svg>
                                                </button>
                                            @endfor
                                            <span id="ratingError" class="hidden text-xs text-rose-500 font-semibold ml-2">Rating wajib diisi!</span>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="reviewText" class="block text-sm font-semibold text-slate-700">Ulasan</label>
                                        <div class="relative">
                                            <textarea name="review" id="reviewText" rows="4" maxlength="280"
                                                class="w-full p-4 border border-slate-200 rounded-[40px] text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder:text-slate-400"
                                                placeholder="Tulis ulasan Anda tentang event ini di sini (opsional, maks 280 karakter)..."></textarea>
                                            <div class="absolute bottom-3 right-4 text-xs font-semibold text-slate-400" id="charCounter">
                                                0 / 280
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="w-full py-4 bg-[#103370] text-white font-bold rounded-[40px] shadow-[0_10px_20px_rgba(16,51,112,0.3)] hover:bg-[#F24781] hover:shadow-[0_10px_20px_rgba(242,71,129,0.3)] transition-all">
                                        Kirim Ulasan
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="text-center py-4 space-y-2">
                                <svg class="w-8 h-8 text-amber-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <p class="text-slate-600 text-sm font-medium">Hanya akun customer yang dapat memberikan ulasan.</p>
                                <p class="text-xs text-slate-400">Anda login sebagai <span class="font-bold uppercase">{{ Auth::user()->role }}</span>.</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-6 space-y-3">
                            <p class="text-slate-600 text-sm font-medium">Ingin memberikan rating & ulasan?</p>
                            <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="inline-block px-6 py-2.5 bg-[#103370] text-white font-bold text-sm rounded-[40px] shadow-[0_10px_20px_rgba(16,51,112,0.3)] hover:bg-[#F24781] hover:shadow-[0_10px_20px_rgba(242,71,129,0.3)] transition-all">
                                Login Sekarang
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </main>
    <script>
        function toggleWishlist() {
            const url = "{{ route('wishlist.toggle', $event) }}";
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
                if (!data) return;
                const heart = document.getElementById('wishlistHeart');
                if (data.isWishlisted) {
                    heart.classList.remove('fill-none');
                    heart.classList.add('fill-rose-500');
                } else {
                    heart.classList.remove('fill-rose-500');
                    heart.classList.add('fill-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        let isInCart = @json(Auth::check() && \App\Models\Cart::where('user_id', Auth::id())->where('event_id', $event->id)->exists());

        function addToCart() {
            if (isInCart) {
                // Konfirmasi Penghapusan
                if (!confirm('Apakah Anda ingin menghapus event ini dari keranjang?')) {
                    return;
                }

                const url = "{{ route('cart.removeByEvent', $event) }}";
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
                    if (!data) return;
                    if(data.success) {
                        alert('Event berhasil dihapus dari keranjang!');
                        isInCart = false;

                        // Kembalikan tombol ke kondisi semula (putih)
                        const btn = document.getElementById('cartBtn');
                        const cartIcon = document.getElementById('cartIcon');
                        const checkIcon = document.getElementById('checkIcon');

                        if (btn && cartIcon && checkIcon) {
                            btn.className = "group relative flex items-center justify-center w-16 h-16 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] text-[#103370] rounded-[40px] border border-slate-200/50 shadow-xl transition-all duration-300 hover:scale-110 hover:bg-green-500 hover:text-white focus:outline-none";
                            cartIcon.classList.remove('hidden');
                            checkIcon.classList.add('hidden');
                        }
                    } else {
                        alert(data.message || 'Gagal menghapus dari keranjang.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                // Tambahkan ke keranjang
                const url = "{{ route('cart.add', $event) }}";
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
                    if (!data) return;
                    if(data.success) {
                        alert('Event berhasil ditambahkan ke keranjang!');
                        isInCart = true;

                        // Ubah tombol menjadi hijau dengan centang
                        const btn = document.getElementById('cartBtn');
                        const cartIcon = document.getElementById('cartIcon');
                        const checkIcon = document.getElementById('checkIcon');

                        if (btn && cartIcon && checkIcon) {
                            btn.className = "group relative flex items-center justify-center w-16 h-16 rounded-[40px] border border-slate-200/50 shadow-xl transition-all duration-300 hover:scale-110 focus:outline-none bg-green-500 text-white";
                            cartIcon.classList.add('hidden');
                            checkIcon.classList.remove('hidden');
                        }
                    } else {
                        alert('Gagal menambahkan ke keranjang.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }

        // Star rating picker interactivity
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('ratingInput');
            const ratingError = document.getElementById('ratingError');
            let currentSelected = 0;

            if (stars && stars.length > 0) {
                stars.forEach(star => {
                    const value = parseInt(star.getAttribute('data-star-value'));

                    // Hover effect
                    star.addEventListener('mouseenter', () => {
                        highlightStars(value);
                    });

                    // Mouse leave effect (restore to selection)
                    star.addEventListener('mouseleave', () => {
                        highlightStars(currentSelected);
                    });

                    // Click event (select rating)
                    star.addEventListener('click', () => {
                        currentSelected = value;
                        if (ratingInput) ratingInput.value = value;
                        if (ratingError) ratingError.classList.add('hidden');
                        highlightStars(value);
                    });
                });
            }

            function highlightStars(count) {
                stars.forEach(star => {
                    const starVal = parseInt(star.getAttribute('data-star-value'));
                    const svg = star.querySelector('svg');
                    if (svg) {
                        if (starVal <= count) {
                            svg.classList.remove('text-slate-300');
                            svg.classList.add('text-amber-400');
                        } else {
                            svg.classList.remove('text-amber-400');
                            svg.classList.add('text-slate-300');
                        }
                    }
                });
            }

            // Live character counter for review textarea
            const reviewText = document.getElementById('reviewText');
            const charCounter = document.getElementById('charCounter');

            if (reviewText && charCounter) {
                reviewText.addEventListener('input', () => {
                    const len = reviewText.value.length;
                    charCounter.textContent = `${len} / 280`;

                    if (len >= 280) {
                        charCounter.classList.remove('text-slate-400');
                        charCounter.classList.add('text-rose-500');
                    } else {
                        charCounter.classList.remove('text-rose-500');
                        charCounter.classList.add('text-slate-400');
                    }
                });
            }

            // Form validation
            const form = document.getElementById('reviewForm');
            if (form) {
                form.addEventListener('submit', (e) => {
                    const val = parseInt(ratingInput ? ratingInput.value : 0);
                    if (val === 0) {
                        e.preventDefault();
                        if (ratingError) {
                            ratingError.classList.remove('hidden');
                            ratingError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                });
            }
        });
    </script>
@endsection
