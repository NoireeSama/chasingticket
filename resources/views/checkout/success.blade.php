@extends('layouts.app')

@section('title', 'Pembayaran Berhasil - ChasingTicket')

@section('content')
<main class="max-w-xl mx-auto px-4 py-12 md:py-20 text-center">
    <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[40px] p-8 md:p-12 relative overflow-hidden text-center w-full">
        <!-- Decorative Glow Blobs -->
        <div class="absolute -right-16 -top-16 w-72 h-72 bg-[#b8ff00]/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10">
            <!-- Checkmark Icon -->
            <div class="w-20 h-20 bg-emerald-500 text-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_15px_30px_rgba(16,185,129,0.35)]">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h2 class="text-3xl md:text-4xl font-black text-[#103370] mb-2 tracking-tight">Pembayaran Berhasil!</h2>
            <p class="text-slate-500 font-medium text-sm md:text-base mb-4">Terima kasih, transaksi Anda telah kami terima.</p>

            <span class="inline-block px-4 py-1.5 bg-[#b8ff00] text-[#103370] font-mono font-black text-xs rounded-full uppercase tracking-wider mb-6 shadow-sm">
                Order ID: {{ $transaction->order_id }}
            </span>

            @if($transaction->event)
                <div class="bg-slate-50 border-2 border-[#f1f5f9] rounded-[25px] p-5 mb-6 text-left flex items-center gap-4">
                    <img src="{{ $transaction->event->poster_path ? asset('storage/' . $transaction->event->poster_path) : "data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='500' viewBox='0 0 400 500'%3E%3Crect width='400' height='500' fill='%23f1f5f9'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-weight='bold' font-size='20' fill='%23103370'%3EEvent Poster%3C/text%3E%3C/svg%3E" }}"
                        alt="{{ $transaction->event->title }}" class="w-16 h-20 rounded-[15px] object-cover shadow-sm border-2 border-white shrink-0">
                    <div>
                        <h4 class="font-extrabold text-[#103370] text-base leading-snug">{{ $transaction->event->title }}</h4>
                        <p class="text-xs text-slate-500 font-medium mt-1">
                            {{ $transaction->event->date->format('d M Y, H:i') }} • {{ $transaction->event->location }}
                        </p>
                        <p class="text-xs font-bold text-[#F24781] mt-1">{{ $transaction->quantity }} Tiket • Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endif

            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-[20px] mb-8 text-left flex items-start gap-3">
                <div class="w-7 h-7 bg-emerald-500 text-white rounded-full flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">
                    ✉️
                </div>
                <div class="text-xs text-slate-600 font-medium leading-relaxed">
                    E-Ticket resmi telah atau akan otomatis dikirimkan ke email Anda (<strong>{{ $transaction->customer_email }}</strong>). Anda juga dapat melihat tiket kapan saja di halaman riwayat belanja.
                </div>
            </div>

            <div class="space-y-4">
                <a href="{{ route('history') }}" class="inline-flex items-center justify-center gap-3 w-full py-5 md:py-6 px-8 bg-[#103370] text-white hover:bg-[#F24781] font-black text-lg md:text-xl rounded-full min-h-[64px] shadow-[0_12px_30px_rgba(16,51,112,0.3)] hover:shadow-[0_15px_35px_rgba(242,71,129,0.4)] transition-all duration-300 transform active:scale-98 tracking-wide">
                    <span>Lihat Tiket Saya</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>

                <a href="{{ route('home') }}" class="inline-block text-xs font-bold text-slate-500 hover:text-[#103370] transition pt-2">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</main>
@endsection
