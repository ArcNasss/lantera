@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')

    <!-- Stat Cards -->
    <div class="grid grid-cols-4 gap-5 mb-6">
        <!-- Total Buku -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-cyan-100 flex items-center justify-center shrink-0">
                <i class="fas fa-book text-cyan-500 text-xl"></i>
            </div>
            <div class="min-w-0">
                <p class="text-sm text-gray-500">Total Buku</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalBooks }}</p>
                <a href="{{ route('books.index') }}" class="text-xs text-cyan-600 hover:text-cyan-700">Lihat &rarr;</a>
            </div>
        </div>
        <!-- Total Anggota -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-cyan-100 flex items-center justify-center shrink-0">
                <i class="fas fa-users text-cyan-500 text-xl"></i>
            </div>
            <div class="min-w-0">
                <p class="text-sm text-gray-500">Total Anggota</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalAnggota }}</p>
                <a href="{{ route('users.index') }}" class="text-xs text-cyan-600 hover:text-cyan-700">Lihat &rarr;</a>
            </div>
        </div>
        <!-- Denda Terkumpul -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-cyan-100 flex items-center justify-center shrink-0">
                <i class="fas fa-money-bill-wave text-cyan-500 text-xl"></i>
            </div>
            <div class="min-w-0">
                <p class="text-sm text-gray-500">Denda Terkumpul</p>
                <p class="text-lg font-bold text-gray-900">Rp {{ number_format($totalDendaSudahBayar, 0, ',', '.') }}</p>
                <a href="{{ route('admin.denda.index') }}?status=paid" class="text-xs text-cyan-600 hover:text-cyan-700">Lihat &rarr;</a>
            </div>
        </div>
        <!-- Total Kunjungan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-cyan-100 flex items-center justify-center shrink-0">
                <i class="fas fa-door-open text-cyan-500 text-xl"></i>
            </div>
            <div class="min-w-0">
                <p class="text-sm text-gray-500">Total Kunjungan</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalKunjungan }}</p>
                <a href="{{ route('admin.guest-book.index') }}" class="text-xs text-cyan-600 hover:text-cyan-700">Lihat &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Middle Row: Chart + Popular Books -->
    <div class="grid grid-cols-3 gap-5 mb-6">
        <!-- Chart -->
        <div class="col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-900">Statistik Peminjaman</h3>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">12 Bulan Terakhir</span>
            </div>
            <div style="height: 240px;">
                <canvas id="loanChart"></canvas>
            </div>
        </div>

        <!-- Buku Terpopuler -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-900">Buku Terpopuler</h3>
                <a href="{{ route('books.index') }}" class="text-xs text-cyan-600 hover:text-cyan-700">Lihat Semua &rarr;</a>
            </div>
            <div class="space-y-2">
                @forelse($popularBooks as $i => $book)
                @php

                    $barMax = $popularBooks->first()->total_pinjam ?: 1;
                    $barPct = $barMax > 0 ? round(($book->total_pinjam / $barMax) * 100) : 0;
                @endphp
                <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-gray-50 transition-colors group">

                    {{-- Cover --}}
                    @if($book->foto)
                        <img src="{{ asset('storage/' . $book->foto) }}"
                             class="w-9 h-12 object-cover rounded-md border border-gray-100 shrink-0 shadow-sm">
                    @else
                        <div class="w-9 h-12 bg-linear-to-b from-gray-100 to-gray-200 rounded-md border border-gray-100 shrink-0 flex items-center justify-center shadow-sm">
                            <i class="fas fa-book text-gray-300 text-sm"></i>
                        </div>
                    @endif
                    {{-- Info + bar --}}
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-800 truncate uppercase tracking-wide" style="font-size:0.72rem;">{{ $book->judul }}</p>
                        <p class="text-xs text-gray-400 truncate mb-1.5">{{ $book->penulis }}</p>
                        {{-- Progress bar --}}
                        <div class="w-full bg-gray-100 rounded-full h-1">
                            <div class="h-1 rounded-full bg-cyan-400 transition-all duration-500" style="width: {{ $barPct }}%"></div>
                        </div>
                    </div>
                    {{-- Count --}}
                    <div class="shrink-0 text-right">
                        <span class="text-base font-bold text-cyan-600">{{ $book->total_pinjam }}</span>
                        <p class="text-xs text-gray-400 leading-none">kali</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-10 text-gray-400">
                    <i class="fas fa-book text-3xl mb-2 block"></i>
                    <p class="text-sm">Belum ada data</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Denda Belum Bayar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 flex items-center justify-between border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-900">Denda Belum Dibayar</h3>
            <a href="{{ route('admin.denda.index') }}?status=pending" class="text-xs text-cyan-600 hover:text-cyan-700">Lihat Semua &rarr;</a>
        </div>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 border-b border-gray-100">
                    <th class="px-5 py-3 text-left font-medium w-8">No</th>
                    <th class="px-5 py-3 text-left font-medium">Anggota</th>
                    <th class="px-5 py-3 text-left font-medium">Judul Buku</th>
                    <th class="px-5 py-3 text-center font-medium">Kondisi</th>
                    <th class="px-5 py-3 text-center font-medium">Denda</th>
                    <th class="px-5 py-3 text-center font-medium">Tgl Kembali</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($unpaidDenda as $i => $return)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-sm text-gray-400">{{ $i + 1 }}.</td>
                    <td class="px-5 py-3">
                        <p class="text-sm font-medium text-gray-900">{{ $return->loan->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $return->loan->user->nomor_identitas }}</p>
                    </td>
                    <td class="px-5 py-3">
                        <p class="text-sm text-gray-700 truncate max-w-56">{{ $return->loan->bookItem->book->judul }}</p>
                    </td>
                    <td class="px-5 py-3 text-center">
                        @if($return->kondisi == 'baik')
                            <span class="px-2.5 py-1 text-xs rounded-full bg-green-100 text-green-700">Baik</span>
                        @elseif($return->kondisi == 'rusak')
                            <span class="px-2.5 py-1 text-xs rounded-full bg-orange-100 text-orange-700">Rusak</span>
                        @elseif($return->kondisi == 'hilang')
                            <span class="px-2.5 py-1 text-xs rounded-full bg-red-100 text-red-700">Hilang</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="text-sm font-semibold text-red-600">Rp {{ number_format($return->denda, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-5 py-3 text-center text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($return->tanggal_pengembalian)->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                        <i class="fas fa-check-circle text-4xl mb-2 block text-green-400"></i>
                        <p class="text-sm">Semua denda sudah dibayar</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('loanChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Peminjaman',
                    data: {!! json_encode($chartData) !!},
                    borderColor: 'rgb(6, 182, 212)',
                    backgroundColor: 'rgba(6, 182, 212, 0.08)',
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
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, color: '#9ca3af', font: { size: 11 } },
                        grid: { color: '#f3f4f6' }
                    },
                    x: {
                        ticks: { color: '#9ca3af', font: { size: 11 } },
                        grid: { display: false }
                    }
                }
            }
        });
    </script>

@endsection
