@extends('layouts.app')

@section('title', 'Selesaikan Pembayaran - ' . $transaction->event->title)

@section('content')
<main class="max-w-xl mx-auto px-4 py-12 md:py-20 text-center">
    <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[40px] p-8 md:p-12 relative overflow-hidden text-center w-full">
        <!-- Decorative Glow Blobs -->
        <div class="absolute -right-16 -top-16 w-72 h-72 bg-[#b8ff00]/25 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-72 h-72 bg-[#F24781]/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10">
            <!-- Icon -->
            <div class="w-20 h-20 bg-[#103370] text-[#b8ff00] rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_15px_30px_rgba(16,51,112,0.25)]">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>

            <h2 class="text-2xl md:text-3xl font-black text-[#103370] mb-2 tracking-tight">Selesaikan Pembayaran</h2>
            <p class="text-slate-500 font-medium text-sm md:text-base mb-8">Mohon selesaikan pembayaran tiket Anda untuk event <strong class="text-[#103370]">{{ $transaction->event->title }}</strong>.</p>

            @if(strtolower($transaction->status) === 'pending')
                <div class="bg-slate-50 border-2 border-[#f1f5f9] rounded-[30px] p-6 mb-8 text-center shadow-inner relative z-10">
                    <p class="text-xs text-slate-400 font-black uppercase tracking-widest mb-1">Total Tagihan</p>
                    <h3 class="text-3xl md:text-4xl font-black text-[#F24781] tracking-tight">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</h3>
                    <span class="inline-block mt-3 px-4 py-1.5 bg-[#103370]/10 text-[#103370] font-mono font-black text-xs rounded-full uppercase tracking-wider shadow-sm">
                        Order ID: {{ $transaction->order_id }}
                    </span>

                    <div id="countdown-wrapper" class="mt-4 pt-4 border-t border-slate-200/80 flex items-center justify-center gap-2 text-xs md:text-sm font-extrabold text-slate-600">
                        <svg class="w-4 h-4 text-amber-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Sisa Waktu Pembayaran: <span id="timer" class="text-rose-600 font-mono font-black text-sm px-2.5 py-0.5 bg-rose-50 border border-rose-200 rounded-full">02:00</span></span>
                    </div>
                </div>

                <button id="pay-button" class="w-full py-4.5 bg-[#103370] text-white font-extrabold text-lg md:text-xl rounded-full shadow-[0_10px_25px_rgba(16,51,112,0.25)] hover:bg-[#F24781] hover:shadow-[0_10px_25px_rgba(242,71,129,0.35)] transition-all duration-300 transform active:scale-98 flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Bayar Sekarang</span>
                </button>
            @else
                <div class="p-6 bg-rose-50 rounded-[30px] border-2 border-rose-200 mb-8 text-center animate-fade-in">
                    <div class="w-14 h-14 bg-rose-600 text-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-md">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-black text-rose-800">Pemesanan Kedaluwarsa</h3>
                    <p class="text-xs text-rose-600 font-semibold mt-1">Waktu pembayaran 2 menit telah habis. Reservasi tiket Anda dibatalkan dan stok dikembalikan.</p>
                </div>
                <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center gap-2 w-full py-4.5 bg-[#103370] text-white hover:bg-[#F24781] font-extrabold text-sm md:text-base rounded-full transition-all duration-300 shadow-md">
                    <span>Kembali ke Keranjang Belanja</span>
                </a>
            @endif
        </div>
    </div>
</main>

@if(strtolower($transaction->status) === 'pending')
    @if(config('midtrans.is_production'))
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif
    
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            snap.pay('{{ $transaction->snap_token }}', {
                onSuccess: function(result){
                    window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
                },
                onPending: function(result){
                    window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
                },
                onError: function(result){
                    alert("Pembayaran Gagal!");
                }
            });
        };

        // JS Expiration Countdown
        const expireTime = {{ $transaction->created_at->timestamp * 1000 }} + (2 * 60 * 1000);

        function updateTimer() {
            const now = new Date().getTime();
            const diff = expireTime - now;

            if (diff <= 0) {
                clearInterval(timerInterval);
                document.getElementById('timer').innerText = "00:00";
                
                // Trigger backend cancellation & stock release
                fetch("{{ route('checkout.expire', $transaction->order_id) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert("Waktu pembayaran telah habis! Reservasi tiket Anda dibatalkan.");
                    window.location.reload();
                })
                .catch(error => {
                    window.location.reload();
                });
                return;
            }

            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            const minStr = String(minutes).padStart(2, '0');
            const secStr = String(seconds).padStart(2, '0');

            document.getElementById('timer').innerText = `${minStr}:${secStr}`;
        }

        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer();

        window.onload = function() {
            const payBtn = document.getElementById('pay-button');
            if (payBtn) {
                payBtn.click();
            }
        }
    </script>
@endif
@endsection
