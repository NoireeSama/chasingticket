@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12">
    
    <div class="mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-[#103370] transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Beranda
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">

        <div class="lg:col-span-1 space-y-8">
            
            <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-white/50 rounded-[40px] p-8 shadow-neu-spec border-none-sm border-none border-none text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                
                <div class="mt-4 flex justify-center">
                    @if($user->avatar_path)
                        <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="{{ $user->name }}" class="w-28 h-28 rounded-full object-cover border-4 border-slate-50 shadow-neu-spec border-none-sm border-none">
                    @else
                        <div class="w-28 h-28 bg-[#103370]/5 text-[#103370] rounded-full flex items-center justify-center text-4xl font-extrabold border-4 border-slate-50 shadow-neu-spec border-none-sm border-none">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                <h2 class="mt-6 text-2xl font-black text-slate-800 tracking-tight">{{ $user->name }}</h2>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#103370]/5 text-[#103370] text-xs font-bold rounded-full mt-2 uppercase tracking-wide">
                    Verified Merchant
                </div>

                <p class="mt-6 text-sm text-slate-500 leading-relaxed italic">
                    {{ $user->description ?? 'Penyelenggara acara terpercaya di platform ChasingTicket.' }}
                </p>

                <div class="mt-8 pt-8 border-t border-white/50 grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Acara</p>
                        <h4 class="text-2xl font-black text-slate-800 mt-1">{{ $user->events->count() }}</h4>
                    </div>
                    <div class="text-center border-l border-white/50">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rating</p>
                        <h4 class="text-2xl font-black text-[#103370] mt-1 flex items-center justify-center gap-1">
                            ⭐ {{ $user->merchant_rating }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-white/50 rounded-[40px] p-8 shadow-neu-spec border-none-sm border-none border-none space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Akumulasi Penilaian</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Berdasarkan ulasan dari seluruh event</p>
                </div>

                <div class="flex items-center gap-6 bg-[#e0e0e0] p-6 rounded-[40px] border border-white/50/50 justify-center text-center">
                    <div>
                        <h2 class="text-5xl font-black text-slate-800">{{ $user->merchant_rating }}</h2>
                        <div class="flex justify-center gap-0.5 my-2 text-amber-400">
                            @php
                                $avg = $user->merchant_rating;
                                $fullStars = floor($avg);
                                $hasHalf = ($avg - $fullStars) >= 0.5;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @elseif($i == $fullStars + 1 && $hasHalf)
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                        <defs>
                                            <linearGradient id="merchantHalfGrad">
                                                <stop offset="50%" stop-color="currentColor"/>
                                                <stop offset="50%" stop-color="#cbd5e1" stop-opacity="1"/>
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#merchantHalfGrad)" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-slate-300 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <p class="text-xs text-slate-400">{{ $user->merchant_reviews_count }} Ulasan Total</p>
                    </div>
                </div>

                <div class="space-y-2.5">
                    @php
                        $totalReviews = $user->merchant_reviews_count;
                        $reviewsCollection = $user->merchantReviews;
                    @endphp
                    @for($ratingVal = 5; $ratingVal >= 1; $ratingVal--)
                        @php
                            $countVal = $reviewsCollection->where('rating', $ratingVal)->count();
                            $pct = $totalReviews > 0 ? ($countVal / $totalReviews) * 100 : 0;
                        @endphp
                        <div class="flex items-center gap-4 text-sm font-medium">
                            <span class="w-3 text-slate-600">{{ $ratingVal }}</span>
                            <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-400 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="w-8 text-right text-slate-400 text-xs">{{ $countVal }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-8">

            <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-white/50 rounded-[40px] p-2 shadow-neu-spec border-none-sm border-none border-none flex flex-wrap gap-2">
                <button onclick="switchOrganizerTab('upcoming-events-tab', this)" 
                    class="tab-btn flex-1 py-3 px-5 rounded-[40px] text-sm font-bold text-center transition-all bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] text-slate-800 border-none font-bold shadow-neu-spec border-none-sm border-none shadow-[0_15px_35px_rgba(16,51,112,0.3)]/10">
                    Acara Mendatang ({{ $upcomingEvents->count() }})
                </button>
                <button onclick="switchOrganizerTab('past-events-tab', this)" 
                    class="tab-btn flex-1 py-3 px-5 rounded-[40px] text-sm font-bold text-center text-slate-500 hover:text-[#103370] hover:bg-[#e0e0e0] transition-all">
                    Acara Selesai ({{ $pastEvents->count() }})
                </button>
                <button onclick="switchOrganizerTab('testimonials-tab', this)" 
                    class="tab-btn flex-1 py-3 px-5 rounded-[40px] text-sm font-bold text-center text-slate-500 hover:text-[#103370] hover:bg-[#e0e0e0] transition-all">
                    Testimoni & Ulasan ({{ $totalReviews }})
                </button>
            </div>

            <div id="upcoming-events-tab" class="organizer-tab-content space-y-6">
                @if($upcomingEvents->isEmpty())
                    <div class="text-center py-16 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-white/50 rounded-[40px] shadow-neu-spec border-none-sm border-none border-none space-y-4">
                        <div class="w-16 h-16 bg-[#103370]/5 text-[#103370] rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h4 class="text-slate-700 font-bold text-lg">Belum ada acara mendatang</h4>
                        <p class="text-sm text-slate-400 max-w-sm mx-auto">Merchant saat ini belum mempublikasikan acara baru untuk waktu mendatang.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($upcomingEvents as $event)
                            <div class="group bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-white/50 rounded-[40px] overflow-hidden shadow-neu-spec border-none-sm border-none border-none hover:shadow-neu-spec border-none transition-all duration-300 flex flex-col">
                                <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                                    @if($event->poster_path)
                                        <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <img src="{{ url('assets/concert.png') }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @endif
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3.5 py-1 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)]/95 backdrop-blur text-[#103370] text-xs font-black rounded-full uppercase tracking-wider shadow-neu-spec border-none-sm border-none border-none">
                                            {{ $event->category->name }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-6 flex flex-col flex-1 space-y-4">
                                    <h4 class="text-lg font-black text-slate-800 line-clamp-1 leading-snug">{{ $event->title }}</h4>
                                    
                                    <div class="space-y-2 text-xs text-slate-500 font-semibold">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-[#103370]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $event->date->format('l, d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-[#103370]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            </svg>
                                            <span class="truncate">{{ $event->location }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="pt-4 border-t border-white/50 flex items-center justify-between mt-auto">
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Mulai Dari</p>
                                            <p class="text-lg font-black text-[#103370] mt-0.5">Rp {{ number_format($event->current_price, 0, ',', '.') }}</p>
                                        </div>
                                        <a href="{{ route('events.show', $event) }}" class="px-5 py-2.5 bg-slate-900 text-white rounded-[40px] text-xs font-bold hover:bg-[#103370] transition-all duration-300">
                                            Detail Event
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div id="past-events-tab" class="organizer-tab-content space-y-6 hidden">
                @if($pastEvents->isEmpty())
                    <div class="text-center py-16 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-white/50 rounded-[40px] shadow-neu-spec border-none-sm border-none border-none space-y-4">
                        <div class="w-16 h-16 bg-[#103370]/5 text-[#103370] rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"></path>
                            </svg>
                        </div>
                        <h4 class="text-slate-700 font-bold text-lg">Belum ada acara yang selesai</h4>
                        <p class="text-sm text-slate-400 max-w-sm mx-auto">Merchant belum menyelenggarakan acara apa pun yang sudah tuntas.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($pastEvents as $event)
                            <div class="bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-white/50 rounded-[40px] overflow-hidden shadow-neu-spec border-none-sm border-none border-none hover:shadow-neu-spec border-none-sm border-none transition flex flex-col opacity-85">
                                <div class="relative aspect-[16/10] overflow-hidden bg-slate-100 grayscale">
                                    @if($event->poster_path)
                                        <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="{{ url('assets/concert.png') }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                                    @endif
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3.5 py-1 bg-slate-900/90 text-white text-xs font-black rounded-full uppercase tracking-wider shadow-neu-spec border-none-sm border-none border-none">
                                            Selesai
                                        </span>
                                    </div>
                                </div>
                                <div class="p-6 flex flex-col flex-1 space-y-4">
                                    <h4 class="text-lg font-black text-slate-800 line-clamp-1 leading-snug">{{ $event->title }}</h4>
                                    
                                    <div class="space-y-2 text-xs text-slate-500 font-semibold">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $event->date->format('l, d M Y') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="pt-4 border-t border-white/50 flex items-center justify-between mt-auto">
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Rata-rata Rating</p>
                                            <p class="text-base font-black text-slate-800 mt-0.5">⭐ {{ $event->average_rating }}</p>
                                        </div>
                                        <a href="{{ route('events.show', $event) }}" class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-[40px] text-xs font-bold hover:bg-slate-200 transition-all">
                                            Lihat Halaman
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div id="testimonials-tab" class="organizer-tab-content space-y-6 hidden">
                @if($user->merchantReviews->isEmpty())
                    <div class="text-center py-16 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-white/50 rounded-[40px] shadow-neu-spec border-none-sm border-none border-none space-y-4">
                        <div class="w-16 h-16 bg-[#103370]/5 text-[#103370] rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h4 class="text-slate-700 font-bold text-lg">Belum ada ulasan</h4>
                        <p class="text-sm text-slate-400 max-w-sm mx-auto">Belum ada ulasan atau rating dari pembeli tiket untuk merchant ini.</p>
                    </div>
                @else
                    <div class="space-y-4 max-h-[700px] overflow-y-auto pr-2" style="scrollbar-width: thin;">
                        @foreach($user->merchantReviews->sortByDesc('created_at') as $review)
                            <div class="p-6 bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] border border-white/50 rounded-[40px] shadow-neu-spec border-none-sm border-none border-none space-y-4 hover:shadow-neu-spec border-none-sm border-none transition">
                                <div class="flex justify-between items-start flex-wrap gap-4">
                                    <div class="flex items-center gap-3">
                                        @if($review->user->avatar_path)
                                            <img src="{{ asset('storage/' . $review->user->avatar_path) }}" alt="{{ $review->user->name }}" class="w-10 h-10 rounded-full object-cover border border-white/50 shadow-neu-spec border-none-sm border-none border-none shrink-0">
                                        @else
                                            <div class="w-10 h-10 bg-[#103370]/5 text-[#103370] rounded-full flex items-center justify-center font-black text-sm shrink-0">
                                                {{ strtoupper(substr($review->user->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h5 class="font-bold text-slate-800 text-sm leading-none">{{ $review->user->name }}</h5>
                                            <p class="text-[10px] text-slate-400 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-0.5 text-amber-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-slate-200 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                
                                @if($review->review)
                                    <p class="text-slate-600 text-sm leading-relaxed">{{ $review->review }}</p>
                                @else
                                    <p class="text-slate-400 italic text-xs">Hanya memberikan rating bintang.</p>
                                @endif

                                <div class="pt-3 border-t border-slate-50 flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Ulasan untuk Event:</span>
                                    <a href="{{ route('events.show', $review->event) }}" class="text-xs text-[#103370] hover:text-[#103370] font-bold hover:underline truncate max-w-[250px]">
                                        {{ $review->event->title }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</main>

<script>
    function switchOrganizerTab(tabId, buttonElement) {
        // Hide all tab contents
        document.querySelectorAll('.organizer-tab-content').forEach(function(content) {
            content.classList.add('hidden');
        });
        
        // Show target tab content
        document.getElementById(tabId).classList.remove('hidden');
        
        // Reset all buttons style
        document.querySelectorAll('.tab-btn').forEach(function(btn) {
            btn.className = "tab-btn flex-1 py-3 px-5 rounded-[40px] text-sm font-bold text-center text-slate-500 hover:text-[#103370] hover:bg-[#e0e0e0] transition-all";
        });
        
        // Highlight active button
        buttonElement.className = "tab-btn flex-1 py-3 px-5 rounded-[40px] text-sm font-bold text-center bg-white border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] text-slate-800 border-none font-bold shadow-neu-spec border-none-sm border-none shadow-[0_15px_35px_rgba(16,51,112,0.3)]/10 transition-all";
    }
</script>
@endsection
