@extends('layouts.admin')

@section('title', 'Laporan Transaksi - Admin')

@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Pantau arus kas dan penjualan tiket Anda.')

@section('content')
<div class="bg-white rounded-[35px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#103370] text-white uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Order ID</th>
                    <th class="px-8 py-4">Detail Pembeli</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Tgl Transaksi</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4 text-right">Total Tagihan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($transactions as $Strx)
                <tr class="hover:bg-slate-50 transition {{ $Strx->status == 'pending' ? 'text-slate-400' : '' }}">
                    <td class="px-8 py-6">
                        <span class="font-mono font-bold px-3.5 py-1.5 bg-[#103370]/5 text-[#103370] rounded-full text-xs inline-block">{{ $Strx->order_id }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-[#103370] text-sm mb-0.5">{{ $Strx->customer_name }}</p>
                        <p class="text-xs text-slate-400 font-medium">{{ $Strx->customer_email }}<br>{{ $Strx->customer_phone }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-extrabold text-slate-800 text-sm">{{ $Strx->event->title ?? '-' }}</p>
                    </td>
                    <td class="px-8 py-6 text-sm text-slate-500 font-medium">
                        {{ $Strx->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-8 py-6">
                        @if($Strx->status === 'settlement' || $Strx->status === 'success')
                            <span class="px-3 py-1 bg-[#b8ff00] text-[#103370] rounded-full text-[10px] font-black uppercase tracking-wider">Success</span>
                        @elseif($Strx->status === 'pending')
                            <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-[10px] font-black uppercase tracking-wider">Pending</span>
                        @else
                            <span class="px-3 py-1 bg-[#F24781]/10 text-[#F24781] rounded-full text-[10px] font-black uppercase tracking-wider">{{ $Strx->status }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right font-black text-[#103370] text-base">
                        Rp {{ number_format($Strx->total_price, 0, ',', '.') }}
                        @if($Strx->discount_amount > 0)
                            <div class="text-[10px] text-[#F24781] font-bold mt-0.5">
                                Diskon: -Rp {{ number_format($Strx->discount_amount, 0, ',', '.') }}
                                @if($Strx->coupons_used)
                                    ({{ implode(', ', array_column($Strx->coupons_used, 'code')) }})
                                @endif
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-slate-400 font-medium">
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
