@extends('layouts.app')

@section('title', 'E-Ticket Resmi - ' . (optional($transaction?->event)->title ?? 'ChasingTicket'))

@section('content')
<main class="max-w-2xl mx-auto px-4 py-8 md:py-14">

    <!-- Top Announcement (Hidden on Print) -->
    <div class="text-center mb-8 no-print">
        <div class="w-16 h-16 bg-[#103370] text-[#b8ff00] rounded-full flex items-center justify-center mx-auto mb-4 shadow-[0_10px_25px_rgba(16,51,112,0.25)] border-4 border-white">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-3xl md:text-4xl font-black text-[#103370] tracking-tight">E-Ticket Resmi</h1>
        <p class="text-slate-500 font-medium text-sm md:text-base mt-1">Tiket Anda telah terbit & siap digunakan untuk akses gate masuk acara.</p>
    </div>

    <!-- The E-Ticket Card -->
    <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_25px_60px_rgba(16,51,112,0.12)] rounded-[40px] overflow-hidden relative print:shadow-none print:border-2 print:border-slate-300">
        
        <!-- Header Stub Section -->
        <div class="p-6 md:p-10 bg-[#103370] text-white relative overflow-hidden">
            <!-- Decorative Blobs -->
            <div class="absolute -right-10 -top-10 w-48 h-48 bg-[#b8ff00]/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -left-10 -bottom-10 w-48 h-48 bg-[#F24781]/20 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10">
                <div class="flex items-center justify-between gap-2 mb-3 flex-wrap">
                    <span class="px-3.5 py-1 bg-[#b8ff00] text-[#103370] rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm">
                        E-Ticket Resmi • {{ optional($transaction?->event?->category)->name ?? 'Acara' }}
                    </span>
                    <span class="text-xs font-mono font-bold text-white/70">
                        ChasingTicket Verified
                    </span>
                </div>

                <h2 class="text-2xl md:text-3xl font-black text-white leading-tight mb-4 tracking-tight">
                    {{ optional($transaction?->event)->title ?? 'Event Title' }}
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-3 border-t border-white/10 text-xs font-medium text-white/90">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#b8ff00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ optional($transaction?->event)->date?->format('d M Y, H:i') ?? 'Jadwal Acara' }} WIB</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#b8ff00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="truncate">{{ optional($transaction?->event)->location ?? 'Venue Location' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashed Divider with Cutout Stub Notches -->
        <div class="relative py-2 bg-white">
            <div class="border-b-2 border-dashed border-slate-200 w-full"></div>
            <div class="absolute -left-5 top-1/2 -translate-y-1/2 w-8 h-8 bg-[#f8fafc] border-r-2 border-slate-200 rounded-full print:border-slate-300"></div>
            <div class="absolute -right-5 top-1/2 -translate-y-1/2 w-8 h-8 bg-[#f8fafc] border-l-2 border-slate-200 rounded-full print:border-slate-300"></div>
        </div>

        <!-- Main Ticket Details Body -->
        <div class="p-6 md:p-10 space-y-8 bg-white">

            <!-- Information Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-slate-50 border border-slate-100 p-6 rounded-[28px]">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nama Pembeli</p>
                    <p class="font-extrabold text-base md:text-lg text-[#103370] truncate">{{ $transaction->customer_name ?? 'Nama Pembeli' }}</p>
                    <p class="text-xs text-slate-500 font-medium">{{ $transaction->customer_email ?? '' }}</p>
                </div>

                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Order ID</p>
                    <p class="font-mono font-black text-sm md:text-base text-[#103370] bg-white border border-slate-200 px-3 py-1 rounded-lg inline-block break-all shadow-sm">
                        {{ $transaction->order_id ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Pembayaran</p>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-800 font-black text-xs rounded-full uppercase">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        LUNAS / VALID
                    </span>
                </div>

                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Jumlah Tiket</p>
                    <p class="font-extrabold text-base text-[#103370]">{{ $transaction->quantity ?? 1 }} Tiket (Rp {{ number_format($transaction->total_price ?? 0, 0, ',', '.') }})</p>
                </div>

                @if(!empty($transaction?->attendees) && count($transaction->attendees) > 0)
                <div class="sm:col-span-2 pt-3 border-t border-slate-200/80">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Daftar Pengunjung Tambahan</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($transaction->attendees as $idx => $att)
                            <span class="px-3 py-1 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-full">
                                #${{ $idx + 2 }}: {{ $att['name'] ?? 'Peserta' }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- QR Code Section for Gate Check-in -->
            <div class="bg-slate-50 border-2 border-[#f1f5f9] rounded-[30px] p-6 text-center shadow-inner relative">
                <p class="text-xs font-black text-[#103370] uppercase tracking-widest mb-4 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-[#F24781]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                    Scan QR Code Untuk Access Gate Check-in
                </p>

                <div class="w-48 h-48 bg-white border-2 border-[#f1f5f9] p-3 rounded-[24px] shadow-md mx-auto flex items-center justify-center">
                    @if($transaction && $transaction->order_id)
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($transaction->order_id) }}" 
                             alt="QR Code Tiket" class="w-full h-full object-contain">
                    @else
                        <div class="w-full h-full bg-slate-900 flex flex-wrap p-1">
                            <div class="w-1/4 h-1/4 bg-slate-900"></div>
                            <div class="w-1/4 h-1/4 bg-white"></div>
                            <div class="w-1/4 h-1/4 bg-slate-900"></div>
                            <div class="w-1/4 h-1/4 bg-white"></div>
                            <div class="w-1/4 h-1/4 bg-white"></div>
                            <div class="w-1/4 h-1/4 bg-slate-900"></div>
                            <div class="w-1/4 h-1/4 bg-white"></div>
                            <div class="w-1/4 h-1/4 bg-slate-900"></div>
                            <div class="w-1/4 h-1/4 bg-slate-900"></div>
                            <div class="w-1/4 h-1/4 bg-white"></div>
                            <div class="w-1/4 h-1/4 bg-slate-900"></div>
                            <div class="w-1/4 h-1/4 bg-white"></div>
                            <div class="w-1/4 h-1/4 bg-white"></div>
                            <div class="w-1/4 h-1/4 bg-slate-900"></div>
                            <div class="w-1/4 h-1/4 bg-white"></div>
                            <div class="w-1/4 h-1/4 bg-slate-900"></div>
                        </div>
                    @endif
                </div>

                <div class="mt-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kode Verifikasi Tiket</p>
                    <span class="font-mono font-black text-sm md:text-base text-[#103370] tracking-widest bg-white border border-slate-200 px-5 py-2 rounded-full inline-block shadow-sm">
                        {{ $transaction->order_id ?? 'TKT-001293848' }}
                    </span>
                </div>
            </div>

            <!-- Notice / Instructions -->
            <div class="text-center text-xs text-slate-400 font-medium">
                <p>Harap tunjukkan E-Ticket resmi ini dalam bentuk cetak atau layar HP saat memasuki lokasi acara.</p>
            </div>
        </div>

        <!-- Card Footer Action Buttons (Hidden on Print) -->
        <div class="p-6 md:p-8 bg-slate-50 border-t border-slate-100 no-print space-y-4">
            <button onclick="window.print()"
                class="w-full py-5 px-8 bg-[#103370] text-white hover:bg-[#F24781] font-black text-base md:text-lg rounded-full min-h-[60px] shadow-[0_12px_30px_rgba(16,51,112,0.3)] hover:shadow-[0_15px_35px_rgba(242,71,129,0.4)] transition-all duration-300 transform active:scale-98 flex items-center justify-center gap-3 tracking-wide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span>Cetak / Simpan Sebagai PDF</span>
            </button>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
                <a href="{{ route('history') }}"
                    class="w-full sm:w-auto px-6 py-2.5 bg-white border border-slate-200 text-[#103370] hover:bg-[#103370] hover:text-white font-bold rounded-full transition text-xs text-center shadow-sm">
                    Lihat Riwayat Belanja
                </a>
                <a href="{{ route('home') }}"
                    class="w-full sm:w-auto text-center text-xs font-bold text-slate-500 hover:text-[#103370] transition px-4 py-2">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</main>

<style>
    @media print {
        nav, footer, .no-print {
            display: none !important;
        }
        body {
            background: white !important;
            padding: 0 !important;
        }
        main {
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
    }
</style>
@endsection