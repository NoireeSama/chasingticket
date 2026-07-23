@extends('layouts.app')

@section('title', 'Checkout Demo - ChasingTicket')

@section('content')
<main class="max-w-4xl mx-auto px-4 sm:px-6 py-10 md:py-16">
    <div class="mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#103370] transition mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Event</span>
        </a>
        <h1 class="text-3xl md:text-4xl font-black text-[#103370] tracking-tight">Checkout</h1>
        <p class="text-slate-500 font-medium text-sm md:text-base mt-1">Lengkapi data Anda untuk mendapatkan tiket.</p>
    </div>

    <div class="grid grid-cols-1 gap-8">
        <!-- Order Summary Card -->
        <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[35px] p-6 md:p-10 relative overflow-hidden">
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-[#b8ff00]/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <h3 class="text-xl font-black text-[#103370] mb-6 pb-4 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#F24781]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2 2 2 0 010 4 2 2 0 00-2 2v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 00-2-2 2 2 0 010-4 2 2 0 002-2V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                    Pesanan Anda
                </h3>
                <div class="flex flex-col sm:flex-row gap-6 items-start">
                    <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=400" alt="Event" class="w-24 h-30 rounded-[20px] object-cover shadow-md border-2 border-white shrink-0">
                    <div class="flex-1">
                        <h4 class="font-extrabold text-[#103370] text-lg md:text-xl mb-1">Jazz Night 2026: A Celebration</h4>
                        <p class="text-xs text-slate-500 font-medium mb-2">16 Nov 2026 • The Blue Note Lounge</p>
                        <span class="inline-block px-3 py-1 bg-[#b8ff00] text-[#103370] rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm mb-3">Musik</span>
                        <p class="text-[#F24781] font-black text-base md:text-lg">1 x Rp 150.000</p>
                    </div>
                </div>
                <div class="mt-8 pt-6 border-t border-slate-100 space-y-3">
                    <div class="flex justify-between text-sm font-semibold text-slate-600">
                        <span>Harga Tiket</span>
                        <span>Rp 150.000</span>
                    </div>
                    <div class="flex justify-between text-sm font-semibold text-slate-600">
                        <span>Biaya Layanan</span>
                        <span>Rp 5.000</span>
                    </div>
                    <div class="flex justify-between text-xl md:text-2xl font-black text-[#103370] mt-4 pt-4 border-t border-slate-100">
                        <span>Total Bayar</span>
                        <span class="text-[#F24781]">Rp 155.000</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Details Card -->
        <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[35px] p-6 md:p-10 relative overflow-hidden">
            <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-[#F24781]/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <h3 class="text-xl font-black text-[#103370] mb-6 pb-4 border-b border-slate-100 flex items-center gap-2">
                    <span>📦 Data Pemesan</span>
                </h3>
                <form class="space-y-6">
                    <div>
                        <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" placeholder="Masukkan nama sesuai identitas"
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800"
                            required>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Email Aktif</label>
                            <input type="email" placeholder="contoh@gmail.com"
                                class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800"
                                required>
                            <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-wider">*E-Ticket akan dikirim ke email ini</p>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">No. WhatsApp</label>
                            <input type="tel" placeholder="08xxxxxxxx"
                                class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800"
                                required>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-4.5 bg-[#103370] text-white font-extrabold text-lg md:text-xl rounded-full shadow-[0_10px_25px_rgba(16,51,112,0.25)] hover:bg-[#F24781] hover:shadow-[0_10px_25px_rgba(242,71,129,0.35)] transition-all duration-300 transform active:scale-98 flex items-center justify-center gap-3">
                        <span>Bayar Sekarang</span>
                    </button>
                    <p class="text-center text-xs text-slate-400 font-semibold">Dengan menekan tombol di atas, Anda menyetujui Syarat & Ketentuan layanan ChasingTicket.</p>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection