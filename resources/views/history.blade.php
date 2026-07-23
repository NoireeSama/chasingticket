@extends('layouts.app')

@section('title', 'Riwayat Belanja - ChasingTicket')

@section('content')
<main class="max-w-6xl mx-auto px-4 sm:px-6 py-12 md:py-16">
    
    <!-- Page Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-[#103370] tracking-tight mb-2">Riwayat Belanja</h1>
            <p class="text-slate-500 font-medium text-sm md:text-base">Pantau transaksi, status pembayaran, dan E-Ticket event yang Anda beli.</p>
        </div>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] text-[#103370] hover:bg-[#103370] hover:text-white rounded-full font-extrabold text-xs transition-all duration-300 self-start md:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Jelajahi Event Lainnya</span>
        </a>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-[#b8ff00]/20 text-[#103370] border border-[#b8ff00] rounded-full flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 rounded-full bg-[#103370] text-[#b8ff00] flex items-center justify-center shrink-0 font-black">✓</div>
            <p class="font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    @if($transactions->isEmpty())
        <!-- Empty State -->
        <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[40px] p-12 md:p-16 text-center relative overflow-hidden my-6">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-[#b8ff00]/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-10 -top-10 w-64 h-64 bg-[#F24781]/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <div class="w-20 h-20 bg-[#103370] text-[#b8ff00] rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_15px_30px_rgba(16,51,112,0.25)]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-[#103370] mb-2">Riwayat Belanja Kosong</h3>
                <p class="text-slate-500 max-w-md mx-auto text-sm font-medium mb-8">Anda belum pernah melakukan pemesanan atau pembelian tiket event di platform ini.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-[#F24781] text-white font-bold rounded-full shadow-[0_10px_25px_rgba(242,71,129,0.3)] hover:bg-[#103370] hover:shadow-[0_10px_25px_rgba(16,51,112,0.3)] transition-all">
                    <span>Jelajahi Event Seru</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    @else
        <!-- Transaction Cards List -->
        <div class="space-y-6">
            @foreach($transactions as $transaction)
                <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] rounded-[40px] hover:shadow-[0_20px_50px_rgba(16,51,112,0.1)] transition-all duration-300 overflow-hidden">

                    <!-- Top Status Bar -->
                    <div class="bg-slate-50 border-b-2 border-[#f1f5f9] px-6 md:px-8 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs md:text-sm font-semibold">
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                            <div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Tanggal Transaksi</span>
                                <span class="font-bold text-[#103370] mt-0.5 block">{{ $transaction->created_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                            <div class="hidden sm:block w-px h-7 bg-slate-200"></div>
                            <div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Order ID</span>
                                <span class="font-mono font-black text-[#103370] bg-white border border-slate-200 px-3 py-0.5 rounded-full text-xs inline-block mt-0.5 shadow-sm">
                                    {{ $transaction->order_id }}
                                </span>
                            </div>
                        </div>

                        <div>
                            @if(in_array(strtolower($transaction->status), ['success', 'settlement']))
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-black uppercase tracking-wider shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Pembayaran Sukses
                                </span>
                            @elseif(strtolower($transaction->status) === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-black uppercase tracking-wider shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    Menunggu Pembayaran
                                </span>
                            @elseif(in_array(strtolower($transaction->status), ['failed', 'cancel', 'deny', 'expire']))
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-rose-100 text-rose-800 rounded-full text-xs font-black uppercase tracking-wider shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    Gagal / Kedaluwarsa
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-black uppercase tracking-wider">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Main Transaction Info -->
                    <div class="p-6 md:p-8">
                        @if($transaction->event)
                            <div class="flex flex-col sm:flex-row gap-6 items-start">
                                
                                <!-- Event Poster -->
                                <div class="w-full sm:w-32 md:w-36 h-44 sm:h-40 rounded-[28px] overflow-hidden bg-slate-100 shrink-0 border-2 border-white shadow-md">
                                    @if($transaction->event->poster_path)
                                        <img src="{{ asset('storage/' . $transaction->event->poster_path) }}" alt="{{ $transaction->event->title }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://via.placeholder.com/150x200?text={{ urlencode($transaction->event->title) }}" alt="{{ $transaction->event->title }}" class="w-full h-full object-cover">
                                    @endif
                                </div>

                                <!-- Event Details -->
                                <div class="flex-grow flex flex-col justify-between w-full">
                                    <div class="space-y-2">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="px-3 py-1 bg-[#b8ff00] text-[#103370] rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm">
                                                {{ $transaction->event->category->name ?? 'Event' }}
                                            </span>
                                            <span class="px-3 py-1 bg-slate-100 text-[#103370] rounded-full text-[10px] font-black uppercase tracking-wider">
                                                {{ $transaction->quantity }} Tiket
                                            </span>
                                        </div>

                                        <h3 class="text-xl md:text-2xl font-black text-[#103370] hover:text-[#F24781] transition leading-snug">
                                            <a href="{{ url('event/' . $transaction->event->id) }}">{{ $transaction->event->title }}</a>
                                        </h3>

                                        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-xs font-semibold text-slate-500 pt-1">
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-[#F24781]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($transaction->event->date)->format('d M Y, H:i') }} WIB
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-[#F24781]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $transaction->event->location }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Bottom Action Row -->
                                    <div class="border-t border-slate-100 mt-5 pt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                        <div>
                                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-0.5">Total Pembayaran</span>
                                            <span class="text-xl md:text-2xl font-black text-[#F24781]">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                                        </div>

                                        <div class="w-full sm:w-auto flex items-center gap-3">
                                            @if(in_array(strtolower($transaction->status), ['success', 'settlement']))
                                                @if($transaction->event && now()->greaterThanOrEqualTo($transaction->event->date))
                                                    <a href="{{ route('events.show', $transaction->event->id) }}#reviewForm" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-full font-extrabold text-xs transition shadow-md gap-1.5">
                                                        <span>⭐ Beri Ulasan</span>
                                                    </a>
                                                @else
                                                    <a href="{{ route('ticket.show', $transaction->order_id) }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#103370] text-white hover:bg-[#F24781] rounded-full font-extrabold text-xs transition-all duration-300 shadow-md">
                                                        <span>Lihat E-Ticket</span>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                        </svg>
                                                    </a>
                                                @endif
                                            @elseif(strtolower($transaction->status) === 'pending')
                                                <a href="{{ route('checkout.payment', $transaction->order_id) }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#103370] text-white hover:bg-[#F24781] rounded-full font-extrabold text-xs transition-all duration-300 shadow-md">
                                                    <span>Bayar Sekarang</span>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                    </svg>
                                                </a>
                                            @elseif(in_array(strtolower($transaction->status), ['failed', 'cancel', 'deny', 'expire']))
                                                <a href="{{ url('event/' . $transaction->event->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-slate-100 hover:bg-slate-200 text-[#103370] rounded-full font-bold text-xs transition">
                                                    Beli Tiket Lagi
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-slate-500 text-sm font-medium py-2">
                                Informasi detail event tidak tersedia atau telah dihapus.
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</main>
@endsection
