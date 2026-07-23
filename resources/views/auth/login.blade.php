<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - ChasingTicket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/chasingticket-theme.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: linear-gradient(135deg, #0d2654 0%, #103370 50%, #1a4590 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="text-slate-800 min-h-screen flex items-center justify-center p-4 md:p-8 relative overflow-x-hidden">

    <div class="fixed -top-24 -left-24 w-96 h-96 bg-[#F24781]/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed -bottom-24 -right-24 w-96 h-96 bg-[#b8ff00]/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#103370]/30 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-5xl relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

        <div class="lg:col-span-5 text-white space-y-6 hidden lg:block pr-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group mb-2">
                <div class="w-12 h-12 bg-[#b8ff00] text-[#103370] rounded-full flex items-center justify-center font-black text-xl shadow-[0_10px_20px_rgba(184,255,0,0.3)] group-hover:scale-110 transition">
                    CT
                </div>
                <span class="text-2xl font-black tracking-tight text-white">ChasingTicket</span>
            </a>

            <h1 class="text-4xl font-black leading-tight tracking-tight">
                Selamat Datang Kembali di <span class="text-[#b8ff00]">ChasingTicket!</span>
            </h1>

            <p class="text-slate-300 font-medium text-sm leading-relaxed">
                Kejar dan dapatkan tiket event, konser musik, dan workshop favoritmu dengan cepat, aman, dan tanpa ribet.
            </p>

            <div class="space-y-4 pt-4 border-t border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#b8ff00]/20 text-[#b8ff00] flex items-center justify-center font-bold text-sm shrink-0">✓</div>
                    <p class="text-xs font-semibold text-slate-200">Pembayaran Instan via Midtrans (QRIS, E-Wallet, Transfer)</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#F24781]/20 text-[#F24781] flex items-center justify-center font-bold text-sm shrink-0">✓</div>
                    <p class="text-xs font-semibold text-slate-200">E-Ticket QR Code Resmi Langsung Terbit</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7">
            <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_25px_60px_rgba(0,0,0,0.25)] rounded-[40px] p-8 md:p-12 relative overflow-hidden">

                <div class="flex items-center justify-between mb-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#103370] transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                    
                    <div class="lg:hidden flex items-center gap-2">
                        <div class="w-9 h-9 bg-[#103370] text-[#b8ff00] rounded-full flex items-center justify-center font-black text-sm">CT</div>
                        <span class="font-black text-[#103370] text-sm">ChasingTicket</span>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-black text-[#103370] tracking-tight mb-2">Masuk ke Akun</h2>
                    <p class="text-slate-500 text-sm font-medium">Masukkan email dan kata sandi Anda untuk melanjutkan</p>
                </div>

                @if(session('error'))
                    <div class="mb-6 p-4 bg-rose-50 border-2 border-rose-200 text-rose-700 rounded-full font-bold text-xs flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-rose-600 text-white flex items-center justify-center font-black text-xs shrink-0">!</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 border-2 border-rose-200 text-rose-700 rounded-[25px] font-bold text-xs">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="redirect" value="{{ request('redirect') }}">

                    <div>
                        <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                                class="w-full pl-12 pr-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full text-sm font-semibold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#103370] focus:bg-white transition" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-[#103370] mb-2 uppercase tracking-wider">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input type="password" name="password" placeholder="••••••••"
                                class="w-full pl-12 pr-5 py-4 bg-slate-50 border-2 border-[#f1f5f9] rounded-full text-sm font-semibold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#103370] focus:bg-white transition" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-[#103370] text-white rounded-full font-black text-lg shadow-[0_10px_25px_rgba(16,51,112,0.3)] hover:bg-[#F24781] hover:shadow-[0_10px_25px_rgba(242,71,129,0.35)] transition duration-300 transform active:scale-98 mt-2">
                        Masuk Sekarang
                    </button>
                </form>

                <div class="my-6 flex items-center justify-center gap-3">
                    <div class="h-[1px] flex-1 bg-slate-200"></div>
                    <span class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">atau</span>
                    <div class="h-[1px] flex-1 bg-slate-200"></div>
                </div>

                <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 py-3.5 bg-slate-50 border-2 border-[#f1f5f9] text-[#103370] rounded-full font-bold text-sm hover:bg-white hover:border-[#103370] shadow-sm hover:shadow-md transition active:scale-98 mb-6">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l3.66-2.85z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.85c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    <span>Masuk dengan Google</span>
                </a>

                <p class="text-center text-xs font-semibold text-slate-500">
                    Belum punya akun? <a href="{{ route('register') }}" class="font-black text-[#F24781] hover:text-[#103370] underline transition">Daftar di sini</a>
                </p>
            </div>
        </div>

    </div>

</body>
</html>
