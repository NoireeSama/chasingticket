@extends('layouts.admin')

@section('title', 'Kelola Kupon - Admin')

@section('page_title', 'Kelola Kupon')
@section('page_subtitle', 'Buat dan atur kupon promosi merchant Anda.')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.coupons.create') }}" class="px-6 py-3 bg-[#103370] hover:bg-[#F24781] text-white rounded-full font-bold text-sm transition shadow-[0_10px_20px_rgba(16,51,112,0.25)] hover:shadow-[0_10px_20px_rgba(242,71,129,0.35)] flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Kupon
    </a>
</div>

<div class="bg-white rounded-[35px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#103370] text-white uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Kode Kupon</th>
                    @if(auth()->user()->role === 'admin')
                        <th class="px-8 py-4">Pembuat</th>
                    @endif
                    <th class="px-8 py-4">Potongan</th>
                    <th class="px-8 py-4">Tipe Kuota</th>
                    <th class="px-8 py-4">Penggunaan</th>
                    <th class="px-8 py-4">Tanggal Berlaku</th>
                    <th class="px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($coupons as $coupon)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-8 py-6">
                        <span class="font-mono font-black text-[#103370] bg-[#b8ff00] px-3.5 py-1.5 rounded-full text-sm tracking-wider shadow-sm inline-block">{{ $coupon->code }}</span>
                    </td>
                    @if(auth()->user()->role === 'admin')
                        <td class="px-8 py-6 font-bold text-[#103370]">
                            {{ $coupon->user->name ?? 'System' }}
                            <span class="text-xs font-normal text-slate-400 capitalize">({{ $coupon->user->role ?? 'N/A' }})</span>
                        </td>
                    @endif
                    <td class="px-8 py-6 font-black text-[#F24781] text-base">
                        {{ $coupon->value }}%
                    </td>
                    <td class="px-8 py-6">
                        @if($coupon->is_limited)
                            <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-[10px] font-black uppercase tracking-wider">Terbatas</span>
                        @else
                            <span class="px-3 py-1 bg-[#b8ff00] text-[#103370] rounded-full text-[10px] font-black uppercase tracking-wider">Tak Terbatas</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-sm text-slate-500 font-medium">
                        @if($coupon->is_limited)
                            <span class="font-bold text-[#103370]">{{ $coupon->used_count }}</span> / {{ $coupon->limit_count }} terpakai
                        @else
                            <span class="font-bold text-[#103370]">{{ $coupon->used_count }}</span> kali digunakan
                        @endif
                    </td>
                    <td class="px-8 py-6 text-sm text-slate-500 font-medium">
                        @if($coupon->expires_at)
                            @if($coupon->expires_at->isPast())
                                <span class="text-[#F24781] font-bold">Kedaluwarsa ({{ $coupon->expires_at->format('d M Y') }})</span>
                            @else
                                s.d. {{ $coupon->expires_at->format('d M Y') }}
                            @endif
                        @else
                            <span class="text-slate-400 font-bold">Selamanya</span>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="p-2.5 bg-[#103370]/10 text-[#103370] rounded-full hover:bg-[#103370] hover:text-white transition shadow-sm" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kupon ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-full hover:bg-rose-600 hover:text-white transition shadow-sm" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}" class="px-8 py-10 text-center text-slate-400 font-medium">Belum ada kupon yang dibuat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
