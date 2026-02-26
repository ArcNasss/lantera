<!-- Modal Detail Buku -->
<div x-show="showDetail"
     x-cloak
     @click.away="showDetail = false"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity" @click="showDetail = false"></div>

    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div @click.stop class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Close Button -->
            <button @click="showDetail = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-10">
                <i class="fas fa-times text-2xl"></i>
            </button>

            <div class="flex flex-col md:flex-row gap-6 p-6">
                <!-- Book Image -->
                <div class="md:w-1/3">
                    <img :src="selectedBook.foto" :alt="selectedBook.judul" class="w-full h-auto rounded-xl shadow-lg object-cover">

                    <!-- Stock Badge -->
                    <div class="mt-4">
                        <span :class="selectedBook.stok > 0 ? 'bg-green-500' : 'bg-red-500'"
                              class="inline-block px-4 py-2 text-white text-sm font-bold rounded-lg w-full text-center">
                            <i class="fas fa-box mr-2"></i>
                            <span x-text="selectedBook.stok > 0 ? 'Tersedia (' + selectedBook.stok + ' buku)' : 'Stok Habis'"></span>
                        </span>
                    </div>
                </div>

                <!-- Book Details -->
                <div class="md:w-2/3">
                    <!-- Category Badge -->
                    <span class="inline-block px-3 py-1 bg-cyan-100 text-cyan-700 text-sm font-medium rounded-lg mb-3">
                        <i class="fas fa-tag mr-1"></i>
                        <span x-text="selectedBook.kategori"></span>
                    </span>

                    <!-- Title -->
                    <h2 class="text-3xl font-bold text-gray-900 mb-2" x-text="selectedBook.judul"></h2>

                    <!-- Meta Info -->
                    <div class="space-y-2 mb-4">
                        <p class="text-gray-600 flex items-center">
                            <i class="fas fa-user w-5 mr-2"></i>
                            <span class="font-medium mr-2">Penulis:</span>
                            <span x-text="selectedBook.penulis"></span>
                        </p>
                        <p class="text-gray-600 flex items-center">
                            <i class="fas fa-building w-5 mr-2"></i>
                            <span class="font-medium mr-2">Penerbit:</span>
                            <span x-text="selectedBook.penerbit"></span>
                        </p>
                        <p class="text-gray-600 flex items-center">
                            <i class="fas fa-calendar w-5 mr-2"></i>
                            <span class="font-medium mr-2">Tahun:</span>
                            <span x-text="selectedBook.tahun"></span>
                        </p>
                        <p class="text-gray-600 flex items-center">
                            <i class="fas fa-barcode w-5 mr-2"></i>
                            <span class="font-medium mr-2">Kode Buku:</span>
                            <span x-text="selectedBook.kode"></span>
                        </p>
                    </div>

                    <!-- Synopsis -->
                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Sinopsis</h3>
                        <p class="text-gray-600 leading-relaxed" x-text="selectedBook.synopsis"></p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 mt-6">
                        <form :action="'/cart/' + selectedBook.id" method="POST" class="flex-1">
                            @csrf
                            <button
                                type="submit"
                                class="w-full px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg font-semibold transition-colors flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="selectedBook.stok === 0">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
