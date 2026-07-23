@extends('layouts.app')

@section('content')
<main class="max-w-5xl mx-auto px-6 py-12">
    
    <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <nav class="flex text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 gap-2 items-center">
                <a href="{{ route('home') }}" class="hover:text-[#103370] transition">Jelajahi</a>
                <span>/</span>
                <span class="text-slate-600 font-bold">Riwayat Belanja</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900">Riwayat Belanja</h1>
            <p class="text-sm md:text-base text-slate-500 font-medium mt-1">Pantau pembayaran, tiket, dan transaksi event yang Anda beli.</p>
        </div>
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-slate-200 text-slate-700 rounded-[40px] text-sm font-semibold shadow-neu-spec border-none-sm border-none border-none hover:bg-[#e0e0e0] transition gap-2 self-start md:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Jelajah
        </a>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-50 text-emerald-800 border border-emerald-100 rounded-[40px] flex items-center gap-3 shadow-neu-spec border-none-sm border-none border-none animate-fade-in">
            <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <p class="font-bold text-sm">Berhasil!</p>
                <p class="text-xs text-emerald-600 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($transactions->isEmpty())
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
                    <span>Jelajahi Event Menarik</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    @else
        <div class="space-y-6">
            @foreach($transactions as $transaction)
                <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] rounded-[40px] border border-white/50 shadow-neu-spec border-none-sm border-none border-none overflow-hidden hover:shadow-neu-spec border-none-sm border-none transition duration-300">

                    <div class="bg-[#e0e0e0]/60 px-6 py-4 border-b border-white/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Tanggal Transaksi</p>
                                <p class="font-bold text-slate-700 mt-0.5">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="hidden sm:block w-px h-8 bg-slate-200"></div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Order ID</p>
                                <p class="font-mono font-bold text-slate-800 mt-0.5">{{ $transaction->order_id }}</p>
                            </div>
                        </div>

                        <div>
                            @if(in_array(strtolower($transaction->status), ['success', 'settlement']))
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full text-xs font-bold shadow-neu-spec border-none-sm border-none border-none">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Pembayaran Sukses
                                </span>
                            @elseif(strtolower($transaction->status) === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 border border-amber-100 rounded-full text-xs font-bold shadow-neu-spec border-none-sm border-none border-none">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Menunggu Pembayaran
                                </span>
                            @elseif(in_array(strtolower($transaction->status), ['failed', 'cancel', 'deny', 'expire']))
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 text-rose-700 border border-rose-100 rounded-full text-xs font-bold shadow-neu-spec border-none-sm border-none border-none">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Gagal / Kedaluwarsa
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-full text-xs font-bold shadow-neu-spec border-none-sm border-none border-none">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6">
                        @if($transaction->event)
                            <div class="flex flex-col md:flex-row gap-6">
                                
                                <div class="w-full md:w-36 h-48 md:h-44 rounded-[40px] overflow-hidden bg-slate-100 flex-shrink-0 relative border border-white/50">
                                    @if($transaction->event->poster_path)
                                        <img src="{{ asset('storage/' . $transaction->event->poster_path) }}" alt="{{ $transaction->event->title }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://via.placeholder.com/150x200?text={{ urlencode($transaction->event->title) }}" alt="{{ $transaction->event->title }}" class="w-full h-full object-cover">
                                    @endif
                                </div>

                                <div class="flex-grow flex flex-col justify-between">
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-block px-2.5 py-1 bg-[#103370]/5 text-[#103370] rounded-lg text-[10px] font-bold uppercase tracking-wider">
                                                {{ $transaction->event->category->name ?? 'Event' }}
                                            </span>
                                            <span class="text-xs text-slate-400 font-semibold">•</span>
                                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">{{ $transaction->quantity }} Tiket</span>
                                        </div>
                                        <h3 class="text-xl font-bold text-slate-800 leading-snug hover:text-[#103370] transition">
                                            <a href="{{ url('event/' . $transaction->event->id) }}">{{ $transaction->event->title }}</a>
                                        </h3>

                                        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-xs font-semibold text-slate-500 pt-1">
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($transaction->event->date)->format('d M Y, H:i') }} WIB
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $transaction->event->location }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="border-t border-white/50 mt-4 pt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                        <div>
                                            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Total Pembayaran</p>
                                            <p class="text-lg font-black text-[#103370]">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                                        </div>

                                        <div class="w-full sm:w-auto self-stretch sm:self-auto flex items-center gap-3">
                                            @if(in_array(strtolower($transaction->status), ['success', 'settlement']))
                                                @if($transaction->event && now()->greaterThanOrEqualTo($transaction->event->date))
                                                    <a href="{{ route('events.show', $transaction->event->id) }}#reviewForm" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-[40px] text-xs font-bold shadow-neu-spec border-none-sm border-none shadow-amber-100 hover:shadow-neu-spec border-none-sm border-none transition">
                                                        Beri Ulasan
                                                    </a>
                                                @else
                                                    <a href="{{ route('ticket.show', $transaction->order_id) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-[#103370] hover:bg-purple-700 text-white rounded-[40px] text-xs font-bold shadow-neu-spec border-none-sm border-none shadow-[0_15px_35px_rgba(16,51,112,0.3)]/10 hover:shadow-neu-spec border-none-sm border-none transition">
                                                        Lihat E-Ticket
                                                    </a>
                                                @endif
                                            @elseif(strtolower($transaction->status) === 'pending')
                                                <a href="{{ route('checkout.payment', $transaction->order_id) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-[40px] text-xs font-bold shadow-neu-spec border-none-sm border-none shadow-amber-100 hover:shadow-neu-spec border-none-sm border-none transition">
                                                    Bayar Sekarang
                                                </a>
                                            @elseif(in_array(strtolower($transaction->status), ['failed', 'cancel', 'deny', 'expire']))
                                                <a href="{{ url('event/' . $transaction->event->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 border border-slate-200 text-slate-600 hover:bg-[#e0e0e0] rounded-[40px] text-xs font-bold transition">
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
