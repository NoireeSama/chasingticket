@extends('layouts.admin')
@section('title', 'Edit Partner - Admin')
@section('page_title', 'Edit Partner')
@section('page_subtitle', 'Ubah detail mitra bisnis.')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.partners.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#103370] transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span>Kembali ke Daftar Partner</span>
    </a>
</div>

<div class="bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[35px] p-8 md:p-10 max-w-3xl relative overflow-hidden">
    <div class="absolute -right-12 -top-12 w-64 h-64 bg-[#b8ff00]/20 rounded-full blur-3xl pointer-events-none"></div>

    <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 relative z-10">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Nama Partner</label>
            <input type="text" name="name" value="{{ old('name', $partner->name) }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800" placeholder="Contoh: Perusahaan ABC" required>
            @error('name') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Ganti Berkas Logo Partner</label>
            
            <div class="relative border-2 border-dashed border-slate-200 hover:border-[#103370] bg-slate-50/70 hover:bg-white rounded-[30px] p-6 text-center transition-all cursor-pointer group" onclick="document.getElementById('logo_file').click()">
                <input type="file" id="logo_file" name="logo_file" accept="image/*" class="hidden" onchange="previewLogo(event)">
                
                <div id="previewContainer" class="mb-3">
                    <img id="logoPreview" src="{{ $partner->url_Logo }}" alt="{{ $partner->name }}" class="w-32 h-32 object-contain mx-auto rounded-[20px] border-2 border-[#f1f5f9] p-2 bg-white shadow-md">
                    <span id="fileName" class="inline-block mt-2 px-3 py-1 bg-[#103370] text-[#b8ff00] rounded-full text-xs font-black">Logo Saat Ini</span>
                </div>

                <div id="uploadPlaceholder" class="space-y-1 mt-2">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-[#f1f5f9] rounded-full text-xs font-bold text-[#103370] shadow-sm group-hover:bg-[#103370] group-hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Pilih Berkas Logo Baru</span>
                    </div>
                    <p class="text-xs text-slate-400 font-medium">Format: PNG, JPG, JPEG, WEBP, SVG (Maks. 2MB)</p>
                </div>
            </div>
            @error('logo_file') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="pt-2 border-t border-slate-100">
            <div class="flex items-center gap-2 mb-2">
                <span class="text-xs font-black text-[#103370] uppercase tracking-wider">Atau Gunakan URL Gambar Logo</span>
                <span class="text-[10px] bg-slate-100 text-slate-500 font-bold px-2 py-0.5 rounded-full">Opsional</span>
            </div>
            <input type="url" name="url_Logo" value="{{ old('url_Logo', $partner->url_Logo) }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800 text-sm" placeholder="https://example.com/logo.png">
            @error('url_Logo') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 flex items-center justify-end gap-4 border-t border-slate-100">
            <a href="{{ route('admin.partners.index') }}" class="px-6 py-3.5 text-slate-500 font-bold hover:text-slate-800 transition text-sm">Batal</a>
            <button type="submit" class="px-8 py-4 bg-[#F24781] text-white font-bold rounded-full text-sm shadow-[0_10px_25px_rgba(242,71,129,0.3)] hover:bg-[#103370] hover:shadow-[0_10px_25px_rgba(16,51,112,0.35)] transition duration-300 transform active:scale-98">
                Perbarui Partner
            </button>
        </div>
    </form>
</div>

<script>
    function previewLogo(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logoPreview').src = e.target.result;
                document.getElementById('fileName').textContent = 'Logo Baru: ' + input.files[0].name;
                document.getElementById('fileName').className = 'inline-block mt-2 px-3 py-1 bg-[#b8ff00] text-[#103370] rounded-full text-xs font-black';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
