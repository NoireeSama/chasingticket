@extends('layouts.admin')
@section('title', $role === 'admin' ? 'Dashboard Admin - ChasingTicket' : 'Dashboard Merchant - ChasingTicket')
@section('page_title', 'Dashboard')
@section('page_subtitle', $role === 'admin' ? 'Ringkasan Aktivitas Sistem & Pengguna' : 'Ringkasan Transaksi Penjualan Anda')

@section('content')

@if($role === 'admin')

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        <div class="bg-white p-6 rounded-[30px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] hover:-translate-y-1 hover:border-[#103370] transition-all">
            <div class="w-12 h-12 bg-[#103370] text-[#b8ff00] rounded-full flex items-center justify-center mb-4 shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
            <p class="text-slate-400 text-xs font-black uppercase tracking-wider mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-black text-[#103370]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-6 rounded-[30px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] hover:-translate-y-1 hover:border-[#F24781] transition-all">
            <div class="w-12 h-12 bg-[#F24781] text-white rounded-full flex items-center justify-center mb-4 shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                    </path>
                </svg>
            </div>
            <p class="text-slate-400 text-xs font-black uppercase tracking-wider mb-1">Tiket Terjual</p>
            <h3 class="text-2xl font-black text-[#103370]">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-6 rounded-[30px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] hover:-translate-y-1 hover:border-[#103370] transition-all">
            <div class="w-12 h-12 bg-[#103370]/10 text-[#103370] rounded-full flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <p class="text-slate-400 text-xs font-black uppercase tracking-wider mb-1">Customer Aktif</p>
            <h3 class="text-2xl font-black text-[#103370]">{{ number_format($activeCustomers, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-6 rounded-[30px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] hover:-translate-y-1 hover:border-[#F24781] transition-all">
            <div class="w-12 h-12 bg-[#F24781]/10 text-[#F24781] rounded-full flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <p class="text-slate-400 text-xs font-black uppercase tracking-wider mb-1">Merchant Aktif</p>
            <h3 class="text-2xl font-black text-[#103370]">{{ number_format($activeMerchants, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        
        <div class="bg-white p-6 rounded-[35px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)]">
            <h3 class="font-black text-lg text-[#103370] mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#F24781]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                Pertumbuhan Pengguna (Registrasi)
            </h3>
            <div class="relative h-[300px]">
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[35px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)]">
            <h3 class="font-black text-lg text-[#103370] mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#103370]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Pertumbuhan Acara (Penyelenggaraan)
            </h3>
            <div class="relative h-[300px]">
                <canvas id="eventGrowthChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[35px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] overflow-hidden">
        <div class="p-6 md:p-8 border-b border-slate-100">
            <h3 class="font-black text-xl text-[#103370]">Log Aktivitas Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-[#103370] text-white uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4 w-1/4">Waktu</th>
                        <th class="px-8 py-4 w-1/4">Pelaku</th>
                        <th class="px-8 py-4">Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @forelse($activityLogs as $log)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-8 py-5 text-sm font-semibold text-slate-500 whitespace-nowrap">{{ $log->created_at->format('d M Y - H:i') }}</td>
                        <td class="px-8 py-5">
                            @if($log->user)
                                <p class="font-bold text-[#103370] text-sm mb-0.5">{{ $log->user->name }}</p>
                                <span class="px-2.5 py-0.5 text-[9px] font-black rounded-full uppercase tracking-wider {{ $log->user->role === 'admin' ? 'bg-[#F24781] text-white' : 'bg-[#b8ff00] text-[#103370]' }}">
                                    {{ $log->user->role }}
                                </span>
                            @else
                                <span class="text-slate-400 italic text-sm">Sistem / Pengguna Terhapus</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 font-semibold text-slate-700">{{ $log->activity }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-10 text-center text-slate-400 font-medium">Belum ada aktivitas yang terekam di sistem.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@else

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        <div class="bg-white p-6 rounded-[30px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] hover:-translate-y-1 hover:border-[#103370] transition-all">
            <div class="w-12 h-12 bg-[#103370] text-[#b8ff00] rounded-full flex items-center justify-center mb-4 shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
            <p class="text-slate-400 text-xs font-black uppercase tracking-wider mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-black text-[#103370]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-6 rounded-[30px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] hover:-translate-y-1 hover:border-[#F24781] transition-all">
            <div class="w-12 h-12 bg-[#F24781] text-white rounded-full flex items-center justify-center mb-4 shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                    </path>
                </svg>
            </div>
            <p class="text-slate-400 text-xs font-black uppercase tracking-wider mb-1">Tiket Terjual</p>
            <h3 class="text-2xl font-black text-[#103370]">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-6 rounded-[30px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] hover:-translate-y-1 hover:border-[#103370] transition-all">
            <div class="w-12 h-12 bg-[#103370]/10 text-[#103370] rounded-full flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-slate-400 text-xs font-black uppercase tracking-wider mb-1">Event Aktif</p>
            <h3 class="text-2xl font-black text-[#103370]">{{ number_format($activeEvents, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-6 rounded-[30px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] hover:-translate-y-1 hover:border-[#F24781] transition-all">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-slate-400 text-xs font-black uppercase tracking-wider mb-1">Pesanan Pending</p>
            <h3 class="text-2xl font-black text-[#103370]">{{ number_format($pendingOrders, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        
        <div class="bg-white p-6 rounded-[35px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)]">
            <h3 class="font-black text-lg text-[#103370] mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#103370]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Pertumbuhan Penyelenggaraan Event
            </h3>
            <div class="relative h-[300px]">
                <canvas id="merchantEventGrowthChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[35px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)]">
            <h3 class="font-black text-lg text-[#103370] mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#F24781]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Tren Penjualan & Pendapatan Tiket
            </h3>
            <div class="relative h-[300px]">
                <canvas id="merchantSalesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[35px] border-2 border-[#f1f5f9] shadow-[0_15px_35px_rgba(0,0,0,0.04)] overflow-hidden">
        <div class="p-6 md:p-8 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-black text-xl text-[#103370]">Transaksi Terakhir</h3>
            <a href="{{ route('admin.transactions.index') }}" class="text-[#F24781] font-bold text-sm hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-[#103370] text-white uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4 w-1/4">Tgl Transaksi</th>
                        <th class="px-8 py-4 w-1/4">Pembeli</th>
                        <th class="px-8 py-4 w-1/4">Event</th>
                        <th class="px-8 py-4 w-[10%]">Status</th>
                        <th class="px-8 py-4 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentTransactions as $trx)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-8 py-5 text-sm text-slate-500 max-w-xs break-all font-semibold">
                            {{ $trx->created_at->format('d M Y - H:i') }}<br>
                            <span class="text-xs text-slate-400 font-mono">{{ $trx->order_id }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <p class="font-bold text-[#103370] text-sm truncate max-w-[150px]">{{ $trx->customer_name }}</p>
                            <p class="text-xs text-slate-400 truncate max-w-[150px]">{{ $trx->customer_email }}</p>
                        </td>
                        <td class="px-8 py-5 font-bold text-slate-700 max-w-xs truncate">{{ $trx->event->title ?? '-' }}</td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            @if(in_array(strtolower($trx->status), ['settlement', 'success']))
                                <span class="px-3 py-1 bg-[#b8ff00] text-[#103370] rounded-full text-[10px] font-black uppercase tracking-wider">Success</span>
                            @elseif(strtolower($trx->status) === 'pending')
                                <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-[10px] font-black uppercase tracking-wider">Pending</span>
                            @else
                                <span class="px-3 py-1 bg-[#F24781]/10 text-[#F24781] rounded-full text-[10px] font-black uppercase tracking-wider">{{ $trx->status }}</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 font-black text-[#103370] whitespace-nowrap text-right text-base">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-slate-400 font-medium">Belum ada transaksi penjualan terbaru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const labels = {!! json_encode($chartLabels) !!};

    @if($role === 'admin')
        // User Growth Chart
        const userCtx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(userCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Customer Baru',
                        data: {!! json_encode($chartCustomers) !!},
                        borderColor: '#F24781',
                        backgroundColor: 'rgba(242, 71, 129, 0.08)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3
                    },
                    {
                        label: 'Merchant Baru',
                        data: {!! json_encode($chartMerchants) !!},
                        borderColor: '#103370',
                        backgroundColor: 'rgba(16, 51, 112, 0.08)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, stepSize: 1 }
                    }
                }
            }
        });

        // Event Growth Chart
        const eventCtx = document.getElementById('eventGrowthChart').getContext('2d');
        new Chart(eventCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Event Terdaftar',
                    data: {!! json_encode($chartEvents) !!},
                    backgroundColor: '#103370',
                    borderRadius: 10,
                    barPercentage: 0.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, stepSize: 1 }
                    }
                }
            }
        });
    @else
        // Merchant Event Growth Chart
        const merchantEventCtx = document.getElementById('merchantEventGrowthChart').getContext('2d');
        new Chart(merchantEventCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Event Saya',
                    data: {!! json_encode($chartEvents) !!},
                    backgroundColor: '#103370',
                    borderRadius: 10,
                    barPercentage: 0.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, stepSize: 1 }
                    }
                }
            }
        });

        // Merchant Sales & Revenue Chart
        const salesCtx = document.getElementById('merchantSalesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Tiket Terjual',
                        data: {!! json_encode($chartTickets) !!},
                        borderColor: '#F24781',
                        backgroundColor: 'transparent',
                        tension: 0.3,
                        yAxisID: 'y',
                        borderWidth: 3
                    },
                    {
                        label: 'Pendapatan (Rp)',
                        data: {!! json_encode($chartRevenue) !!},
                        borderColor: '#103370',
                        backgroundColor: 'rgba(16, 51, 112, 0.08)',
                        tension: 0.3,
                        fill: true,
                        yAxisID: 'y1',
                        borderWidth: 3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { display: true, text: 'Tiket Terjual' },
                        ticks: { precision: 0, stepSize: 1 },
                        grid: { drawOnChartArea: false }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: { display: true, text: 'Pendapatan (Rp)' },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: { drawOnChartArea: true }
                    }
                }
            }
        });
    @endif
});
</script>

@endsection
