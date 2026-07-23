<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - ChasingTicket')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/chasingticket-theme.css') }}">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #edf2f7 50%, #e2e8f0 100%);
        }
    </style>
</head>

<body class="text-[#103370] flex min-h-screen p-4 md:p-6 gap-6">

    <aside class="w-64 bg-[#103370] text-white flex flex-col p-6 space-y-8 rounded-[40px] shadow-[0_20px_50px_rgba(16,51,112,0.25)] sticky top-6 h-[calc(100vh-3rem)] shrink-0 z-30">
        <div class="flex items-center gap-3 px-2">
            <div class="w-10 h-10 bg-[#b8ff00] rounded-full flex items-center justify-center text-[#103370] font-black text-lg shadow-md">
                CT
            </div>
            <div>
                <span class="text-lg font-black text-white tracking-tight block leading-none">ChasingTicket</span>
                <span class="text-[10px] font-bold text-[#b8ff00] tracking-widest uppercase">Dashboard</span>
            </div>
        </div>

        <nav class="flex-1 space-y-2 overflow-y-auto pr-1" style="scrollbar-width: none;">
            <p class="text-[10px] font-black uppercase tracking-widest text-white/50 mb-3 px-3">Main Menu</p>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-[#F24781] text-white shadow-[0_10px_20px_rgba(242,71,129,0.3)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }} rounded-full font-bold text-sm transition-all duration-200">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-[#b8ff00]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                Dashboard
            </a>
            
            <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.events.*') ? 'bg-[#F24781] text-white shadow-[0_10px_20px_rgba(242,71,129,0.3)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }} rounded-full font-bold text-sm transition-all duration-200">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.events.*') ? 'text-white' : 'text-[#b8ff00]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Kelola Event
            </a>
            
            <a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.coupons.*') ? 'bg-[#F24781] text-white shadow-[0_10px_20px_rgba(242,71,129,0.3)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }} rounded-full font-bold text-sm transition-all duration-200">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.coupons.*') ? 'text-white' : 'text-[#b8ff00]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
                Kelola Kupon
            </a>

            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'bg-[#F24781] text-white shadow-[0_10px_20px_rgba(242,71,129,0.3)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }} rounded-full font-bold text-sm transition-all duration-200">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-[#b8ff00]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M12 4.354c-1.966-1.966-5.164-1.966-7.071 0m7.071 0c1.966-1.966 5.164-1.966 7.071 0M12 20a8 8 0 100-16 8 8 0 000 16zM9.172 9.172a4 4 0 015.656 0M9.172 9.172L6.343 6.343m5.656 5.656l2.829 2.829"></path>
                    </svg>
                    Kelola User
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.categories.*') ? 'bg-[#F24781] text-white shadow-[0_10px_20px_rgba(242,71,129,0.3)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }} rounded-full font-bold text-sm transition-all duration-200">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-[#b8ff00]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21H3a1 1 0 01-1-1V7a1 1 0 011-1h14a1 1 0 011 1v8m0 0a4 4 0 11-8 0m8 0a4 4 0 11-8 0m7-11a1 1 0 11-2 0 1 1 0 012 0z"></path>
                    </svg>
                    Kelola Kategori
                </a>
                <a href="{{ route('admin.partners.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.partners.*') ? 'bg-[#F24781] text-white shadow-[0_10px_20px_rgba(242,71,129,0.3)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }} rounded-full font-bold text-sm transition-all duration-200">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.partners.*') ? 'text-white' : 'text-[#b8ff00]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M12 4.354c-1.966-1.966-5.164-1.966-7.071 0m7.071 0c1.966-1.966 5.164-1.966 7.071 0M12 20a8 8 0 100-16 8 8 0 000 16zM9.172 9.172a4 4 0 015.656 0M9.172 9.172L6.343 6.343m5.656 5.656l2.829 2.829"></path>
                    </svg>
                    Kelola Partner
                </a>
                <a href="{{ route('admin.feedbacks.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.feedbacks.*') ? 'bg-[#F24781] text-white shadow-[0_10px_20px_rgba(242,71,129,0.3)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }} rounded-full font-bold text-sm transition-all duration-200">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.feedbacks.*') ? 'text-white' : 'text-[#b8ff00]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Feedback & Ulasan
                </a>
            @endif

            <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.transactions.*') ? 'bg-[#F24781] text-white shadow-[0_10px_20px_rgba(242,71,129,0.3)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }} rounded-full font-bold text-sm transition-all duration-200">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.transactions.*') ? 'text-white' : 'text-[#b8ff00]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Laporan Transaksi
            </a>
        </nav>

        <div class="pt-4 border-t border-white/10 space-y-1">
            <a href="{{ route('admin.profile') }}" class="w-full flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('admin.profile') ? 'bg-[#F24781] text-white rounded-full font-bold' : 'text-white/70 hover:text-white hover:bg-white/10 rounded-full font-medium' }} text-sm transition">
                <svg class="w-5 h-5 text-[#b8ff00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Profil
            </a>
            <a href="/" class="w-full flex items-center gap-3 px-4 py-2.5 text-white/70 hover:text-white hover:bg-white/10 rounded-full font-medium text-sm transition">
                <svg class="w-5 h-5 text-[#b8ff00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-rose-300 hover:text-rose-100 hover:bg-rose-500/20 rounded-full font-bold text-sm transition text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 py-2 overflow-y-auto w-full max-w-full">

        <header class="flex flex-col md:flex-row md:items-center justify-between mb-8 pb-4 gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-[#103370] tracking-tight">@yield('page_title', 'Dashboard')</h1>
                <p class="text-slate-500 font-medium text-sm mt-0.5">@yield('page_subtitle', 'Selamat datang kembali!')</p>
            </div>
            <div class="flex items-center gap-3 self-start md:self-auto">
                <div class="text-right">
                    <p class="font-bold text-[#103370] text-sm leading-tight">{{ Auth::user()->name }}</p>
                    <span class="inline-block px-2.5 py-0.5 bg-[#b8ff00] text-[#103370] text-[10px] font-black rounded-full uppercase tracking-wider shadow-sm">
                        {{ Auth::user()->role }}
                    </span>
                </div>
                <div class="w-10 h-10 rounded-full bg-[#103370] text-white p-0.5 flex items-center justify-center shrink-0 overflow-hidden shadow-sm">
                    <img src="{{ Auth::user()->avatar_path ? asset('storage/' . Auth::user()->avatar_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=103370&color=fff' }}" class="rounded-full w-full h-full object-cover">
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="bg-[#b8ff00]/20 text-[#103370] border border-[#b8ff00] p-4 rounded-[30px] mb-6 font-bold text-sm flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-[#103370] text-[#b8ff00] flex items-center justify-center shrink-0 font-black">✓</div>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
