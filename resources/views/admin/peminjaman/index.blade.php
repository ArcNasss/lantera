@extends('layouts.admin')

@section('title', 'Daftar Peminjaman')
@section('page-title', 'Daftar Peminjaman')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Daftar Peminjaman Buku</h3>
                    <p class="text-sm text-gray-600 mt-1">Pantau semua data peminjaman buku</p>
                </div>
                <button onclick="openExportModal()" class="flex items-center space-x-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-file-excel"></i>
                    <span>Export Excel</span>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-cyan-500 text-white">
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider w-16">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-20">Foto</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Judul Buku</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-32">Peminjam</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-32">Kategori</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider w-28">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider w-36">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($loans as $index => $loan)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-4 text-sm text-gray-900 text-center font-medium">{{ $index + 1 }}</td>
                        <td class="px-4 py-4">
                            @if($loan->bookItem->book->foto)
                                <img src="{{ asset('storage/' . $loan->bookItem->book->foto) }}"
                                     alt="{{ $loan->bookItem->book->judul }}"
                                     class="w-14 h-20 object-cover rounded shadow-sm border border-gray-200">
                            @else
                                <div class="w-14 h-20 bg-gray-100 rounded shadow-sm border border-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-2xl text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $loan->bookItem->book->judul }}</div>
                            <div class="text-xs text-gray-500 mt-1">Kode: {{ $loan->bookItem->kode_buku }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $loan->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $loan->user->nomor_identitas }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ $loan->bookItem->book->category->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($loan->status == 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1.5"></i>
                                    Pending
                                </span>
                            @elseif($loan->status == 'disetujui')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    <i class="fas fa-check-circle mr-1.5"></i>
                                    Disetujui
                                </span>
                            @elseif($loan->status == 'ditolak')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1.5"></i>
                                    Ditolak
                                </span>
                            @elseif($loan->status == 'dikembalikan')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-double mr-1.5"></i>
                                    Dikembalikan
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-900 text-center font-medium">
                            {{ \Carbon\Carbon::parse($loan->created_at)->format('d M Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-inbox text-4xl text-gray-400"></i>
                                </div>
                                <p class="text-lg font-semibold text-gray-700 mb-1">Tidak Ada Peminjaman</p>
                                <p class="text-sm text-gray-500">Belum ada data peminjaman buku</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

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
