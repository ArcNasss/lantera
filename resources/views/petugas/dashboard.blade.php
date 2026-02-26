@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Info Banner -->
    <div class="bg-cyan-50 border border-cyan-200 rounded-lg p-6 mb-6 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="bg-cyan-500 text-white rounded-full p-3">
                <i class="fas fa-bell w-6 h-6 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">
                    @if($pendingCount > 0)
                        {{ $pendingCount }} Pengajuan Baru Menunggu Persetujuan
                    @else
                        Tidak Ada Pengajuan Pending
                    @endif
                </h3>
                <p class="text-sm text-gray-600">
                    @if($pendingCount > 0)
                        Segera proses pengajuan peminjaman buku yang menunggu persetujuan
                    @else
                        Semua pengajuan peminjaman telah diproses
                    @endif
                </p>
            </div>
        </div>
        @if($pendingCount > 0)
        <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition-colors">
            Lihat Sekarang
        </a>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-sm text-gray-600">Pengajuan Pending</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalPending }}</p>
                </div>
                <div class="bg-yellow-100 p-3 text-center rounded-lg">
                    <i class="fas fa-clock w-8 h-8 text-yellow-500 text-3xl"></i>
                </div>
            </div>
            <a href="{{ route('peminjaman.index') }}" class="text-sm text-cyan-600 hover:text-cyan-700">Lihat →</a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-sm text-gray-600">Pengajuan Disetujui</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalApproved }}</p>
                </div>
                <div class="bg-blue-100 p-3 text-center rounded-lg">
                    <i class="fas fa-check-circle w-8 h-8 text-blue-500 text-3xl"></i>
                </div>
            </div>
            <a href="{{ route('peminjaman.riwayat') }}" class="text-sm text-cyan-600 hover:text-cyan-700">Lihat →</a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-sm text-gray-600">Pengajuan Ditolak</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalRejected }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                    <i class="fas fa-times-circle w-8 h-8 text-red-500 text-3xl"></i>
                </div>
            </div>
            <a href="{{ route('peminjaman.riwayat') }}" class="text-sm text-cyan-600 hover:text-cyan-700">Lihat →</a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-sm text-gray-600">Buku Rusak/Hilang</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalDamaged }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-lg">
                    <i class="fas fa-triangle-exclamation w-8 h-8 text-orange-500 text-3xl"></i>
                </div>
            </div>
            <a href="{{ route('peminjaman.riwayat') }}" class="text-sm text-cyan-600 hover:text-cyan-700">Lihat →</a>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Statistik Peminjaman</h3>
                <div class="text-sm text-gray-600">
                    <i class="fas fa-chart-line mr-1"></i>
                    12 Bulan Terakhir
                </div>
            </div>
            <div class="h-64">
                <canvas id="loanChart"></canvas>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
                <span class="text-xs text-gray-500">
                    <i class="fas fa-history mr-1"></i>
                    5 Terbaru
                </span>
            </div>
            <div class="space-y-4">
                @forelse($recentLoans as $activity)
                <div class="border-b pb-3">
                    <div class="flex justify-between items-start mb-1">
                        <p class="font-medium text-gray-900 text-sm">{{ $activity['user_name'] }}</p>
                        <span class="text-xs text-gray-500">{{ $activity['date'] }}</span>
                    </div>
                    <p class="text-xs text-gray-600">{{ $activity['type'] }}: {{ Str::limit($activity['book_title'], 30) }}</p>
                    @if($activity['status'] == 'pending')
                        <span class="inline-block mt-1 px-2 py-0.5 bg-yellow-100 text-yellow-600 text-xs rounded">Pending</span>
                    @elseif($activity['status'] == 'disetujui')
                        <span class="inline-block mt-1 px-2 py-0.5 bg-blue-100 text-blue-600 text-xs rounded">Disetujui</span>
                    @elseif($activity['status'] == 'dikembalikan')
                        <span class="inline-block mt-1 px-2 py-0.5 bg-green-100 text-green-600 text-xs rounded">Selesai</span>
                    @endif
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-inbox text-3xl mb-2"></i>
                    <p class="text-sm">Belum ada aktivitas</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('loanChart').getContext('2d');
        const loanChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: {!! json_encode($chartData) !!},
                    borderColor: 'rgb(6, 182, 212)',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(6, 182, 212)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endsection
