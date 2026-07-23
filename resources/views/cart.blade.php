@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-16">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-[#103370] tracking-tight mb-2">Keranjang Belanja</h1>
        <p class="text-slate-500 font-medium">Tiket event yang sudah Anda masukkan ke keranjang belanja.</p>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-[#b8ff00]/20 text-[#103370] border border-[#b8ff00] rounded-full flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 rounded-full bg-[#103370] text-[#b8ff00] flex items-center justify-center shrink-0 font-black">✓</div>
            <p class="font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    @if($cartItems->isEmpty())
        
        <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[40px] p-12 md:p-16 text-center relative overflow-hidden my-6">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-[#b8ff00]/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-10 -top-10 w-64 h-64 bg-[#F24781]/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <div class="w-20 h-20 bg-[#103370] text-[#b8ff00] rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_15px_30px_rgba(16,51,112,0.25)]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-[#103370] mb-2">Keranjang Belanja Kosong</h3>
                <p class="text-slate-500 max-w-md mx-auto text-sm font-medium mb-8">Anda belum menambahkan tiket event apa pun. Yuk, temukan event seru dan pesan tiket impianmu sekarang!</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-[#F24781] text-white font-bold rounded-full shadow-[0_10px_25px_rgba(242,71,129,0.3)] hover:bg-[#103370] hover:shadow-[0_10px_25px_rgba(16,51,112,0.3)] transition-all">
                    <span>Jelajahi Event Seru</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    @else

        <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] rounded-[40px] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#103370] text-white">
                            <th class="py-5 px-8 text-xs font-black uppercase tracking-wider">Event</th>
                            <th class="py-5 px-6 text-xs font-black uppercase tracking-wider">Jadwal Acara</th>
                            <th class="py-5 px-6 text-xs font-black uppercase tracking-wider">Harga</th>
                            <th class="py-5 px-6 text-xs font-black uppercase tracking-wider text-center">Jumlah</th>
                            <th class="py-5 px-6 text-xs font-black uppercase tracking-wider">Subtotal</th>
                            <th class="py-5 px-8 text-xs font-black uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($cartItems as $item)
                            @if($item->event)
                                @php
                                    $isPassed = $item->event->date->isPast();
                                    $isOutOfStock = $item->event->stock <= 0;
                                    $subtotal = $item->event->price * $item->quantity;
                                @endphp
                                <tr class="hover:bg-slate-50 transition">

                                    <td class="py-6 px-8">
                                        <div class="flex items-center gap-4">
                                            <div class="w-16 h-20 rounded-[20px] overflow-hidden bg-slate-100 flex-shrink-0 relative border-2 border-white shadow-md">
                                                @if($item->event->poster_path)
                                                    <img src="{{ asset('storage/' . $item->event->poster_path) }}" alt="{{ $item->event->title }}" class="w-full h-full object-cover {{ $isPassed || $isOutOfStock ? 'grayscale opacity-60' : '' }}">
                                                @else
                                                    <img src="https://via.placeholder.com/150x200?text={{ urlencode($item->event->title) }}" alt="{{ $item->event->title }}" class="w-full h-full object-cover {{ $isPassed || $isOutOfStock ? 'grayscale opacity-60' : '' }}">
                                                @endif
                                            </div>
                                            <div>
                                                <span class="inline-block px-2.5 py-0.5 bg-[#b8ff00] text-[#103370] rounded-full text-[10px] font-black uppercase tracking-wider mb-1">
                                                    {{ $item->event->category->name ?? 'Event' }}
                                                </span>
                                                <h4 class="font-extrabold text-[#103370] text-base leading-tight hover:text-[#F24781] transition">
                                                    <a href="{{ url('event/' . $item->event->id) }}">{{ $item->event->title }}</a>
                                                </h4>
                                                @if($isPassed)
                                                    <span class="inline-block text-[10px] font-bold text-rose-500 uppercase mt-1">Event Selesai</span>
                                                @elseif($isOutOfStock)
                                                    <span class="inline-block text-[10px] font-bold text-amber-600 uppercase mt-1">Stok Tiket Habis</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-6 px-6 text-sm font-semibold text-slate-600">
                                        {{ \Carbon\Carbon::parse($item->event->date)->format('d-m-Y H:i') }}
                                    </td>

                                    <td class="py-6 px-6 text-sm font-bold text-slate-800">
                                        Rp {{ number_format($item->event->price, 0, ',', '.') }}
                                    </td>

                                    <td class="py-6 px-6 text-sm font-black text-[#103370] text-center">
                                        <span class="inline-block px-3 py-1 bg-slate-100 rounded-full">{{ $item->quantity }}</span>
                                    </td>

                                    <td class="py-6 px-6 text-base font-black text-[#103370]">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </td>

                                    <td class="py-6 px-8 text-right">
                                        <div class="flex items-center justify-end gap-3">

                                            @if($isPassed)
                                                <button type="button" class="px-5 py-2.5 bg-slate-200 text-slate-400 rounded-full font-bold text-xs cursor-not-allowed" disabled>
                                                    Selesai
                                                </button>
                                            @elseif($isOutOfStock)
                                                <button type="button" class="px-5 py-2.5 bg-slate-200 text-slate-400 rounded-full font-bold text-xs cursor-not-allowed" disabled>
                                                    Stok Habis
                                                </button>
                                            @else
                                                @php
                                                    $pendingTrx = $pendingTransactions[$item->event_id] ?? null;
                                                @endphp
                                                @if($pendingTrx)
                                                    <a href="{{ route('checkout.payment', $pendingTrx->order_id) }}" class="px-5 py-2.5 bg-amber-500 text-white rounded-full font-bold text-xs hover:bg-amber-600 shadow-md transition duration-300">
                                                        Pembayaran
                                                    </a>
                                                @else
                                                    <a href="{{ route('checkout.create', $item->event_id) }}" class="px-5 py-2.5 bg-[#F24781] text-white font-bold rounded-full text-xs hover:bg-[#103370] shadow-[0_10px_20px_rgba(242,71,129,0.3)] transition duration-300">
                                                        Bayar Tiket
                                                    </a>
                                                @endif
                                            @endif

                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="inline m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2.5 text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white rounded-full transition duration-300 shadow-sm" title="Hapus dari Keranjang" onclick="return confirm('Apakah Anda yakin ingin menghapus tiket event ini dari keranjang belanja Anda?')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</main>
@endsection
