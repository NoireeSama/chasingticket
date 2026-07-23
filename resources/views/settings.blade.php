@extends('layouts.app')

@section('content')
<main class="max-w-5xl mx-auto px-6 py-12">
    
    <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <nav class="flex text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 gap-2 items-center">
                <a href="{{ route('home') }}" class="hover:text-[#103370] transition">Jelajahi</a>
                <span>/</span>
                <span class="text-slate-600 font-bold">Pengaturan Akun</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900">Pengaturan Akun</h1>
            <p class="text-sm md:text-base text-slate-500 font-medium mt-1">Kelola rincian profil, foto, dan preferensi keamanan Anda.</p>
        </div>
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-slate-200 text-slate-700 rounded-[40px] text-sm font-semibold shadow-neu-spec border-none-sm border-none border-none hover:bg-[#e0e0e0] transition gap-2 self-start md:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Jelajah
        </a>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-50 text-emerald-800 border border-emerald-100 rounded-[40px] flex items-center gap-3 shadow-neu-spec border-none-sm border-none border-none animate-fade-in">
            <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <p class="font-bold text-sm">Berhasil!</p>
                <p class="text-xs text-emerald-600 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="space-y-6">
            <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] rounded-[40px] border border-white/50 shadow-neu-spec border-none-sm border-none border-none p-6 flex flex-col items-center text-center">
                
                <div class="relative group cursor-pointer mb-5">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-indigo-50 shadow-neu-spec border-none-sm border-none relative bg-slate-100">
                        @if($user->avatar_path)
                            <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar_path) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <img id="avatar-preview" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4f46e5&color=fff&bold=true&size=256" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @endif

                        <div onclick="document.getElementById('avatar-input').click()" class="absolute inset-0 bg-brand-dark/60 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col items-center justify-center text-white text-xs font-semibold gap-1.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Ganti Foto</span>
                        </div>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-slate-800 leading-snug">{{ $user->name }}</h3>
                <p class="text-sm font-medium text-slate-400 mt-0.5">{{ $user->username ? '@' . $user->username : 'Belum membuat username' }}</p>
                
                <div class="mt-4 flex flex-wrap gap-2 justify-center">
                    <span class="px-3 py-1 bg-[#103370]/5 text-[#103370] rounded-full text-xs font-bold uppercase tracking-wider">{{ $user->role }}</span>
                    @if($user->google_id)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e0e0e0] border border-slate-200 text-slate-600 rounded-full text-xs font-bold shadow-neu-spec border-none-sm border-none border-none">
                            <svg class="w-3 h-3 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l3.66-2.85z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                            </svg>
                            Google Link
                        </span>
                    @endif
                </div>

                <div class="w-full border-t border-white/50 mt-6 pt-5 flex justify-between items-center text-xs text-slate-400 font-medium">
                    <span>Bergabung Sejak</span>
                    <span class="font-bold text-slate-600">{{ $user->created_at->format('d M Y') }}</span>
                </div>
            </div>

            <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] rounded-[40px] border border-white/50 shadow-neu-spec border-none-sm border-none border-none p-4 space-y-1">
                <button type="button" onclick="switchTab('profile-tab', this)" id="default-tab-btn" class="w-full flex items-center gap-3.5 px-4 py-3 rounded-[40px] text-left text-sm font-semibold transition active:scale-98">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Informasi Profil</span>
                </button>
                <button type="button" onclick="switchTab('security-tab', this)" class="w-full flex items-center gap-3.5 px-4 py-3 rounded-[40px] text-left text-sm font-semibold transition active:scale-98 text-slate-600 hover:bg-[#e0e0e0]">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>Keamanan & Password</span>
                </button>
            </div>
        </div>

        <div class="lg:col-span-2">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="m-0">
                @csrf
                @method('PUT')

                <input type="file" name="avatar" id="avatar-input" accept="image/*" class="hidden" onchange="previewAvatar(event)">

                <div id="profile-tab" class="tab-content bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] rounded-[40px] border border-white/50 shadow-neu-spec border-none-sm border-none border-none overflow-hidden p-6 md:p-8 space-y-6 animate-fade-in">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Informasi Profil</h2>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-0.5">Perbarui detail personal Anda di platform</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="flex flex-col gap-1.5">
                            <label for="name" class="text-xs font-bold text-slate-700 uppercase tracking-wide">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="px-4 py-3 rounded-[40px] border @error('name') border-rose-400 focus:ring-rose-500 focus:border-rose-500 @else border-slate-200 focus:ring-[#103370] focus:border-[#103370] @enderror bg-[#e0e0e0]/50 text-sm font-semibold transition focus:outline-none focus:ring-2 placeholder:text-slate-400" placeholder="Masukkan nama lengkap Anda">
                            @error('name')
                                <p class="text-xs text-rose-500 font-bold mt-0.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="username" class="text-xs font-bold text-slate-700 uppercase tracking-wide">Username</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 text-sm font-bold text-slate-400">@</span>
                                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="w-full pl-9 pr-4 py-3 rounded-[40px] border @error('username') border-rose-400 focus:ring-rose-500 focus:border-rose-500 @else border-slate-200 focus:ring-[#103370] focus:border-[#103370] @enderror bg-[#e0e0e0]/50 text-sm font-semibold transition focus:outline-none focus:ring-2 placeholder:text-slate-400" placeholder="username_unik">
                            </div>
                            @error('username')
                                <p class="text-xs text-rose-500 font-bold mt-0.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="email" class="text-xs font-bold text-slate-700 uppercase tracking-wide flex items-center gap-1.5">
                                Email
                                @if($user->google_id)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-100 rounded text-[9px] font-bold">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Locked
                                    </span>
                                @endif
                            </label>
                            
                            @if($user->google_id)
                                <input type="email" id="email" value="{{ $user->email }}" class="px-4 py-3 rounded-[40px] border border-slate-200 bg-slate-100 text-slate-500 text-sm font-semibold cursor-not-allowed focus:outline-none" disabled>
                                <p class="text-[10px] text-amber-600 font-semibold mt-0.5">Akun Anda terhubung dengan Google, sehingga email tidak dapat diubah.</p>
                            @else
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="px-4 py-3 rounded-[40px] border @error('email') border-rose-400 focus:ring-rose-500 focus:border-rose-500 @else border-slate-200 focus:ring-[#103370] focus:border-[#103370] @enderror bg-[#e0e0e0]/50 text-sm font-semibold transition focus:outline-none focus:ring-2 placeholder:text-slate-400" placeholder="nama@email.com">
                                @error('email')
                                    <p class="text-xs text-rose-500 font-bold mt-0.5">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="phone" class="text-xs font-bold text-slate-700 uppercase tracking-wide">Nomor Telepon</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="px-4 py-3 rounded-[40px] border @error('phone') border-rose-400 focus:ring-rose-500 focus:border-rose-500 @else border-slate-200 focus:ring-[#103370] focus:border-[#103370] @enderror bg-[#e0e0e0]/50 text-sm font-semibold transition focus:outline-none focus:ring-2 placeholder:text-slate-400" placeholder="081234567890">
                            @error('phone')
                                <p class="text-xs text-rose-500 font-bold mt-0.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="description" class="text-xs font-bold text-slate-700 uppercase tracking-wide">Bio / Deskripsi Diri</label>
                        <textarea name="description" id="description" rows="4" class="px-4 py-3 rounded-[40px] border border-slate-200 bg-[#e0e0e0]/50 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-[#103370] focus:border-[#103370] placeholder:text-slate-400" placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('description', $user->description) }}</textarea>
                        @error('description')
                            <p class="text-xs text-rose-500 font-bold mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div id="security-tab" class="tab-content hidden bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] rounded-[40px] border border-white/50 shadow-neu-spec border-none-sm border-none border-none overflow-hidden p-6 md:p-8 space-y-6 animate-fade-in">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Keamanan & Password</h2>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-0.5">Kelola kata sandi untuk mengamankan akun Anda</p>
                    </div>

                    @if($user->google_id)
                        
                        <div class="border border-white/50 bg-[#e0e0e0]/50 rounded-[40px] p-8 flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-white/50 text-[#103370] rounded-[40px] flex items-center justify-center shadow-neu-spec border-none-sm border-none border-none mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l3.66-2.85z"/>
                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                                </svg>
                            </div>
                            <h4 class="text-base font-bold text-slate-800 mb-1.5">Masuk dengan Google Aktif</h4>
                            <p class="text-xs text-slate-500 font-medium max-w-md mb-2">Akun Anda diautentikasi secara aman melalui Google. Anda tidak memiliki atau membutuhkan password lokal.</p>
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-50 text-amber-700 border border-amber-100 rounded-lg text-[10px] font-bold">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                Password Dinonaktifkan
                            </span>
                        </div>
                    @else
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="flex flex-col gap-1.5">
                                <label for="password" class="text-xs font-bold text-slate-700 uppercase tracking-wide">Kata Sandi Baru</label>
                                <input type="password" name="password" id="password" class="px-4 py-3 rounded-[40px] border @error('password') border-rose-400 focus:ring-rose-500 focus:border-rose-500 @else border-slate-200 focus:ring-[#103370] focus:border-[#103370] @enderror bg-[#e0e0e0]/50 text-sm font-semibold transition focus:outline-none focus:ring-2 placeholder:text-slate-400" placeholder="Minimal 8 karakter">
                                @error('password')
                                    <p class="text-xs text-rose-500 font-bold mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-1.5">
                                <label for="password_confirmation" class="text-xs font-bold text-slate-700 uppercase tracking-wide">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="px-4 py-3 rounded-[40px] border border-slate-200 bg-[#e0e0e0]/50 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-[#103370] focus:border-[#103370] placeholder:text-slate-400" placeholder="Ketik ulang kata sandi">
                            </div>
                        </div>
                        <div class="p-4 bg-[#103370]/5/70 border border-indigo-100 rounded-[40px]">
                            <h5 class="text-xs font-bold text-brand-dark mb-1">Tips Keamanan Password</h5>
                            <ul class="text-[11px] text-[#103370] font-medium space-y-1 list-disc pl-4">
                                <li>Gunakan minimal 8 karakter dengan kombinasi huruf, angka, dan simbol.</li>
                                <li>Jangan gunakan kata sandi yang sama dengan situs web lain.</li>
                                <li>Biarkan bidang kata sandi kosong jika Anda tidak ingin mengubahnya.</li>
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] rounded-[40px] border border-white/50 shadow-neu-spec border-none-sm border-none border-none p-4 mt-6 flex justify-between items-center gap-4">
                    <span class="hidden md:inline text-xs text-slate-400 font-bold uppercase tracking-wider pl-2">Pastikan semua kolom terisi dengan benar</span>
                    <div class="flex gap-3 w-full md:w-auto">
                        <button type="reset" class="w-full md:w-auto px-6 py-3 border border-slate-200 text-slate-600 rounded-[40px] text-sm font-bold hover:bg-[#e0e0e0] transition active:scale-98">
                            Batal
                        </button>
                        <button type="submit" class="w-full md:w-auto px-8 py-3 bg-[#103370] hover:bg-purple-700 text-white rounded-[40px] text-sm font-bold shadow-neu-spec border-none-sm border-none shadow-indigo-150 transition active:scale-98">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</main>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Default Tab style on button
        const defaultBtn = document.getElementById('default-tab-btn');
        if (defaultBtn) {
            defaultBtn.classList.add('bg-[#103370]', 'text-white', 'shadow-neu-spec border-none-sm border-none', 'shadow-[0_15px_35px_rgba(16,51,112,0.3)]/10');
            defaultBtn.classList.remove('text-slate-600', 'hover:bg-[#e0e0e0]');
        }
    });

    function switchTab(tabId, button) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(function(content) {
            content.classList.add('hidden');
        });

        // Show targets
        document.getElementById(tabId).classList.remove('hidden');

        // Reset all buttons styling
        const buttons = button.parentElement.querySelectorAll('button');
        buttons.forEach(function(btn) {
            btn.classList.remove('bg-[#103370]', 'text-white', 'shadow-neu-spec border-none-sm border-none', 'shadow-[0_15px_35px_rgba(16,51,112,0.3)]/10');
            btn.classList.add('text-slate-600', 'hover:bg-[#e0e0e0]');
        });

        // Add active style to selected button
        button.classList.remove('text-slate-600', 'hover:bg-[#e0e0e0]');
        button.classList.add('bg-[#103370]', 'text-white', 'shadow-neu-spec border-none-sm border-none', 'shadow-[0_15px_35px_rgba(16,51,112,0.3)]/10');
    }

    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('avatar-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
