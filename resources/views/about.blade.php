@extends('layouts.app')

@section('content')
<main class="max-w-5xl mx-auto px-6 py-12">
    
    <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <nav class="flex text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 gap-2 items-center">
                <a href="{{ route('home') }}" class="hover:text-[#F24781] transition">Jelajahi</a>
                <span>/</span>
                <span class="text-slate-600 font-bold">Tentang Kami</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900">Tentang Kami</h1>
            <p class="text-sm md:text-base text-slate-500 font-medium mt-1">Mengenal lebih dekat tim di balik pembuatan platform ChasingTicket.</p>
        </div>
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#F24781] text-white rounded-[40px] text-sm font-bold shadow-[0_10px_20px_rgba(242,71,129,0.3)] hover:-translate-y-1 hover:shadow-[0_15px_30px_rgba(242,71,129,0.4)] transition-all gap-2 self-start md:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Jelajah
        </a>
    </div>

    <div class="mb-12 p-8 bg-rose-50/80 border border-rose-200/80 rounded-3xl flex flex-col md:flex-row gap-6 shadow-sm backdrop-blur-sm">
        <div class="w-12 h-12 rounded-2xl bg-rose-500 text-white flex items-center justify-center flex-shrink-0 shadow-lg shadow-rose-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <div>
            <h3 class="font-extrabold text-rose-950 text-lg leading-tight mb-2">Pemberitahuan & Disclaimer Penting</h3>
            <p class="text-sm text-rose-900 leading-relaxed font-medium">
                Website ini dirancang dan dikembangkan sepenuhnya sebagai <strong>projek Ujian Akhir Semester (UAS)</strong>. 
                Semua data event, user, reservasi, checkout, kupon, maupun sistem transaksi pembayaran yang berjalan di dalam 
                platform ini adalah <strong>simulasi belaka</strong> dan tidak melibatkan uang asli.
            </p>
            <p class="text-sm text-rose-900 leading-relaxed font-semibold mt-2.5">
                Peringatan: Seluruh transaksi finansial atau pembelian tiket di dalam platform ini tidak nyata. Kami selaku tim pengembang 
                menyatakan bahwa semua transaksi tidak ada tanggung jawab dari kita.
            </p>
        </div>
    </div>

    <div class="bg-[#103370] text-white rounded-[60px] p-8 md:p-12 mb-12 shadow-[0_20px_50px_rgba(16,51,112,0.3)] relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-[#F24781]/30 rounded-full blur-3xl -z-0 pointer-events-none"></div>
        <div class="relative z-10 max-w-3xl">
            <span class="inline-block px-4 py-1.5 bg-[#b8ff00] border border-[#b8ff00] text-[#103370] text-xs font-bold tracking-widest uppercase rounded-full mb-6">Tentang Aplikasi</span>
            <h2 class="text-2xl md:text-3xl font-black mb-4">ChasingTicket - Kejar Tiket Impianmu!</h2>
            <p class="text-indigo-200 leading-relaxed text-sm md:text-base font-medium mb-6">
                ChasingTicket hadir sebagai solusi platform ticketing modern yang menjembatani penyelenggara event (merchants) dengan mahasiswa dan publik secara efisien. 
                Dengan antarmuka yang bersih, intuitif, dan responsif, kami berkomitmen untuk memberikan pengalaman terbaik dalam manajemen tiket, 
                pemilihan kategori event, hingga proses checkout yang seamless.
            </p>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 pt-6 border-t border-indigo-800">
                <div>
                    <h5 class="text-[#b8ff00] text-xs font-bold uppercase tracking-wider mb-1">Status Proyek</h5>
                    <p class="text-white font-extrabold text-sm md:text-base">UAS Development</p>
                </div>
                <div>
                    <h5 class="text-[#b8ff00] text-xs font-bold uppercase tracking-wider mb-1">Framework</h5>
                    <p class="text-white font-extrabold text-sm md:text-base">Laravel & Tailwind CSS</p>
                </div>
                <div>
                    <h5 class="text-[#b8ff00] text-xs font-bold uppercase tracking-wider mb-1">Tahun</h5>
                    <p class="text-white font-extrabold text-sm md:text-base">2026</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-6">
        <h2 class="text-2xl font-black text-slate-900 mb-2 text-center">Tim Pengembang</h2>
        <p class="text-sm text-slate-500 text-center font-medium max-w-lg mx-auto mb-10">Mahasiswa kreatif di balik perancangan dan implementasi kode platform ChasingTicket.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="bg-white rounded-[40px] border-[3px] border-[#f1f5f9] shadow-sm p-8 flex flex-col items-center text-center hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(16,51,112,0.1)] hover:border-[#103370] transition-all duration-300 group">
                <div class="w-24 h-24 rounded-full bg-[#103370]/10 text-[#103370] flex items-center justify-center font-black text-3xl mb-5 group-hover:bg-[#103370] group-hover:text-[#b8ff00] transition duration-300">
                    ZA
                </div>
                <h4 class="font-extrabold text-[#103370] text-lg leading-tight">Zaydan Azka</h4>
                <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wider">NIM: 24.12.3131</p>
                <div class="mt-4 px-3 py-1 bg-[#F24781]/10 text-[#F24781] text-xs font-bold rounded-full">
                    Developer & UI Designer
                </div>
            </div>

            <div class="bg-white rounded-[40px] border-[3px] border-[#f1f5f9] shadow-sm p-8 flex flex-col items-center text-center hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(16,51,112,0.1)] hover:border-[#103370] transition-all duration-300 group">
                <div class="w-24 h-24 rounded-full bg-[#103370]/10 text-[#103370] flex items-center justify-center font-black text-3xl mb-5 group-hover:bg-[#103370] group-hover:text-[#b8ff00] transition duration-300">
                    ML
                </div>
                <h4 class="font-extrabold text-[#103370] text-lg leading-tight">Mirza Lazuardy</h4>
                <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wider">NIM: 24.12.3132</p>
                <div class="mt-4 px-3 py-1 bg-[#F24781]/10 text-[#F24781] text-xs font-bold rounded-full">
                    Developer & Database Architect
                </div>
            </div>

            <div class="bg-white rounded-[40px] border-[3px] border-[#f1f5f9] shadow-sm p-8 flex flex-col items-center text-center hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(16,51,112,0.1)] hover:border-[#103370] transition-all duration-300 group">
                <div class="w-24 h-24 rounded-full bg-[#103370]/10 text-[#103370] flex items-center justify-center font-black text-3xl mb-5 group-hover:bg-[#103370] group-hover:text-[#b8ff00] transition duration-300">
                    AP
                </div>
                <h4 class="font-extrabold text-[#103370] text-lg leading-tight">Aditya Permana</h4>
                <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wider">NIM: 24.12.3135</p>
                <div class="mt-4 px-3 py-1 bg-[#F24781]/10 text-[#F24781] text-xs font-bold rounded-full">
                    Developer & Quality Assurance
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
