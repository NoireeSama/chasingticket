<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChasingTicket - Kejar Tiket Keinganan Mu Sekarang!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="{{ asset('css/chasingticket-theme.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(242,71,129,0.05) 50%, rgba(248,250,252,1) 100%);
            min-height: 100vh;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="text-slate-900 overflow-x-hidden">

    <nav
        class="glass sticky top-8 z-40 mx-4 mt-4 px-6 py-4 rounded-[40px] border border-white/40 shadow-xl flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div
                class="w-12 h-12 bg-[#103370] rounded-full flex items-center justify-center text-white font-black text-xl shadow-[0_5px_15px_rgba(16,51,112,0.3)]">
                CT</div>
            <span class="text-2xl font-black tracking-tight text-[#103370]">ChasingTicket</span>
        </div>
        <div class="hidden md:flex gap-8 font-bold items-center text-[#103370]">
            <a href="{{ route('home') }}" class="hover:text-[#F24781] transition-colors">Jelajahi</a>
            <a href="{{ route('events.all') }}" class="hover:text-[#F24781] transition-colors">Semua Event</a>
            <a href="{{ route('about') }}" class="hover:text-[#F24781] transition-colors">Tentang Kami</a>

            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-[#103370] text-white rounded-full font-bold shadow-[0_10px_20px_rgba(16,51,112,0.3)] hover:bg-[#F24781] hover:shadow-[0_15px_25px_rgba(242,71,129,0.4)] hover:-translate-y-1 transition-all">Dashboard</a>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline m-0">
                        @csrf
                        <button type="submit" class="hover:text-red-600 font-semibold transition">Logout</button>
                    </form>
                @else

                    <div class="relative">
                        <button id="profileDropdownBtn" class="w-12 h-12 rounded-full overflow-hidden border-4 border-[#103370] shadow-[0_5px_15px_rgba(16,51,112,0.3)] focus:outline-none transition hover:scale-105 active:scale-95 flex items-center justify-center bg-slate-100">
                            @if(Auth::user()->avatar_path)
                                <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff&bold=true" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                            @endif
                        </button>

                        <div id="profileDropdownMenu" class="hidden absolute -right-6 top-full mt-6 w-56 rounded-2xl border border-slate-100 shadow-xl bg-white z-50 py-2 text-slate-700 transition-all transform origin-top-right">
                            <div class="px-4 py-2 border-b border-slate-100 mb-1">
                                <p class="font-bold text-slate-900 truncate leading-tight">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-slate-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                                <span class="inline-block px-2 py-0.5 mt-1.5 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded uppercase">{{ Auth::user()->role }}</span>
                            </div>

                            @if(Auth::user()->role === 'merchant')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-indigo-50 hover:text-indigo-600 transition font-medium">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                            @endif

                            <a href="{{ route('settings') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-indigo-50 hover:text-indigo-600 transition font-medium">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Setting</span>
                            </a>

                            <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-indigo-50 hover:text-indigo-600 transition font-medium">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>Wishlist</span>
                            </a>

                            <a href="{{ route('cart.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-indigo-50 hover:text-indigo-600 transition font-medium">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span>Keranjang</span>
                            </a>

                            <a href="{{ route('history') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-indigo-50 hover:text-indigo-600 transition font-medium">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                <span>Riwayat Belanja</span>
                            </a>

                            <div class="border-t border-slate-100 mt-1 pt-1">
                                <form action="{{ route('admin.logout') }}" method="POST" class="block w-full m-0">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition font-semibold text-left">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span>Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <a href="{{ route('login') }}" class="px-6 py-3 bg-[#103370] text-white rounded-full font-bold shadow-[0_10px_20px_rgba(16,51,112,0.3)] hover:bg-[#F24781] hover:shadow-[0_15px_25px_rgba(242,71,129,0.4)] hover:-translate-y-1 transition-all">Login</a>
            @endauth
        </div>
    </nav>

    @yield('content')

    <footer class="bg-[#103370] text-white py-20 px-6 mt-20 rounded-t-[60px] relative overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 relative z-10">
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <div
                        class="w-12 h-12 bg-[#b8ff00] rounded-full flex items-center justify-center text-[#103370] font-black text-xl">
                        CT</div>
                    <span class="text-3xl font-black text-white">ChasingTicket</span>
                </div>
                <p class="max-w-xs text-indigo-300">Platform reservasi tiket event online terbaik untuk mahasiswa dan
                    penyelenggara profesional.</p>
            </div>

            <div>
                <h4 class="text-white font-bold mb-6">Kategori</h4>
                <ul class="space-y-2">
                    @foreach($categories as $cat)
                    <li><a href="/?category={{ $cat->slug }}" class="hover:text-white transition">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold mb-6">Navigasi</h4>
                <ul class="space-y-4">
                    <li><a href="#" class="hover:text-white transition">Home</a></li>
                    <li><a href="#" class="hover:text-white transition">Semua Event</a></li>
                    <li><a href="#" class="hover:text-white transition">Cara Bayar</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6">Hubungi Kami</h4>
                <ul class="space-y-4">
                    <li>support@eventtiket.com</li>
                    <li>+62 812 3456 7890</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto pt-12 mt-12 border-t border-indigo-800 text-center text-indigo-400 text-sm">
            &copy; 2026 ChasingTicket. Built with Laravel & Tailwind CSS.
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('profileDropdownBtn');
            const menu = document.getElementById('profileDropdownMenu');

            if (btn && menu) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!btn.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>