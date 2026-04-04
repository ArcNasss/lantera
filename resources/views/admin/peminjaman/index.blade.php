@extends('layouts.admin')

@section('title', 'Daftar Peminjaman')
@section('page-title', 'Daftar Peminjaman')

@section('content')
    @if(session('success'))
        <x-flash-message type="success" />
    @endif

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-2xl font-bold text-gray-900">Daftar Peminjaman</h3>
        <button onclick="openExportModal()" class="flex items-center gap-2 px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg text-sm font-medium transition-colors">
            <i class="fas fa-file-export"></i>
            <span>Export Excel</span>
        </button>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('admin.peminjaman.index') }}" id="filter-form" class="flex items-center justify-between mb-5">
        <div class="relative w-80">
            <i class="fas fa-search text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 text-sm"></i>
            <input type="text" name="search" id="search-input" value="{{ request('search') }}" placeholder="Search"
                class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-full text-sm focus:outline-none focus:border-gray-400" autocomplete="off">
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm font-medium text-gray-600">Status :</span>
            <select name="status" id="status-select" class="px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <option value="" {{ !request('status') ? 'selected' : '' }}>Semua</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
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
    <div class="grid grid-cols-1 gap-4 mb-5 md:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white px-6 py-5 shadow-sm">
            <div class="mb-4 flex items-center gap-3 text-gray-500">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-rose-50 text-rose-400">
                    <i class="fas fa-book-open text-sm"></i>
                </div>
                <p class="text-base font-medium text-gray-500">Baru</p>
            </div>
            <p class="text-3xl font-semibold leading-none text-gray-950">{{ $totalPeminjaman }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white px-6 py-5 shadow-sm">
            <div class="mb-4 flex items-center gap-3 text-gray-500">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-50 text-amber-500">
                    <i class="fas fa-gear text-sm"></i>
                </div>
                <p class="text-base font-medium text-gray-500">Proses</p>
            </div>
            <p class="text-3xl font-semibold leading-none text-gray-950">{{ $totalPending }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white px-6 py-5 shadow-sm">
            <div class="mb-4 flex items-center gap-3 text-gray-500">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-cyan-50 text-cyan-500">
                    <i class="fas fa-circle-check text-sm"></i>
                </div>
                <p class="text-base font-medium text-gray-500">Selesai</p>
            </div>
            <p class="text-3xl font-semibold leading-none text-gray-950">{{ $totalDisetujui }}</p>
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
                        <th class="px-5 py-3 text-center font-semibold">Kategori</th>
                        <th class="px-5 py-3 text-center font-semibold">Status</th>
                        <th class="px-5 py-3 text-center font-semibold">Tgl Pinjam</th>
                        <th class="px-5 py-3 text-center font-semibold">Tgl Kembali</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($loans as $loan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $loans->firstItem() + $loop->index }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                @if($loan->bookItem->book->foto)
                                    <img src="{{ asset('storage/' . $loan->bookItem->book->foto) }}"
                                         alt="{{ $loan->bookItem->book->judul }}"
                                         class="w-9 h-12 object-cover rounded shrink-0 border border-gray-200">
                                @else
                                    <div class="w-9 h-12 bg-gray-100 rounded shrink-0 border border-gray-200 flex items-center justify-center">
                                        <i class="fas fa-book text-gray-300 text-xs"></i>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate max-w-52">{{ $loan->bookItem->book->judul }}</p>
                                    <p class="text-xs text-gray-400">{{ $loan->bookItem->kode_buku }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $loan->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $loan->user->nomor_identitas }}</p>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700">
                                {{ $loan->bookItem->book->category->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($loan->status == 'pending')
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                            @elseif($loan->status == 'disetujui')
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Disetujui</span>
                            @elseif($loan->status == 'ditolak')
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Ditolak</span>
                            @elseif($loan->status == 'dikembalikan')
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Dikembalikan</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td class="px-5 py-4 text-center text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                            <i class="fas fa-book-open text-5xl mb-3 block"></i>
                            <p class="text-base font-medium text-gray-500">Tidak ada data peminjaman</p>
                            <p class="text-sm mt-1">Belum ada pengajuan peminjaman buku</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($loans->total() > 0)
    <div class="flex items-center justify-between mt-4">
        <p class="text-sm text-gray-500">
            Menampilkan {{ $loans->firstItem() }}&ndash;{{ $loans->lastItem() }} dari {{ $loans->total() }} data
        </p>
        <div class="flex items-center gap-1">
            @if($loans->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 bg-white border border-gray-200 text-sm cursor-not-allowed"><i class="fas fa-chevron-left text-xs"></i></span>
            @else
                <a href="{{ $loans->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 text-sm"><i class="fas fa-chevron-left text-xs"></i></a>
            @endif
            @foreach($loans->getUrlRange(1, $loans->lastPage()) as $page => $url)
                @if($page == $loans->currentPage())
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-cyan-500 text-white text-sm font-medium">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 text-sm">{{ $page }}</a>
                @endif
            @endforeach
            @if($loans->hasMorePages())
                <a href="{{ $loans->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 text-sm"><i class="fas fa-chevron-right text-xs"></i></a>
            @else
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 bg-white border border-gray-200 text-sm cursor-not-allowed"><i class="fas fa-chevron-right text-xs"></i></span>
            @endif
        </div>
    </div>
    @endif

    <x-export-modal
        :route="route('admin.peminjaman.export')"
        title="Export Laporan Peminjaman"
        :statusOptions="[
            'pending' => 'Pending',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'dikembalikan' => 'Dikembalikan'
        ]"
    />

@endsection
