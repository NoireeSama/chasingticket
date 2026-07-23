@extends('layouts.admin')

@section('title', 'Profil Saya - Admin')

@section('page_title', 'Profil Saya')
@section('page_subtitle', 'Atur profil merchant dan akun Anda.')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 text-green-700 border border-green-200 rounded-[30px] font-bold text-sm">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-[30px] font-bold text-sm">
    <ul class="list-disc list-inside">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="space-y-6">
            <div class="bg-white rounded-[30px] border-2 border-[#f1f5f9] p-8 shadow-[0_15px_35px_rgba(0,0,0,0.04)]    text-center">
                <h3 class="text-lg font-bold text-slate-800 mb-6 uppercase tracking-wider">Foto Profil</h3>

                <div class="flex flex-col items-center gap-4">
                    @if($user->avatar_path)
                        <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar_path) }}" alt="Avatar" class="w-32 h-32 rounded-full object-cover border-4 border-indigo-50 shadow-[0_15px_35px_rgba(0,0,0,0.04)]  ">
                    @else
                        <div id="avatar-placeholder" class="w-32 h-32 bg-[#103370]/10 rounded-full flex items-center justify-center text-brand-dark font-bold text-4xl border-4 border-indigo-50 shadow-[0_15px_35px_rgba(0,0,0,0.04)]  ">
                            {{ substr($user->name, 0, 2) }}
                        </div>
                        <img id="avatar-preview" class="w-32 h-32 rounded-full object-cover border-4 border-indigo-50 shadow-[0_15px_35px_rgba(0,0,0,0.04)]   hidden" alt="Preview">
                    @endif

                    <label class="mt-4 px-6 py-2.5 bg-[#103370]/10 hover:bg-[#103370]/10 text-[#103370] rounded-[30px] font-bold text-xs cursor-pointer transition">
                        Pilih Foto Baru
                        <input type="file" name="avatar" id="avatar-input" accept="image/*" class="hidden">
                    </label>
                    <p class="text-[10px] text-slate-400 font-medium">JPEG, PNG, JPG, GIF max 2MB.</p>
                </div>
            </div>

            <div class="bg-white rounded-[30px] border-2 border-[#f1f5f9] p-8 shadow-[0_15px_35px_rgba(0,0,0,0.04)]   ">
                <h3 class="text-lg font-bold text-slate-800 mb-4 uppercase tracking-wider">Deskripsi Merchant</h3>
                <textarea name="description" rows="5" placeholder="Tuliskan deskripsi singkat mengenai merchant Anda di sini..." class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-[30px] focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] outline-none transition font-medium text-sm">{{ old('description', $user->description) }}</textarea>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[30px] border-2 border-[#f1f5f9] p-8 shadow-[0_15px_35px_rgba(0,0,0,0.04)]   ">
                <h3 class="text-lg font-bold text-slate-800 mb-6 uppercase tracking-wider">Informasi Akun</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Nama Merchant / Pengguna</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-[30px] focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] outline-none transition font-medium text-sm" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Username</label>
                        <input type="text" value="{{ $user->username }}" class="w-full px-5 py-4 bg-slate-100 border-2 border-slate-150 rounded-[30px] outline-none font-medium text-sm text-slate-500 cursor-not-allowed" readonly>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Email</label>
                        <input type="email" value="{{ $user->email }}" class="w-full px-5 py-4 bg-slate-100 border-2 border-slate-150 rounded-[30px] outline-none font-medium text-sm text-slate-500 cursor-not-allowed" readonly>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Nomor Telepon</label>
                        <input type="text" value="{{ $user->phone }}" class="w-full px-5 py-4 bg-slate-100 border-2 border-slate-150 rounded-[30px] outline-none font-medium text-sm text-slate-500 cursor-not-allowed" readonly>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[30px] border-2 border-[#f1f5f9] p-8 shadow-[0_15px_35px_rgba(0,0,0,0.04)]   ">
                <h3 class="text-lg font-bold text-slate-800 mb-4 uppercase tracking-wider">Ubah Password</h3>
                <p class="text-xs text-slate-400 mb-6 font-medium">Kosongkan jika Anda tidak ingin mengubah password.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Password Baru</label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-[30px] focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] outline-none transition font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="w-full px-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-[30px] focus:ring-4 focus:ring-[#103370]/10 focus:border-[#103370] outline-none transition font-medium text-sm">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-8 py-4 bg-[#103370] hover:bg-[#103370] text-white rounded-[30px] font-black text-sm transition shadow-[0_15px_35px_rgba(0,0,0,0.04)]   shadow-brand-purple/10">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('avatar-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                const placeholder = document.getElementById('avatar-placeholder');

                preview.src = e.target.result;
                preview.classList.remove('hidden');

                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
