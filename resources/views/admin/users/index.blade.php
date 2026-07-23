@extends('layouts.admin')
@section('title', 'Kelola User - Admin')
@section('page_title', 'Kelola User')
@section('page_subtitle', 'Atur, verifikasi, dan kelola akun pengguna ChasingTicket.')

@section('content')
<div class="mb-6 flex flex-col md:flex-row gap-4 items-stretch md:items-center justify-between">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap md:flex-nowrap gap-3 items-center w-full md:w-auto flex-1">

        <input type="text" name="search" placeholder="Cari nama, username, atau email..." value="{{ $search }}"
            class="flex-1 min-w-[200px] px-5 py-3 rounded-full border-2 border-[#f1f5f9] bg-white shadow-sm focus:ring-2 focus:ring-[#103370] focus:border-transparent outline-none transition font-medium text-sm">

        <select name="role" onchange="this.form.submit()" class="px-5 py-3 rounded-full border-2 border-[#f1f5f9] bg-white text-slate-700 font-bold text-sm outline-none cursor-pointer shadow-sm">
            <option value="">Semua Peran</option>
            <option value="customer" {{ $role === 'customer' ? 'selected' : '' }}>Customer</option>
            <option value="merchant" {{ $role === 'merchant' ? 'selected' : '' }}>Merchant</option>
            <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>

        <select name="sort_by" onchange="this.form.submit()" class="px-5 py-3 rounded-full border-2 border-[#f1f5f9] bg-white text-slate-700 font-bold text-sm outline-none cursor-pointer shadow-sm">
            <option value="latest" {{ $sortBy === 'latest' ? 'selected' : '' }}>Terbaru</option>
            <option value="oldest" {{ $sortBy === 'oldest' ? 'selected' : '' }}>Terlama</option>
            <option value="name_asc" {{ $sortBy === 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
            <option value="name_desc" {{ $sortBy === 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
        </select>

        <button type="submit" class="px-6 py-3 bg-[#103370] text-white rounded-full font-bold text-sm shadow-md hover:bg-[#F24781] transition">
            Cari
        </button>

        @if($search || $role)
            <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-slate-200 text-slate-700 rounded-full font-bold text-sm hover:bg-slate-300 transition">
                Reset
            </a>
        @endif
    </form>

    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#103370] text-white font-bold rounded-full shadow-[0_10px_20px_rgba(16,51,112,0.25)] hover:bg-[#F24781] hover:shadow-[0_10px_20px_rgba(242,71,129,0.35)] transition text-sm whitespace-nowrap self-stretch md:self-auto justify-center">
        <span>+ Tambah User Baru</span>
    </a>
</div>

@if(session('error'))
    <div class="mb-6 p-4 bg-rose-50 border-2 border-rose-200 text-rose-700 rounded-full font-bold text-xs flex items-center gap-3">
        <span class="w-6 h-6 rounded-full bg-rose-600 text-white flex items-center justify-center font-black text-xs shrink-0">!</span>
        <span>{{ session('error') }}</span>
    </div>
@endif

<div class="bg-white rounded-[35px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#103370] text-white uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Foto Profil</th>
                    <th class="px-8 py-4">Nama & Username</th>
                    <th class="px-8 py-4">Email & Auth</th>
                    <th class="px-8 py-4">Peran (Role)</th>
                    <th class="px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $index => $usr)
                <tr class="hover:bg-slate-50 transition">

                    <td class="px-8 py-6 font-bold text-slate-400">{{ $users->firstItem() + $index }}</td>

                    <td class="px-8 py-6">
                        @if($usr->avatar_path)
                            <img src="{{ asset('storage/' . $usr->avatar_path) }}" class="w-12 h-12 rounded-full object-cover shadow-sm border-2 border-white">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($usr->name) }}&background=103370&color=fff&bold=true" class="w-12 h-12 rounded-full object-cover shadow-sm border-2 border-white">
                        @endif
                    </td>

                    <td class="px-8 py-6">
                        <p class="font-extrabold text-[#103370] text-base">{{ $usr->name }}</p>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">{{ $usr->username ? '@' . $usr->username : '-' }}</p>
                    </td>

                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-700 text-sm">{{ $usr->email }}</p>
                        @if($usr->google_id)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 mt-1 bg-amber-100 text-amber-800 text-[10px] font-black rounded-full uppercase tracking-wider">
                                <svg class="w-3 h-3 text-amber-600" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.24 10.285V13.4h6.887C18.2 15.614 15.645 18 12.24 18c-3.86 0-7-3.14-7-7s3.14-7 7-7c1.7 0 3.3.65 4.5 1.8l2.42-2.42C17.382 1.57 14.93 0 12.24 0c-6.08 0-11 4.92-11 11s4.92 11 11 11c6.34 0 10.55-4.46 10.55-10.74 0-.72-.08-1.42-.23-2.075H12.24z"/>
                                </svg>
                                Google Auth
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 mt-1 bg-[#103370]/10 text-[#103370] text-[10px] font-black rounded-full uppercase tracking-wider">
                                Password
                            </span>
                        @endif
                    </td>

                    <td class="px-8 py-6">
                        @if($usr->role === 'admin')
                            <span class="px-3 py-1 bg-rose-100 text-rose-700 text-[10px] font-black rounded-full uppercase tracking-wider">
                                Admin
                            </span>
                        @elseif($usr->role === 'merchant')
                            <span class="px-3 py-1 bg-[#b8ff00] text-[#103370] text-[10px] font-black rounded-full uppercase tracking-wider">
                                Merchant
                            </span>
                        @else
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-full uppercase tracking-wider">
                                Customer
                            </span>
                        @endif
                    </td>

                    <td class="px-8 py-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.users.edit', $usr->id) }}" class="p-2.5 bg-[#103370]/10 text-[#103370] rounded-full hover:bg-[#103370] hover:text-white transition shadow-sm" title="Edit User">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>

                            @if($usr->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $usr->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun user ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-full hover:bg-rose-600 hover:text-white transition shadow-sm" title="Hapus User">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-slate-400 font-medium">Belum ada pengguna yang terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-100">
        {{ $users->links() }}
    </div>
</div>
@endsection
