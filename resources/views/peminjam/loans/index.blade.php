@extends('layouts.peminjam')

@section('title', 'Riwayat Peminjaman')
@section('page-title', 'Riwayat Peminjaman')

@section('content')
    <!-- Flash Messages -->
    @if(session('success'))
        <x-flash-message type="success" />
    @endif

    @if(session('deleted'))
        <x-flash-message type="deleted" />
    @endif

    @if(session('updated'))
        <x-flash-message type="updated" />
    @endif

    @if(session('error'))
        <x-flash-message type="error" message="{{ session('error') }}" />
    @endif

    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Riwayat Peminjaman Saya</h3>
                <p class="text-sm text-gray-600 mt-1">Daftar semua riwayat peminjaman buku Anda</p>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-32">Kategori</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider w-28">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-32">Petugas</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider w-36">Tgl Pinjam</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider w-36">Tgl Kembali</th>
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
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ $loan->bookItem->book->category->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($loan->status == 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1.5"></i>
                                    Pending
                                </span>
                            @elseif($loan->status == 'disetujui')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-check-circle mr-1.5"></i>
                                    Disetujui
                                </span>
                            @elseif($loan->status == 'dikembalikan')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-check-double mr-1.5"></i>
                                    Dikembalikan
                                </span>
                            @elseif($loan->status == 'ditolak')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1.5"></i>
                                    Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $loan->status }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            {{ $loan->petugas->name ?? '-' }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-900 text-center font-medium">
                            {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-4 text-sm text-center">
                            @if($loan->tanggal_kembali)
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}</span>
                            @else
                                <span class="text-gray-400 italic">Belum dikembalikan</span>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Alasan ditolak jika ada -->
                    @if($loan->status == 'ditolak' && $loan->alasan_ditolak)
                    <tr class="bg-red-50">
                        <td colspan="8" class="px-4 py-3">
                            <div class="flex items-start space-x-2">
                                <i class="fas fa-info-circle text-red-500 mt-0.5"></i>
                                <div>
                                    <span class="text-sm font-medium text-red-800">Alasan Ditolak:</span>
                                    <span class="text-sm text-red-700 ml-2">{{ $loan->alasan_ditolak }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-book-reader text-4xl text-gray-400"></i>
                                </div>
                                <p class="text-lg font-semibold text-gray-700 mb-1">Belum Ada Riwayat Peminjaman</p>
                                <p class="text-sm text-gray-500">Anda belum memiliki riwayat peminjaman buku</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
