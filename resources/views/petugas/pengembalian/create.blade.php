@extends('layouts.petugas')

@section('title', 'Pengembalian Buku')
@section('page-title', 'Pengembalian Buku')

@section('content')
    <!-- Flash Messages -->
    @if(session('success'))
        <x-flash-message type="success" />
    @endif

    @if(session('error'))
        <x-flash-message type="error" message="{{ session('error') }}" />
    @endif

    <div class="max-w-4xl mx-auto">
        <!-- Search Card -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Cari ID Peminjaman</h3>
                <p class="text-sm text-gray-600 mt-1">Masukkan ID peminjaman untuk memproses pengembalian</p>
            </div>
            <div class="p-6">
                <form action="{{ route('pengembalian.search') }}" method="POST">
                    @csrf
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <input
                                type="number"
                                name="loan_id"
                                value="{{ request('loan_id') ?? (isset($loan) ? $loan->id : '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                placeholder="Masukkan ID Peminjaman"
                                required
                            >
                        </div>
                        <button
                            type="submit"
                            class="px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors flex items-center gap-2"
                        >
                            <i class="fas fa-search"></i>
                            <span>Cari</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(isset($loan))
        <!-- Detail & Form Pengembalian -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Detail Peminjaman</h3>
                <p class="text-sm text-gray-600 mt-1">Informasi peminjaman yang akan dikembalikan</p>
            </div>

            <div class="p-6">
                <!-- Info Peminjaman -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <div class="flex items-start gap-4">
                            @if($loan->bookItem->book->foto)
                                <img src="{{ asset('storage/' . $loan->bookItem->book->foto) }}"
                                     alt="{{ $loan->bookItem->book->judul }}"
                                     class="w-20 h-28 object-cover rounded shadow-sm border border-gray-200">
                            @else
                                <div class="w-20 h-28 bg-gray-200 rounded shadow-sm border border-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-3xl text-gray-400"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-1">{{ $loan->bookItem->book->judul }}</h4>
                                <p class="text-sm text-gray-600">Kode: {{ $loan->bookItem->kode_buku }}</p>
                                <p class="text-sm text-gray-600">Kategori: {{ $loan->bookItem->book->category->nama_kategori }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm text-gray-600">Peminjam</p>
                            <p class="font-semibold text-gray-900">{{ $loan->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $loan->user->nomor_identitas }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Pinjam</p>
                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Harus Kembali</p>
                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                Disetujui
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Form Pengembalian -->
                <form action="{{ route('pengembalian.store') }}" method="POST" x-data="{
                    kondisi: 'baik',
                    tanggalKembali: '{{ $loan->tanggal_kembali }}',
                    get daysLate() {
                        const kembali = new Date(this.tanggalKembali);
                        const sekarang = new Date();
                        const diff = Math.floor((sekarang - kembali) / (1000 * 60 * 60 * 24));
                        return diff > 0 ? diff : 0;
                    },
                    get dendaKeterlambatan() {
                        return this.daysLate * 2000;
                    },
                    get dendaKondisi() {
                        if (this.kondisi === 'rusak') return 100000;
                        if (this.kondisi === 'hilang') return 100000;
                        return 0;
                    },
                    get totalDenda() {
                        return this.dendaKeterlambatan + this.dendaKondisi;
                    }
                }">
                    @csrf
                    <input type="hidden" name="loan_id" value="{{ $loan->id }}">

                    <!-- Info Denda Otomatis -->
                    <div x-show="daysLate > 0 || kondisi !== 'baik'" class="mb-6 p-4 bg-cyan-50 border-l-4 border-cyan-500 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-cyan-600 mt-0.5 mr-3"></i>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-cyan-800 mb-2">Informasi Denda</p>
                                <ul class="text-sm text-cyan-700 space-y-1">
                                    <li x-show="daysLate > 0">
                                        <strong>Terlambat:</strong> Rp 2.000 per hari × <span x-text="daysLate"></span> hari = <strong x-text="'Rp ' + dendaKeterlambatan.toLocaleString('id-ID')"></strong>
                                    </li>
                                    <li x-show="kondisi === 'rusak' || kondisi === 'hilang'">
                                        <strong x-text="kondisi === 'rusak' ? 'Rusak' : 'Hilang'"></strong>: <strong>Rp 100.000</strong>
                                    </li>
                                    <li x-show="kondisi === 'baik' && daysLate === 0">
                                        <strong>Dikembalikan/Rusak:</strong> Tidak ada denda
                                    </li>
                                </ul>
                                <div class="mt-3 pt-3 border-t border-cyan-200">
                                    <p class="text-base font-bold text-cyan-900">
                                        Estimasi Denda: <span x-text="'Rp ' + totalDenda.toLocaleString('id-ID')" class="text-red-600"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Kondisi Buku <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-4">
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="kondisi" value="baik" class="peer sr-only" required checked x-model="kondisi">
                                    <div class="p-4 border-2 rounded-lg transition-all peer-checked:border-cyan-500 peer-checked:bg-cyan-50 border-gray-300 hover:border-cyan-300">
                                        <div class="text-center">
                                            <div class="w-12 h-12 mx-auto mb-2 rounded-full flex items-center justify-center bg-cyan-100 peer-checked:bg-cyan-500 text-cyan-600 peer-checked:text-white transition-colors">
                                                <i class="fas fa-check text-xl"></i>
                                            </div>
                                            <p class="font-semibold text-gray-700 peer-checked:text-cyan-600">Baik</p>
                                        </div>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="kondisi" value="rusak" class="peer sr-only" x-model="kondisi">
                                    <div class="p-4 border-2 rounded-lg transition-all peer-checked:border-yellow-500 peer-checked:bg-yellow-50 border-gray-300 hover:border-yellow-300">
                                        <div class="text-center">
                                            <div class="w-12 h-12 mx-auto mb-2 rounded-full flex items-center justify-center bg-yellow-100 peer-checked:bg-yellow-500 text-yellow-600 peer-checked:text-white transition-colors">
                                                <i class="fas fa-exclamation-triangle text-xl"></i>
                                            </div>
                                            <p class="font-semibold text-gray-700 peer-checked:text-yellow-600">Rusak</p>
                                        </div>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="kondisi" value="hilang" class="peer sr-only" x-model="kondisi">
                                    <div class="p-4 border-2 rounded-lg transition-all peer-checked:border-red-500 peer-checked:bg-red-50 border-gray-300 hover:border-red-300">
                                        <div class="text-center">
                                            <div class="w-12 h-12 mx-auto mb-2 rounded-full flex items-center justify-center bg-red-100 peer-checked:bg-red-500 text-red-600 peer-checked:text-white transition-colors">
                                                <i class="fas fa-times text-xl"></i>
                                            </div>
                                            <p class="font-semibold text-gray-700 peer-checked:text-red-600">Hilang</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <input type="hidden" name="denda" :value="totalDenda">
                    </div>

                    <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                        <a
                            href="{{ route('peminjaman.riwayat') }}"
                            class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors"
                        >
                            Batal
                        </a>
                        <button
                            type="submit"
                            class="px-6 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors flex items-center gap-2"
                        >
                            <i class="fas fa-check"></i>
                            <span>Proses Pengembalian</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
@endsection
