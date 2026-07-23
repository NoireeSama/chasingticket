@extends('layouts.app')

@section('title', 'Checkout Tiket - ' . $event->title)

@section('content')
<main class="max-w-4xl mx-auto px-4 sm:px-6 py-10 md:py-16">
    <div class="mb-8">
        <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#103370] transition mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Detail Event</span>
        </a>
        <h1 class="text-3xl md:text-4xl font-black text-[#103370] tracking-tight">Checkout Tiket</h1>
        <p class="text-slate-500 font-medium text-sm md:text-base mt-1">Lengkapi data Anda untuk memesan tiket acara resmi.</p>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border-2 border-rose-200 text-rose-700 rounded-full font-bold text-xs flex items-center gap-3">
            <span class="w-6 h-6 rounded-full bg-rose-600 text-white flex items-center justify-center font-black text-xs shrink-0">!</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('checkout.store', $event) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membeli tiket ini?');" class="space-y-8">
        @csrf
        <input type="hidden" name="qty" id="qtyInput" value="1">
        <div id="hiddenCouponsContainer"></div>

        <div class="grid grid-cols-1 gap-8">

            <!-- Card 1: Summary Pesanan -->
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
                        <img src="{{ $event->poster_path ? asset('storage/' . $event->poster_path) : "data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='500' viewBox='0 0 400 500'%3E%3Crect width='400' height='500' fill='%23f1f5f9'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-weight='bold' font-size='20' fill='%23103370'%3EEvent Poster%3C/text%3E%3C/svg%3E" }}"
                            alt="{{ $event->title }}" class="w-24 h-30 rounded-[20px] object-cover shadow-md border-2 border-white shrink-0">
                        
                        <div class="flex-1">
                            <h4 class="font-extrabold text-[#103370] text-lg md:text-xl mb-1 leading-snug">{{ $event->title }}</h4>
                            <p class="text-xs text-slate-500 font-medium flex items-center gap-1.5 mb-2">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $event->date->format('d M Y, H:i') }} • {{ $event->location }}
                            </p>
                            <span class="inline-block px-3 py-1 bg-[#b8ff00] text-[#103370] rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm mb-3">
                                {{ $event->category->name ?? 'Event' }}
                            </span>
                            <p class="text-[#F24781] font-black text-base md:text-lg">
                                <span id="summaryQtyText">1</span> x Rp {{ number_format($event->current_price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 space-y-3">
                        <div class="flex justify-between text-sm font-semibold text-slate-600">
                            <span>Harga Tiket</span>
                            <span>Rp <span id="summarySubtotalText">{{ number_format($event->current_price, 0, ',', '.') }}</span></span>
                        </div>

                        <div class="flex justify-between text-sm font-semibold text-slate-600">
                            <span>Biaya Layanan</span>
                            <span>Rp {{ number_format($event->price == 0 ? 0 : 5000, 0, ',', '.') }}</span>
                        </div>

                        <div id="couponDiscountsContainer" class="space-y-2"></div>

                        <div class="flex justify-between text-xl md:text-2xl font-black text-[#103370] mt-4 pt-4 border-t border-slate-100">
                            <span>Total Bayar</span>
                            <span class="text-[#F24781]">Rp <span id="summaryTotalText">{{ number_format(($event->price == 0 ? 0 : $event->current_price + 5000), 0, ',', '.') }}</span></span>
                        </div>

                        @if($event->price > 0)
                        <div class="mt-6 pt-6 border-t border-slate-100 space-y-3">
                            <label class="block text-xs font-black text-[#103370] uppercase tracking-wider">Punya Kode Kupon Promosi?</label>
                            <div class="relative flex items-center">
                                <input type="text" id="couponInput" placeholder="MASUKKAN KODE KUPON" class="w-full pl-5 pr-14 py-3.5 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none uppercase font-extrabold text-sm text-[#103370] tracking-wider transition">
                                <button type="button" id="applyCouponBtn" class="absolute right-1.5 w-10 h-10 bg-[#103370] hover:bg-[#F24781] text-white rounded-full flex items-center justify-center transition-all duration-200 shadow-md" title="Gunakan Kupon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                            <div id="appliedCouponsContainer" class="space-y-2 mt-2"></div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card 2: Data Pemesan -->
            <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[35px] p-6 md:p-10 relative overflow-hidden">
                <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-[#F24781]/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 flex-wrap gap-2">
                        <h3 class="text-xl font-black text-[#103370] flex items-center gap-2">
                            <span>📦 Data Pemesan</span>
                        </h3>
                        @if(Auth::check())
                            <span class="px-3 py-1 bg-[#103370] text-[#b8ff00] rounded-full text-xs font-black uppercase tracking-wider shadow-sm">
                                Terhubung Akun ({{ Auth::user()->name }})
                            </span>
                        @else
                            <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-xs font-black uppercase tracking-wider">
                                Tanpa Login
                            </span>
                        @endif
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Nama Lengkap</label>
                            <input type="text" name="customer_name" placeholder="Masukkan nama sesuai identitas"
                                value="{{ old('customer_name', Auth::check() ? Auth::user()->name : '') }}"
                                class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800"
                                required>
                            @error('customer_name')
                            <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Email Aktif</label>
                                <input type="email" name="customer_email" placeholder="contoh@gmail.com"
                                    value="{{ old('customer_email', Auth::check() ? Auth::user()->email : '') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800"
                                    required>
                                <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-wider">*E-Ticket akan dikirimkan ke alamat email ini</p>
                                @error('customer_email')
                                <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">No. WhatsApp</label>
                                <input type="tel" name="customer_phone" placeholder="08xxxxxxxx"
                                    value="{{ old('customer_phone', Auth::check() ? Auth::user()->phone : '') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800"
                                    required>
                                @error('customer_phone')
                                <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div id="additionalAttendeesContainer" class="space-y-6"></div>

                    @if($event->price > 0)
                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <button type="button" id="addAttendeeBtn" class="inline-flex items-center gap-2 px-6 py-3.5 bg-[#103370]/10 text-[#103370] hover:bg-[#103370] hover:text-white rounded-full font-bold text-xs transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Tambah Tiket Pengunjung</span>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-4 pt-2">
            <button type="submit"
                class="w-full py-4.5 bg-[#103370] text-white font-extrabold text-lg md:text-xl rounded-full shadow-[0_10px_25px_rgba(16,51,112,0.25)] hover:bg-[#F24781] hover:shadow-[0_10px_25px_rgba(242,71,129,0.35)] transition-all duration-300 transform active:scale-98 flex items-center justify-center gap-3">
                <span>Lanjut Pembayaran</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>
            <p class="text-center text-xs text-slate-400 font-semibold">Dengan menekan tombol di atas, Anda menyetujui Syarat & Ketentuan layanan ChasingTicket.</p>
        </div>
    </form>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ticketPrice = {{ $event->current_price }};
        const basePrice = {{ $event->price }};
        const maxStock = {{ $event->stock }};
        const maxAllowed = Math.min(5, maxStock);
        const serviceFee = basePrice === 0 ? 0 : 5000;

        let currentQty = 1;
        let blockCount = 1;
        let appliedCoupons = [];

        const qtyInput = document.getElementById('qtyInput');
        const additionalContainer = document.getElementById('additionalAttendeesContainer');
        const addBtn = document.getElementById('addAttendeeBtn');
        const couponInput = document.getElementById('couponInput');
        const applyCouponBtn = document.getElementById('applyCouponBtn');
        const appliedCouponsContainer = document.getElementById('appliedCouponsContainer');
        const couponDiscountsContainer = document.getElementById('couponDiscountsContainer');

        if (couponInput) {
            couponInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        }

        function formatRupiah(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function updatePricing() {
            const subtotal = ticketPrice * currentQty;

            let totalDiscount = 0;
            let discountsHtml = '';
            let badgesHtml = '';
            let hiddenHtml = '';

            appliedCoupons.forEach(c => {
                let disc = 0;
                if (c.type === 'percent') {
                    disc = Math.floor(subtotal * (c.value / 100));
                } else {
                    disc = c.value;
                }
                totalDiscount += disc;

                discountsHtml += `
                    <div class="flex justify-between text-rose-600 font-bold text-sm">
                        <span>Kupon ${c.code} (${c.value}%)</span>
                        <span>- Rp ${formatRupiah(disc)}</span>
                    </div>
                `;

                badgesHtml += `
                    <div class="flex justify-between items-center bg-[#b8ff00]/30 border border-[#b8ff00] px-4 py-2.5 rounded-full text-xs font-bold text-[#103370] shadow-sm">
                        <span>Kupon Terpakai: <strong>${c.code}</strong> (${c.value}%)</span>
                        <button type="button" onclick="removeCoupon('${c.code}')" class="text-rose-600 font-black hover:underline transition">Hapus</button>
                    </div>
                `;

                hiddenHtml += `<input type="hidden" name="coupons[]" value="${c.code}">`;
            });

            const total = Math.max(0, subtotal + serviceFee - totalDiscount);

            if (qtyInput) qtyInput.value = currentQty;
            const summaryQtyText = document.getElementById('summaryQtyText');
            const summarySubtotalText = document.getElementById('summarySubtotalText');
            const summaryTotalText = document.getElementById('summaryTotalText');

            if (summaryQtyText) summaryQtyText.textContent = currentQty;
            if (summarySubtotalText) summarySubtotalText.textContent = formatRupiah(subtotal);
            if (summaryTotalText) summaryTotalText.textContent = formatRupiah(total);

            if (couponDiscountsContainer) couponDiscountsContainer.innerHTML = discountsHtml;
            if (appliedCouponsContainer) appliedCouponsContainer.innerHTML = badgesHtml;
            const hiddenContainer = document.getElementById('hiddenCouponsContainer');
            if (hiddenContainer) hiddenContainer.innerHTML = hiddenHtml;

            if (addBtn) {
                if (currentQty >= maxAllowed) {
                    addBtn.disabled = true;
                    addBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    addBtn.disabled = false;
                    addBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        if (applyCouponBtn) {
            applyCouponBtn.addEventListener('click', function() {
                const code = couponInput.value.trim().toUpperCase();
                if (!code) {
                    alert('Silakan masukkan kode kupon terlebih dahulu.');
                    return;
                }
                if (appliedCoupons.length >= 2) {
                    alert('Maksimal 2 kupon yang dapat digunakan.');
                    return;
                }
                if (appliedCoupons.some(c => c.code === code)) {
                    alert('Kupon tersebut sudah terpakai.');
                    return;
                }

                fetch("{{ route('checkout.validateCoupon') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        code: code,
                        event_id: {{ $event->id }}
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        appliedCoupons.push({
                            code: data.code,
                            type: data.type,
                            value: data.value
                        });
                        couponInput.value = '';
                        updatePricing();
                    } else {
                        alert(data.message || 'Gagal memproses kupon.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memvalidasi kupon.');
                });
            });
        }

        window.removeCoupon = function(code) {
            appliedCoupons = appliedCoupons.filter(c => c.code !== code);
            updatePricing();
        };

        if (addBtn) {
            addBtn.addEventListener('click', function() {
                if (currentQty >= maxAllowed) return;

                blockCount++;
                currentQty++;

                const template = `
                    <div class="attendee-form-block border-t border-slate-100 pt-6 mt-6 relative" id="attendee-block-${blockCount}">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-black text-[#103370] text-xs uppercase tracking-wider flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-[#103370] text-[#b8ff00] flex items-center justify-center font-black text-xs">#${currentQty}</span>
                                Data Pengunjung #${currentQty}
                            </h4>
                            <button type="button" onclick="removeAttendee(${blockCount})" class="text-xs font-extrabold text-rose-600 hover:text-rose-800 transition">Hapus</button>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Nama Lengkap</label>
                                <input type="text" name="attendee_names[]" placeholder="Masukkan nama pengunjung sesuai identitas" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800" required>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Email Aktif</label>
                                    <input type="email" name="attendee_emails[]" placeholder="contoh@gmail.com" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">No. WhatsApp</label>
                                    <input type="tel" name="attendee_phones[]" placeholder="08xxxxxxxx" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800" required>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                additionalContainer.insertAdjacentHTML('beforeend', template);
                updatePricing();
            });
        }

        window.removeAttendee = function(id) {
            const block = document.getElementById(`attendee-block-${id}`);
            if (block) {
                block.remove();
                currentQty--;

                const blocks = additionalContainer.querySelectorAll('.attendee-form-block');
                blocks.forEach((el, index) => {
                    const header = el.querySelector('h4');
                    if (header) {
                        header.innerHTML = `<span class="w-6 h-6 rounded-full bg-[#103370] text-[#b8ff00] flex items-center justify-center font-black text-xs">#${index + 2}</span> Data Pengunjung #${index + 2}`;
                    }
                });

                updatePricing();
            }
        };

        updatePricing();
    });
</script>
@endsection
