@extends('layouts.petugas')

@section('title', 'Kelola Denda')
@section('page-title', 'Kelola Denda')

@section('content')
    <!-- Flash Messages -->
    @if(session('success'))
        <x-flash-message type="success" />
    @endif

    @if(session('error'))
        <x-flash-message type="error" message="{{ session('error') }}" />
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-sm text-gray-600">Total Denda</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
                </div>
                <div class="bg-red-100 p-3 text-center rounded-lg">
                    <i class="fas fa-money-bill-wave w-8 h-8 text-red-500 text-3xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500">Total akumulasi denda</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-sm text-gray-600">Belum Dibayar</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalPending, 0, ',', '.') }}</p>
                </div>
                <div class="bg-yellow-100 p-3 text-center rounded-lg">
                    <i class="fas fa-clock w-8 h-8 text-yellow-500 text-3xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500">Denda yang masih pending</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-sm text-gray-600">Sudah Dibayar</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
                </div>
                <div class="bg-green-100 p-3 text-center rounded-lg">
                    <i class="fas fa-check-circle w-8 h-8 text-green-500 text-3xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500">Denda yang sudah lunas</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Daftar Denda</h3>
                    <p class="text-sm text-gray-600 mt-1">Data denda dari pengembalian yang terlambat atau rusak/hilang</p>
                </div>
            </div>

            <!-- Search & Filter -->
            <form method="GET" action="{{ route('denda.index') }}" class="flex items-center justify-between gap-4">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari peminjam, judul buku, atau kode buku..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        >
                        <i class="fas fa-search w-5 h-5 text-gray-400 absolute left-3 top-2.5"></i>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <select name="status" id="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors">
                        Cari
                    </button>
                    @if(request('search') || (request('status') && request('status') != 'all'))
                    <a href="{{ route('denda.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors">
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-cyan-500 text-white">
                        <th class="px-4 py-3 text-center text-sm font-semibold w-16">No</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold w-20">Foto</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Judul Buku</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold w-32">Peminjam</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-28">Kondisi</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-28">Denda</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-28">Status</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-36">Tgl Kembali</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($denda as $index => $return)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-4 text-sm text-gray-900 text-center font-medium">{{ $index + 1 }}</td>
                        <td class="px-4 py-4">
                            @if($return->loan->bookItem->book->foto)
                                <img src="{{ asset('storage/' . $return->loan->bookItem->book->foto) }}"
                                     alt="{{ $return->loan->bookItem->book->judul }}"
                                     class="w-14 h-20 object-cover rounded shadow-sm border border-gray-200">
                            @else
                                <div class="w-14 h-20 bg-gray-100 rounded shadow-sm border border-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-2xl text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $return->loan->bookItem->book->judul }}</div>
                            <div class="text-xs text-gray-500 mt-1">Kode: {{ $return->loan->bookItem->kode_buku }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $return->loan->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $return->loan->user->nomor_identitas }}</div>
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($return->kondisi == 'baik')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1.5"></i>
                                    Baik
                                </span>
                            @elseif($return->kondisi == 'rusak')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                    <i class="fas fa-exclamation-triangle mr-1.5"></i>
                                    Rusak
                                </span>
                            @elseif($return->kondisi == 'hilang')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1.5"></i>
                                    Hilang
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm text-center">
                            <span class="font-semibold text-red-600">Rp {{ number_format($return->denda, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($return->status == 'paid')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1.5"></i>
                                    Lunas
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1.5"></i>
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-900 text-center font-medium">
                            {{ \Carbon\Carbon::parse($return->tanggal_pengembalian)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center space-x-2">
                                <!-- Download Invoice -->
                                <a href="{{ route('pengembalian.invoice', $return->id) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors"
                                   title="Download Invoice">
                                    <i class="fas fa-file-invoice text-sm"></i>
                                </a>

                                <!-- Mark as Paid -->
                                @if($return->status == 'pending')
                                    <form action="{{ route('denda.paid', $return->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center justify-center w-9 h-9 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg transition-colors"
                                                title="Tandai Lunas">
                                            <i class="fas fa-check text-sm"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-money-bill-wave text-4xl text-gray-400"></i>
                                </div>
                                <p class="text-lg font-semibold text-gray-700 mb-1">Tidak Ada Data Denda</p>
                                <p class="text-sm text-gray-500">Belum ada pengembalian dengan denda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
