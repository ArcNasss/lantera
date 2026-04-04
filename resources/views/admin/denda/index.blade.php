@extends('layouts.admin')

@section('title', 'Rekap Denda')
@section('page-title', 'Rekap Denda')

@section('content')

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-2xl font-bold text-gray-900">Rekap Denda</h3>
        <button onclick="openExportModal()" class="flex items-center gap-2 px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg text-sm font-medium transition-colors">
            <i class="fas fa-file-export"></i>
            <span>Export Excel</span>
        </button>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('admin.denda.index') }}" id="filter-form" class="flex items-center justify-between mb-5">
        <div class="relative w-80">
            <i class="fas fa-search text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 text-sm"></i>
            <input
                type="text"
                name="search"
                id="search-input"
                value="{{ request('search') }}"
                placeholder="Search"
                class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-full text-sm focus:outline-none focus:border-gray-400"
                autocomplete="off"
            >
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm font-medium text-gray-600">Status :</span>
            <select name="status" id="status-select" class="px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <option value="all" {{ !request('status') || request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>
    </form>

    <script>
        (function () {
            var form = document.getElementById('filter-form');
            var searchInput = document.getElementById('search-input');
            var statusSelect = document.getElementById('status-select');
            var debounceTimer;
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function () { form.submit(); }, 400);
            });
            statusSelect.addEventListener('change', function () { form.submit(); });
        })();
    </script>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 mb-5 md:grid-cols-3">
        <div class="relative overflow-hidden px-7 py-5 text-white shadow-sm" style="border-radius: 22px; min-height: 96px; background: linear-gradient(90deg, #1fa5d5 0%, #25b3e1 58%, #58c5ed 100%);">
            <div class="absolute rounded-full" style="right: -56px; top: -60px; width: 216px; height: 216px; background: rgba(176, 235, 251, 0.24);"></div>
            <div class="absolute rounded-full" style="right: -30px; top: -34px; width: 164px; height: 164px; background: rgba(193, 240, 252, 0.28);"></div>
            <div class="absolute rounded-full" style="right: 4px; top: 0; width: 96px; height: 96px; background: rgba(214, 246, 254, 0.38);"></div>
            <div class="relative z-10 flex h-full items-center justify-between gap-5">
                <div class="pr-4">
                    <p class="mb-1 text-[14px] font-medium leading-none text-white/95">Total Denda</p>
                    <p class="text-[18px] font-bold leading-tight text-white">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl" style="background: rgba(244, 252, 255, 0.88);">
                    <i class="fas fa-sack-dollar text-[18px]" style="color: #1799c9;"></i>
                </div>
            </div>
        </div>
        <div class="relative overflow-hidden px-7 py-5 text-white shadow-sm" style="border-radius: 22px; min-height: 96px; background: linear-gradient(90deg, #1fa5d5 0%, #25b3e1 58%, #58c5ed 100%);">
            <div class="absolute rounded-full" style="right: -56px; top: -60px; width: 216px; height: 216px; background: rgba(176, 235, 251, 0.24);"></div>
            <div class="absolute rounded-full" style="right: -30px; top: -34px; width: 164px; height: 164px; background: rgba(193, 240, 252, 0.28);"></div>
            <div class="absolute rounded-full" style="right: 4px; top: 0; width: 96px; height: 96px; background: rgba(214, 246, 254, 0.38);"></div>
            <div class="relative z-10 flex h-full items-center justify-between gap-5">
                <div class="pr-4">
                    <p class="mb-1 text-[14px] font-medium leading-none text-white/95">Belum Dibayar</p>
                    <p class="text-[18px] font-bold leading-tight text-white">Rp {{ number_format($totalPending, 0, ',', '.') }}</p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl" style="background: rgba(244, 252, 255, 0.88);">
                    <i class="fas fa-wallet text-[18px]" style="color: #1799c9;"></i>
                </div>
            </div>
        </div>
        <div class="relative overflow-hidden px-7 py-5 text-white shadow-sm" style="border-radius: 22px; min-height: 96px; background: linear-gradient(90deg, #1fa5d5 0%, #25b3e1 58%, #58c5ed 100%);">
            <div class="absolute rounded-full" style="right: -56px; top: -60px; width: 216px; height: 216px; background: rgba(176, 235, 251, 0.24);"></div>
            <div class="absolute rounded-full" style="right: -30px; top: -34px; width: 164px; height: 164px; background: rgba(193, 240, 252, 0.28);"></div>
            <div class="absolute rounded-full" style="right: 4px; top: 0; width: 96px; height: 96px; background: rgba(214, 246, 254, 0.38);"></div>
            <div class="relative z-10 flex h-full items-center justify-between gap-5">
                <div class="pr-4">
                    <p class="mb-1 text-[14px] font-medium leading-none text-white/95">Sudah Dibayar</p>
                    <p class="text-[18px] font-bold leading-tight text-white">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl" style="background: rgba(244, 252, 255, 0.88);">
                    <i class="fas fa-money-check-dollar text-[18px]" style="color: #1799c9;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-cyan-500 text-white text-sm">
                        <th class="px-5 py-3 text-left font-semibold w-12">No</th>
                        <th class="px-5 py-3 text-left font-semibold">Judul Buku</th>
                        <th class="px-5 py-3 text-left font-semibold">Peminjam</th>
                        <th class="px-5 py-3 text-center font-semibold">Kondisi</th>
                        <th class="px-5 py-3 text-center font-semibold">Denda</th>
                        <th class="px-5 py-3 text-center font-semibold">Status</th>
                        <th class="px-5 py-3 text-center font-semibold">Tgl Kembali</th>
                        <th class="px-5 py-3 text-center font-semibold w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($denda as $index => $return)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $denda->firstItem() + $loop->index }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                @if($return->loan->bookItem->book->foto)
                                    <img src="{{ asset('storage/' . $return->loan->bookItem->book->foto) }}"
                                         alt="{{ $return->loan->bookItem->book->judul }}"
                                         class="w-9 h-12 object-cover rounded shrink-0 border border-gray-200">
                                @else
                                    <div class="w-9 h-12 bg-gray-100 rounded shrink-0 border border-gray-200 flex items-center justify-center">
                                        <i class="fas fa-book text-gray-300 text-xs"></i>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate max-w-48">{{ $return->loan->bookItem->book->judul }}</p>
                                    <p class="text-xs text-gray-400">{{ $return->loan->bookItem->kode_buku }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $return->loan->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $return->loan->user->nomor_identitas }}</p>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($return->kondisi == 'baik')
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Baik</span>
                            @elseif($return->kondisi == 'rusak')
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-700">Rusak</span>
                            @elseif($return->kondisi == 'hilang')
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Hilang</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="text-sm font-semibold text-red-600">Rp {{ number_format($return->denda, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($return->status == 'paid')
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Lunas</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($return->tanggal_pengembalian)->format('d M Y') }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('admin.pengembalian.invoice', $return->id) }}"
                               class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-cyan-100 hover:bg-cyan-200 text-cyan-600 transition-colors"
                               title="Invoice">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center text-gray-400">
                            <i class="fas fa-money-bill-wave text-5xl mb-3 block"></i>
                            <p class="text-base font-medium text-gray-500">Tidak ada data denda</p>
                            <p class="text-sm mt-1">Belum ada pengembalian dengan denda</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($denda->total() > 0)
    <div class="flex items-center justify-between mt-4">
        <p class="text-sm text-gray-500">
            Menampilkan {{ $denda->firstItem() }}&ndash;{{ $denda->lastItem() }} dari {{ $denda->total() }} data
        </p>
        <div class="flex items-center gap-1">
            {{-- Previous --}}
            @if($denda->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 bg-white border border-gray-200 text-sm cursor-not-allowed">
                    <i class="fas fa-chevron-left text-xs"></i>
                </span>
            @else
                <a href="{{ $denda->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 text-sm">
                    <i class="fas fa-chevron-left text-xs"></i>
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach($denda->getUrlRange(1, $denda->lastPage()) as $page => $url)
                @if($page == $denda->currentPage())
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-cyan-500 text-white text-sm font-medium">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 text-sm">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($denda->hasMorePages())
                <a href="{{ $denda->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 text-sm">
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

    <x-export-modal
        :route="route('admin.denda.export')"
        title="Export Laporan Denda"
    />
@endsection
