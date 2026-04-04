@extends('layouts.admin')

@section('title', 'Buku Tamu')
@section('page-title', 'Buku Tamu')

@section('content')

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-2xl font-bold text-gray-900">Buku Tamu</h3>
        <button onclick="openExportModal()" class="flex items-center gap-2 px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg text-sm font-medium transition-colors">
            <i class="fas fa-file-export"></i>
            <span>Export Excel</span>
        </button>
    </div>

    <!-- Search & Date Filter -->
    <form method="GET" action="{{ route('admin.guest-book.index') }}" id="filter-form" class="flex items-center justify-between mb-5 gap-4">
        <div class="relative w-80">
            <i class="fas fa-search text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 text-sm"></i>
            <input
                type="text"
                name="search"
                id="search-input"
                value="{{ request('search') }}"
                placeholder="Cari nama atau keperluan..."
                class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-full text-sm focus:outline-none focus:border-gray-400"
                autocomplete="off"
            >
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm font-medium text-gray-600">Tanggal :</span>
            <input type="date" name="start_date" id="start-date"
                   value="{{ request('start_date') }}"
                   class="px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
            <span class="text-sm text-gray-500">s/d</span>
            <input type="date" name="end_date" id="end-date"
                   value="{{ request('end_date') }}"
                   class="px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
        </div>
    </form>

    <script>
        (function () {
            var form        = document.getElementById('filter-form');
            var searchInput = document.getElementById('search-input');
            var startDate   = document.getElementById('start-date');
            var endDate     = document.getElementById('end-date');
            var debounceTimer;
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function () { form.submit(); }, 400);
            });
            startDate.addEventListener('change', function () { form.submit(); });
            endDate.addEventListener('change', function () { form.submit(); });
        })();
    </script>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 gap-5 mb-5 md:grid-cols-3">
        <!-- Total Kunjungan -->
        <div class="relative overflow-hidden px-7 py-5 text-white shadow-sm" style="border-radius: 22px; min-height: 96px; background: linear-gradient(90deg, #1fa5d5 0%, #25b3e1 58%, #58c5ed 100%);">
            <div class="absolute rounded-full" style="right: -56px; top: -60px; width: 216px; height: 216px; background: rgba(176, 235, 251, 0.24);"></div>
            <div class="absolute rounded-full" style="right: -30px; top: -34px; width: 164px; height: 164px; background: rgba(193, 240, 252, 0.28);"></div>
            <div class="absolute rounded-full" style="right: 4px; top: 0; width: 96px; height: 96px; background: rgba(214, 246, 254, 0.38);"></div>
            <div class="relative z-10 flex h-full items-center justify-between gap-5">
                <div class="pr-4">
                    <p class="mb-1 text-[14px] font-medium leading-none text-white/95">Total Kunjungan</p>
                    <p class="text-[18px] font-bold leading-tight text-white">{{ $totalKunjungan }} data</p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl" style="background: rgba(244, 252, 255, 0.88);">
                    <i class="fas fa-book-open text-[18px]" style="color: #1799c9;"></i>
                </div>
            </div>
        </div>
        <!-- Hari Ini -->
        <div class="relative overflow-hidden px-7 py-5 text-white shadow-sm" style="border-radius: 22px; min-height: 96px; background: linear-gradient(90deg, #1fa5d5 0%, #25b3e1 58%, #58c5ed 100%);">
            <div class="absolute rounded-full" style="right: -56px; top: -60px; width: 216px; height: 216px; background: rgba(176, 235, 251, 0.24);"></div>
            <div class="absolute rounded-full" style="right: -30px; top: -34px; width: 164px; height: 164px; background: rgba(193, 240, 252, 0.28);"></div>
            <div class="absolute rounded-full" style="right: 4px; top: 0; width: 96px; height: 96px; background: rgba(214, 246, 254, 0.38);"></div>
            <div class="relative z-10 flex h-full items-center justify-between gap-5">
                <div class="pr-4">
                    <p class="mb-1 text-[14px] font-medium leading-none text-white/95">Hari Ini</p>
                    <p class="text-[18px] font-bold leading-tight text-white">{{ $todayKunjungan }} data</p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl" style="background: rgba(244, 252, 255, 0.88);">
                    <i class="fas fa-calendar-day text-[18px]" style="color: #1799c9;"></i>
                </div>
            </div>
        </div>
        <!-- Bulan Ini -->
        <div class="relative overflow-hidden px-7 py-5 text-white shadow-sm" style="border-radius: 22px; min-height: 96px; background: linear-gradient(90deg, #1fa5d5 0%, #25b3e1 58%, #58c5ed 100%);">
            <div class="absolute rounded-full" style="right: -56px; top: -60px; width: 216px; height: 216px; background: rgba(176, 235, 251, 0.24);"></div>
            <div class="absolute rounded-full" style="right: -30px; top: -34px; width: 164px; height: 164px; background: rgba(193, 240, 252, 0.28);"></div>
            <div class="absolute rounded-full" style="right: 4px; top: 0; width: 96px; height: 96px; background: rgba(214, 246, 254, 0.38);"></div>
            <div class="relative z-10 flex h-full items-center justify-between gap-5">
                <div class="pr-4">
                    <p class="mb-1 text-[14px] font-medium leading-none text-white/95">Bulan Ini</p>
                    <p class="text-[18px] font-bold leading-tight text-white">{{ $monthKunjungan }} data</p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl" style="background: rgba(244, 252, 255, 0.88);">
                    <i class="fas fa-calendar-alt text-[18px]" style="color: #1799c9;"></i>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3 text-sm">
            <i class="fas fa-check-circle text-green-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-cyan-500 text-white text-sm">
                        <th class="px-5 py-3 text-left font-semibold w-12">No</th>
                        <th class="px-5 py-3 text-left font-semibold">Nama</th>
                        <th class="px-5 py-3 text-left font-semibold">Keperluan</th>
                        <th class="px-5 py-3 text-center font-semibold">Tanggal</th>
                        <th class="px-5 py-3 text-center font-semibold w-20">Jam</th>
                        <th class="px-5 py-3 text-center font-semibold w-16">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($guestBooks as $guest)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $guestBooks->firstItem() + $loop->index }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-cyan-100 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fas fa-user text-cyan-500 text-xs"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-900">{{ $guest->nama }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600 max-w-sm">
                            {{ Str::limit($guest->keperluan, 100) }}
                        </td>
                        <td class="px-5 py-4 text-center text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($guest->created_at)->format('d M Y') }}
                        </td>
                        <td class="px-5 py-4 text-center text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($guest->created_at)->format('H:i') }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            <button @click="$dispatch('open-confirm-delete', { url: '{{ route('admin.guest-book.destroy', $guest->id) }}' })"
                                    class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-red-100 hover:bg-red-200 text-red-600 transition-colors"
                                    title="Hapus">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                            <i class="fas fa-book-open text-5xl mb-3 block"></i>
                            <p class="text-base font-medium text-gray-500">Tidak ada data buku tamu</p>
                            <p class="text-sm mt-1">Belum ada pengunjung yang mengisi buku tamu</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($guestBooks->total() > 0)
    <div class="flex items-center justify-between mt-4">
        <p class="text-sm text-gray-500">
            Menampilkan {{ $guestBooks->firstItem() }}&ndash;{{ $guestBooks->lastItem() }} dari {{ $guestBooks->total() }} data
        </p>
        <div class="flex items-center gap-1">
            @if($guestBooks->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 bg-white border border-gray-200 text-sm cursor-not-allowed">
                    <i class="fas fa-chevron-left text-xs"></i>
                </span>
            @else
                <a href="{{ $guestBooks->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 text-sm">
                    <i class="fas fa-chevron-left text-xs"></i>
                </a>
            @endif
            @foreach($guestBooks->getUrlRange(1, $guestBooks->lastPage()) as $page => $url)
                @if($page == $guestBooks->currentPage())
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-cyan-500 text-white text-sm font-medium">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 text-sm">{{ $page }}</a>
                @endif
            @endforeach
            @if($guestBooks->hasMorePages())
                <a href="{{ $guestBooks->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 text-sm">
                    <i class="fas fa-chevron-right text-xs"></i>
                </a>
            @else
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 bg-white border border-gray-200 text-sm cursor-not-allowed">
                    <i class="fas fa-chevron-right text-xs"></i>
                </span>
            @endif
        </div>
    </div>
    @endif

    <x-confirm-delete title="Hapus Data Buku Tamu?" />

    <!-- Export Modal -->
    <x-export-modal
        :route="route('admin.guest-book.export')"
        title="Export Laporan Buku Tamu"
        :hasStatus="false"
    />

@endsection
