@extends('layouts.app')

@section('content')

<div class="welcome-container">
    
    <section class="hero-creative">
        <div class="hero-blob-1"></div>
        <div class="hero-blob-2"></div>
        
        <div class="hero-content">
            <h1 class="hero-title">
                Kejar & Pesan <br>
                <span class="highlight-pill">Tiket Event</span> Impianmu.
            </h1>
            <p class="hero-desc">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman, cepat, dan terpercaya dengan Midtrans.
            </p>
            <div>
                <a href="#events" class="hero-btn">
                    Mulai Jelajah
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
                <a href="#cara-memesan" class="hero-btn-outline">
                    Cara Pesan
                </a>
            </div>
        </div>

        <div class="hero-image-wrapper">
            <div class="hero-image-card">
                <img src="{{ asset('assets/concert.png') }}" alt="Concert" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1459749411175-04bf5292ceea?auto=format&fit=crop&q=80&w=800';">
            </div>
            
            <div class="floating-badge">
                <div class="icon-box">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p style="font-size:0.7rem; font-weight:800; color:#64748b; text-transform:uppercase; margin-bottom:0.1rem;">Terverifikasi</p>
                    <p style="font-weight:800; color:var(--color-dark-blue); font-size:0.9rem;">Pembayaran Aman</p>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto my-12 px-4">
        <div class="bg-[#103370] rounded-[40px] p-8 md:p-10 shadow-2xl relative overflow-hidden border-2 border-white/10">

            <div class="text-center mb-8">
                <h2 class="inline-flex items-center gap-3 text-lg md:text-xl font-black text-[#b8ff00] uppercase tracking-widest">
                    <span class="w-10 h-0.5 bg-[#b8ff00] hidden sm:block"></span>
                    <svg class="w-5 h-5 text-[#b8ff00]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    Mitra Kami
                    <span class="w-10 h-0.5 bg-[#b8ff00] hidden sm:block"></span>
                </h2>
            </div>

            <div class="absolute left-0 top-0 bottom-0 w-24 md:w-40 bg-gradient-to-r from-[#103370] to-transparent z-20 pointer-events-none"></div>
            <div class="absolute right-0 top-0 bottom-0 w-24 md:w-40 bg-gradient-to-l from-[#103370] to-transparent z-20 pointer-events-none"></div>

            <div class="relative w-full overflow-hidden pointer-events-none select-none">
                @if($partners->count() > 5)
                    
                    <div class="flex gap-12 md:gap-20 items-center w-max animate-marquee">
                        @foreach($partners as $partner)
                            <div class="flex items-center justify-center h-16 shrink-0 px-4">
                                <img src="{{ $partner->url_Logo }}" alt="{{ $partner->name }}"
                                     class="h-10 md:h-12 w-auto max-w-[170px] object-contain filter drop-shadow-md brightness-0 invert opacity-95"
                                     onerror="this.onerror=null; this.classList.remove('brightness-0', 'invert'); this.src='data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'160\' height=\'50\' viewBox=\'0 0 160 50\'%3E%3Crect width=\'160\' height=\'50\' fill=\'none\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-weight=\'bold\' font-size=\'14\' fill=\'%23ffffff\'%3E{{ urlencode($partner->name) }}%3C/text%3E%3C/svg%3E';">
                            </div>
                        @endforeach
                        
                        @foreach($partners as $partner)
                            <div class="flex items-center justify-center h-16 shrink-0 px-4">
                                <img src="{{ $partner->url_Logo }}" alt="{{ $partner->name }}"
                                     class="h-10 md:h-12 w-auto max-w-[170px] object-contain filter drop-shadow-md brightness-0 invert opacity-95"
                                     onerror="this.onerror=null; this.classList.remove('brightness-0', 'invert'); this.src='data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'160\' height=\'50\' viewBox=\'0 0 160 50\'%3E%3Crect width=\'160\' height=\'50\' fill=\'none\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-weight=\'bold\' font-size=\'14\' fill=\'%23ffffff\'%3E{{ urlencode($partner->name) }}%3C/text%3E%3C/svg%3E';">
                            </div>
                        @endforeach
                    </div>
                @else
                    
                    <div class="flex flex-wrap items-center justify-center gap-8 md:gap-14 py-2">
                        @forelse($partners as $partner)
                            <div class="flex items-center justify-center h-16 px-4">
                                <img src="{{ $partner->url_Logo }}" alt="{{ $partner->name }}"
                                     class="h-10 md:h-12 w-auto max-w-[170px] object-contain filter drop-shadow-md brightness-0 invert opacity-95"
                                     onerror="this.onerror=null; this.classList.remove('brightness-0', 'invert'); this.src='data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'160\' height=\'50\' viewBox=\'0 0 160 50\'%3E%3Crect width=\'160\' height=\'50\' fill=\'none\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-weight=\'bold\' font-size=\'14\' fill=\'%23ffffff\'%3E{{ urlencode($partner->name) }}%3C/text%3E%3C/svg%3E';">
                            </div>
                        @empty
                            <p class="text-white/60 font-semibold text-sm">Belum ada partner yang ditampilkan</p>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section id="cara-memesan" class="my-16 px-4 max-w-7xl mx-auto scroll-mt-24">
        <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[40px] p-8 md:p-14 relative overflow-hidden">
            
            <div class="absolute -right-16 -top-16 w-80 h-80 bg-[#b8ff00]/25 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-80 h-80 bg-[#F24781]/15 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 text-center max-w-3xl mx-auto mb-12">
                <span class="inline-block px-4 py-1.5 bg-[#b8ff00] text-[#103370] rounded-full text-xs font-black uppercase tracking-wider mb-3 shadow-sm">
                    Mudah & Cepat
                </span>
                <h2 class="text-3xl md:text-4xl font-black text-[#103370] tracking-tight mb-3">
                    Cara Memesan Tiket di <span class="text-[#F24781]">ChasingTicket</span>
                </h2>
                <p class="text-slate-500 text-sm md:text-base font-medium">
                    Hanya butuh 4 langkah simpel untuk amankan tiket event favoritmu secara instan!
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 relative z-10">
                
                <div class="bg-slate-50 border-2 border-[#f1f5f9] rounded-[30px] p-6 text-center hover:-translate-y-2 hover:shadow-xl hover:border-[#103370] transition-all duration-300 group">
                    <div class="w-14 h-14 bg-[#103370] text-[#b8ff00] font-black text-xl rounded-full flex items-center justify-center mx-auto mb-5 shadow-md group-hover:scale-110 transition">
                        1
                    </div>
                    <h3 class="font-black text-[#103370] text-lg mb-2">Pilih Event</h3>
                    <p class="text-slate-500 text-xs font-semibold leading-relaxed">
                        Cari & jelajahi berbagai konser musik, seminar IT, atau workshop impianmu.
                    </p>
                </div>

                <div class="bg-slate-50 border-2 border-[#f1f5f9] rounded-[30px] p-6 text-center hover:-translate-y-2 hover:shadow-xl hover:border-[#F24781] transition-all duration-300 group">
                    <div class="w-14 h-14 bg-[#F24781] text-white font-black text-xl rounded-full flex items-center justify-center mx-auto mb-5 shadow-md group-hover:scale-110 transition">
                        2
                    </div>
                    <h3 class="font-black text-[#103370] text-lg mb-2">Pesan & Diskon</h3>
                    <p class="text-slate-500 text-xs font-semibold leading-relaxed">
                        Tentukan jumlah tiket dan gunakan kode kupon promo diskon jika tersedia.
                    </p>
                </div>

                <div class="bg-slate-50 border-2 border-[#f1f5f9] rounded-[30px] p-6 text-center hover:-translate-y-2 hover:shadow-xl hover:border-[#103370] transition-all duration-300 group">
                    <div class="w-14 h-14 bg-[#103370] text-[#b8ff00] font-black text-xl rounded-full flex items-center justify-center mx-auto mb-5 shadow-md group-hover:scale-110 transition">
                        3
                    </div>
                    <h3 class="font-black text-[#103370] text-lg mb-2">Bayar Praktis</h3>
                    <p class="text-slate-500 text-xs font-semibold leading-relaxed">
                        Selesaikan pembayaran dengan aman via QRIS, GoPay, E-Wallet atau Bank Transfer.
                    </p>
                </div>

                <div class="bg-slate-50 border-2 border-[#f1f5f9] rounded-[30px] p-6 text-center hover:-translate-y-2 hover:shadow-xl hover:border-[#F24781] transition-all duration-300 group">
                    <div class="w-14 h-14 bg-[#b8ff00] text-[#103370] font-black text-xl rounded-full flex items-center justify-center mx-auto mb-5 shadow-md group-hover:scale-110 transition">
                        4
                    </div>
                    <h3 class="font-black text-[#103370] text-lg mb-2">Terima E-Ticket</h3>
                    <p class="text-slate-500 text-xs font-semibold leading-relaxed">
                        E-Ticket ber-QR Code otomatis terbit dan siap kamu tunjukkan di lokasi event.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="events" class="events-section">
        <h2 class="section-title">What <span>we</span> provide?</h2>
        <p class="section-subtitle">Jangan sampai ketinggalan acara seru minggu ini! Temukan berbagai pengalaman baru.</p>

        <div class="filter-wrapper">
            <span class="filter-label">Filter:</span>
            <a href="/" class="filter-pill {{ !request('category') ? 'active' : '' }}">
                Semua Kategori
            </a>
            @foreach($categories as $cat)
            <a href="/?category={{ $cat->slug }}" class="filter-pill {{ request('category') === $cat->slug ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>

        <div class="events-grid-custom">
            @foreach ($events as $event)
            <a href="{{ url('event/' . $event->id) }}" style="text-decoration: none;">
                <div class="event-card-playful">
                    <div class="event-image-container">
                        <div class="event-category-badge">
                            {{ $event->category->name }}
                        </div>
                        
                        @if($event->poster_path)
                            <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}" style="{{ $event->stock <= 0 ? 'filter: grayscale(100%); opacity:0.8;' : '' }}">
                        @else
                            <img src="https://via.placeholder.com/400x600?text={{ urlencode($event->title) }}" alt="{{ $event->title }}" style="{{ $event->stock <= 0 ? 'filter: grayscale(100%); opacity:0.8;' : '' }}">
                        @endif

                        @if($event->stock <= 0)
                            <div class="event-empty-badge">
                                <span>Stok Habis</span>
                            </div>
                        @endif
                    </div>

                    <div class="event-info">
                        <h3>{{ $event->title }}</h3>
                        <div class="event-meta">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            @endforeach
        </div>
    </section>
</div>
@endsection
