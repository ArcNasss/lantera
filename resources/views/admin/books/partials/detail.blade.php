<div class="space-y-4">
    <!-- Foto Cover -->
    @if($book->foto)
        <div class="flex justify-center mb-4">
            <img src="{{ Storage::url($book->foto) }}" alt="{{ $book->judul }}" class="w-48 h-64 object-cover rounded-lg border-2 border-gray-300 shadow-md">
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Kategori -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <div class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-900">
                {{ $book->category->nama_kategori }}
            </div>
        </div>

        <!-- Nomor Rak -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Rak</label>
            <div class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-900">
                {{ $book->nomor_rak }}
            </div>
        </div>
    </div>

    <!-- Judul Buku -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Buku</label>
        <div class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-900">
            {{ $book->judul }}
        </div>
    </div>

    <!-- Sinopsis -->
    @if($book->synopsis)
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Sinopsis</label>
        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 text-justify leading-relaxed min-h-20">
            {{ $book->synopsis }}
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Penulis -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Penulis</label>
            <div class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-900">
                {{ $book->penulis }}
            </div>
        </div>

        <!-- Penerbit -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Penerbit</label>
            <div class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-900">
                {{ $book->penerbit }}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Tahun -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Terbit</label>
            <div class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-900">
                {{ $book->tahun }}
            </div>
        </div>

        <!-- Total Stok -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Total Item</label>
            <div class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                @php
                    $availableCount = $book->availableItems()->count();
                    $totalCount = $book->bookItems()->count();
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-cyan-100 text-cyan-700">
                    <i class="fas fa-book mr-2"></i>{{ $availableCount }}/{{ $totalCount }} tersedia
                </span>
            </div>
        </div>
    </div>

    <!-- Book Items List -->
    <div class="border-t pt-4 mt-4">
        <div class="flex items-center justify-between mb-3">
            <h4 class="text-sm font-semibold text-gray-900">Daftar Item Buku</h4>
            <span class="text-xs text-gray-500">Total: {{ $book->bookItems()->count() }} item</span>
        </div>

        <div class="space-y-2 max-h-60 overflow-y-auto">
            @forelse($book->bookItems as $item)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-cyan-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-barcode text-cyan-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $item->kode_buku }}</p>
                            <p class="text-xs text-gray-500">
                                Status:
                                @if($item->status === 'available')
                                    <span class="text-green-600 font-medium">Tersedia</span>
                                @elseif($item->status === 'borrowed')
                                    <span class="text-yellow-600 font-medium">Dipinjam</span>
                                @elseif($item->status === 'damaged')
                                    <span class="text-orange-600 font-medium">Rusak</span>
                                @else
                                    <span class="text-red-600 font-medium">Hilang</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-3xl mb-2"></i>
                    <p class="text-sm">Belum ada item untuk buku ini</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
<div class="flex justify-end mt-6">
    <button
        @click="$dispatch('close-modal', 'detail-book-{{ $book->id }}')"
        class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors font-medium"
    >
        Tutup
    </button>
</div>
