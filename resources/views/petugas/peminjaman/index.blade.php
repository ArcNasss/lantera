@extends('layouts.petugas')

@section('title', 'Daftar Peminjaman')
@section('page-title', 'Daftar Peminjaman')

@section('content')
    <!-- Flash Messages -->
    @if(session('success'))
        <x-flash-message type="success" />
    @endif

    @if(session('error'))
        <x-flash-message type="error" message="{{ session('error') }}" />
    @endif

    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Daftar Pengajuan Peminjaman</h3>
                <p class="text-sm text-gray-600 mt-1">Kelola pengajuan peminjaman buku dari peminjam</p>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('peminjaman.index') }}" class="flex items-center justify-between gap-4">
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
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors">
                        Cari
                    </button>
                    @if(request('search') || request('status'))
                    <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors">
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
                        <th class="px-4 py-3 text-left text-sm font-semibold w-32">Kategori</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-28">Status</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-36">Tanggal</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-32">Aksi</th>
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
                                    <i class="fas fa-undo mr-1.5"></i>
                                    Dikembalikan
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-900 text-center font-medium">
                            {{ \Carbon\Carbon::parse($loan->created_at)->format('d M Y H:i') }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-2">
                                @if($loan->status == 'pending')
                                    <!-- Approve Button -->
                                    <form action="{{ route('peminjaman.approve', $loan->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="w-10 h-10 flex items-center justify-center bg-green-100 hover:bg-green-200 text-green-600 rounded-full transition-colors"
                                            title="Setujui"
                                        >
                                            <i class="fas fa-check text-sm"></i>
                                        </button>
                                    </form>

                                    <!-- Reject Button -->
                                    <button
                                        @click="$dispatch('open-modal', 'reject-loan-{{ $loan->id }}')"
                                        class="w-10 h-10 flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-600 rounded-full transition-colors"
                                        title="Tolak"
                                    >
                                        <i class="fas fa-times text-sm"></i>
                                    </button>
                                @else
                                    <div class="flex items-center justify-center gap-2">
                                        @if($loan->status == 'disetujui')
                                            <!-- Download PDF Button -->
                                            <a href="{{ route('peminjaman.download-kartu', $loan->id) }}"
                                               class="w-10 h-10 flex items-center justify-center bg-cyan-100 hover:bg-cyan-200 text-cyan-600 rounded-full transition-colors"
                                               title="Download Kartu Peminjaman"
                                            >
                                                <i class="fas fa-download text-sm"></i>
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-500 italic">Telah ditolak</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>

                    {{-- <!-- Alasan ditolak jika ada -->
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
                    @endif --}}

                    <!-- Modal Reject -->
                    <x-modal name="reject-loan-{{ $loan->id }}" title="Tolak Pengajuan Peminjaman" maxWidth="md">
                        <form action="{{ route('peminjaman.reject', $loan->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-4">
                                    Anda akan menolak pengajuan peminjaman buku <strong>{{ $loan->bookItem->book->judul }}</strong>
                                    oleh <strong>{{ $loan->user->name }}</strong>
                                </p>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Alasan Penolakan <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    name="alasan_ditolak"
                                    rows="3"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    placeholder="Masukkan alasan penolakan..."
                                ></textarea>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button
                                    type="button"
                                    @click="$dispatch('close-modal', 'reject-loan-{{ $loan->id }}')"
                                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors"
                                >
                                    Tolak Pengajuan
                                </button>
                            </div>
                        </form>
                    </x-modal>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-inbox text-4xl text-gray-400"></i>
                                </div>
                                <p class="text-lg font-semibold text-gray-700 mb-1">Tidak Ada Pengajuan</p>
                                <p class="text-sm text-gray-500">Belum ada pengajuan peminjaman yang perlu diproses</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
