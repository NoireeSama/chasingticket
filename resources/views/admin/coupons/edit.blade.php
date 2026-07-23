@extends('layouts.admin')

@section('title', 'Edit Kupon - Admin')
@section('page_title', 'Edit Kupon')
@section('page_subtitle', 'Perbarui detail kupon promosi Anda.')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.coupons.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#103370] transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span>Kembali ke Daftar Kupon</span>
    </a>
</div>

<div class="bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[35px] p-8 md:p-10 max-w-2xl relative overflow-hidden">
    <div class="absolute -right-12 -top-12 w-64 h-64 bg-[#b8ff00]/20 rounded-full blur-3xl pointer-events-none"></div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border-2 border-rose-200 text-rose-700 rounded-[25px] font-bold text-xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" class="space-y-6 relative z-10">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Kode Kupon</label>
            <input type="text" name="code" id="code" placeholder="CONTOH: PROMO77" value="{{ old('code', $coupon->code) }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-black tracking-widest uppercase text-slate-800" required>
            <p class="text-xs text-slate-400 mt-2 font-medium">Gunakan huruf kapital tanpa spasi.</p>
            @error('code') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Potongan Persen (%)</label>
            <input type="number" name="value" placeholder="Contoh: 10" min="1" max="100" value="{{ old('value', $coupon->value) }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800" required>
            @error('value') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Tanggal Berlaku s.d. (Kedaluwarsa)</label>
            <input type="date" name="expires_at" value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '') }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800">
            <p class="text-xs text-slate-400 mt-2 font-medium">Kosongkan jika kupon berlaku selamanya.</p>
            @error('expires_at') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Batasan Kuota Penggunaan</label>
            <select name="is_limited" id="is_limited" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-bold text-slate-800 cursor-pointer" required>
                <option value="0" {{ old('is_limited', $coupon->is_limited ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak Terbatas (Tanpa Kuota Penggunaan)</option>
                <option value="1" {{ old('is_limited', $coupon->is_limited ? '1' : '0') == '1' ? 'selected' : '' }}>Terbatas (Berdasarkan Maksimal Penggunaan)</option>
            </select>
            @error('is_limited') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div id="limit_count_container" class="{{ old('is_limited', $coupon->is_limited ? '1' : '0') == '1' ? '' : 'hidden' }}">
            <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Jumlah Kuota Kupon</label>
            <input type="number" name="limit_count" id="limit_count" placeholder="Masukkan jumlah maksimal penggunaan" value="{{ old('limit_count', $coupon->limit_count) }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800">
            @error('limit_count') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 flex items-center justify-end gap-4 border-t border-slate-100">
            <a href="{{ route('admin.coupons.index') }}" class="px-6 py-3.5 text-slate-500 font-bold hover:text-slate-800 transition text-sm">Batal</a>
            <button type="submit" class="px-8 py-4 bg-[#103370] text-white font-bold rounded-full text-sm shadow-[0_10px_25px_rgba(16,51,112,0.3)] hover:bg-[#F24781] hover:shadow-[0_10px_25px_rgba(242,71,129,0.35)] transition duration-300 transform active:scale-98">
                Perbarui Kupon
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const codeInput = document.getElementById('code');
        const isLimitedSelect = document.getElementById('is_limited');
        const limitCountContainer = document.getElementById('limit_count_container');
        const limitCountInput = document.getElementById('limit_count');

        codeInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/\s+/g, '');
        });

        isLimitedSelect.addEventListener('change', function() {
            if (this.value === '1') {
                limitCountContainer.classList.remove('hidden');
                limitCountInput.required = true;
            } else {
                limitCountContainer.classList.add('hidden');
                limitCountInput.required = false;
            }
        });
    });
</script>
@endsection
