@extends('layouts.admin')
@section('title', 'Tambah User Baru - Admin')
@section('page_title', 'Tambah User Baru')
@section('page_subtitle', 'Masukkan detail akun pengguna baru ke dalam database.')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#103370] transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span>Kembali ke Daftar Pengguna</span>
    </a>
</div>

<div class="bg-white border-2 border-[#f1f5f9] shadow-[0_20px_50px_rgba(16,51,112,0.06)] rounded-[35px] p-8 md:p-10 max-w-3xl relative overflow-hidden">
    <div class="absolute -right-12 -top-12 w-64 h-64 bg-[#b8ff00]/20 rounded-full blur-3xl pointer-events-none"></div>

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 relative z-10">
        @csrf

        <div>
            <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Foto Profil Avatar (Opsional)</label>
            
            <div class="relative border-2 border-dashed border-slate-200 hover:border-[#103370] bg-slate-50/70 hover:bg-white rounded-[30px] p-6 text-center transition-all cursor-pointer group" onclick="document.getElementById('avatar').click()">
                <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                
                <div id="previewContainer" class="hidden mb-3">
                    <img id="avatarPreview" src="#" alt="Preview Avatar" class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-white shadow-md">
                    <span id="fileName" class="inline-block mt-2 px-3 py-1 bg-[#b8ff00] text-[#103370] rounded-full text-xs font-black"></span>
                </div>

                <div id="uploadPlaceholder" class="space-y-2">
                    <div class="w-14 h-14 bg-[#103370]/10 text-[#103370] group-hover:bg-[#103370] group-hover:text-white rounded-full flex items-center justify-center mx-auto transition duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <p class="font-bold text-slate-700 text-sm">Klik untuk memilih foto profil</p>
                    <p class="text-xs text-slate-400 font-medium">Format: JPG, JPEG, PNG, WEBP (Maks. 2MB)</p>
                </div>
            </div>
            @error('avatar') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800"
                    placeholder="Masukkan nama lengkap..." required>
                @error('name') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Username</label>
                <input type="text" name="username" value="{{ old('username') }}"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800"
                    placeholder="username_unik" required>
                @error('username') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800"
                    placeholder="contoh: user@mail.com" required>
                @error('email') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Peran (Role)</label>
                <select name="role" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-bold text-slate-800 cursor-pointer" required>
                    <option value="">Pilih Peran Akun</option>
                    <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer (Pembeli Tiket)</option>
                    <option value="merchant" {{ old('role') === 'merchant' ? 'selected' : '' }}>Merchant (Penyelenggara Event)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Pengelola Utama)</option>
                </select>
                @error('role') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Kata Sandi</label>
            <input type="password" name="password"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] focus:bg-white outline-none transition font-semibold text-slate-800"
                placeholder="Minimal 8 karakter..." required>
            @error('password') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 flex items-center justify-end gap-4 border-t border-slate-100">
            <a href="{{ route('admin.users.index') }}" class="px-6 py-3.5 text-slate-500 font-bold hover:text-slate-800 transition text-sm">Batal</a>
            <button type="submit" class="px-8 py-4 bg-[#F24781] text-white font-bold rounded-full text-sm shadow-[0_10px_25px_rgba(242,71,129,0.3)] hover:bg-[#103370] hover:shadow-[0_10px_25px_rgba(16,51,112,0.35)] transition duration-300 transform active:scale-98">
                Buat Akun Baru
            </button>
        </div>
    </form>
</div>

<script>
    function previewAvatar(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
                document.getElementById('fileName').textContent = input.files[0].name;
                document.getElementById('previewContainer').classList.remove('hidden');
                document.getElementById('uploadPlaceholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
