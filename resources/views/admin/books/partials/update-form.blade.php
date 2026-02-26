<div x-data="{ activeTab: 'info', items: {{ json_encode($book->bookItems) }}, editingItem: null, newItem: { kode_buku: '' } }">
    <!-- Tabs -->
    <div class="flex border-b mb-4">
        <button
            type="button"
            @click="activeTab = 'info'"
            :class="activeTab === 'info' ? 'border-b-2 border-cyan-500 text-cyan-600' : 'text-gray-500 hover:text-gray-700'"
            class="px-4 py-2 font-medium text-sm transition-colors"
        >
            <i class="fas fa-info-circle mr-1"></i> Info Buku
        </button>
        <button
            type="button"
            @click="activeTab = 'items'"
            :class="activeTab === 'items' ? 'border-b-2 border-cyan-500 text-cyan-600' : 'text-gray-500 hover:text-gray-700'"
            class="px-4 py-2 font-medium text-sm transition-colors"
        >
            <i class="fas fa-barcode mr-1"></i> Kelola Item (<span x-text="items.length"></span>)
        </button>
    </div>

    <!-- Tab Content: Info Buku -->
    <div x-show="activeTab === 'info'" x-cloak class="space-y-4">
        <form method="POST" action="{{ route('books.update', $book->id) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Kategori -->
                <div>
                    <label for="category_id_{{ $book->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="category_id"
                        id="category_id_{{ $book->id }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        required
                    >
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Rak -->
                <div>
                    <label for="nomor_rak_{{ $book->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                        Nomor Rak <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nomor_rak"
                        id="nomor_rak_{{ $book->id }}"
                        value="{{ old('nomor_rak', $book->nomor_rak) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        placeholder="Contoh: A-01"
                        required
                    >
                    @error('nomor_rak')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Judul Buku -->
            <div>
                <label for="judul_{{ $book->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                    Judul Buku <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="judul"
                    id="judul_{{ $book->id }}"
                    value="{{ old('judul', $book->judul) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                    placeholder="Masukkan judul buku"
                    required
                >
                @error('judul')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sinopsis -->
            <div>
                <label for="synopsis_{{ $book->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                    Sinopsis
                </label>
                <textarea
                    name="synopsis"
                    id="synopsis_{{ $book->id }}"
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                    placeholder="Masukkan sinopsis atau deskripsi buku (opsional)"
                >{{ old('synopsis', $book->synopsis) }}</textarea>
                @error('synopsis')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Penulis -->
                <div>
                    <label for="penulis_{{ $book->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                        Penulis <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="penulis"
                        id="penulis_{{ $book->id }}"
                        value="{{ old('penulis', $book->penulis) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        placeholder="Nama penulis"
                        required
                    >
                    @error('penulis')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penerbit -->
                <div>
                    <label for="penerbit_{{ $book->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                        Penerbit <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="penerbit"
                        id="penerbit_{{ $book->id }}"
                        value="{{ old('penerbit', $book->penerbit) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        placeholder="Nama penerbit"
                        required
                    >
                    @error('penerbit')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tahun -->
            <div>
                <label for="tahun_{{ $book->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                    Tahun Terbit <span class="text-red-500">*</span>
                </label>
                <input
                    type="number"
                    name="tahun"
                    id="tahun_{{ $book->id }}"
                    value="{{ old('tahun', $book->tahun) }}"
                    min="1900"
                    max="{{ date('Y') + 1 }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                    required
                >
                @error('tahun')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto -->
            <div>
                <label for="foto_{{ $book->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                    Foto Cover Buku
                </label>

                @if($book->foto)
                    <div class="mb-3">
                        <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                        <img src="{{ Storage::url($book->foto) }}" alt="{{ $book->judul }}" class="w-32 h-40 object-cover rounded-lg border-2 border-gray-300">
                    </div>
                @endif

                <input
                    type="file"
                    name="foto"
                    id="foto_{{ $book->id }}"
                    accept="image/jpeg,image/png,image/jpg"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                    onchange="previewUpdateImage{{ $book->id }}(event)"
                >
                <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</p>
                @error('foto')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <!-- Preview -->
                <div id="preview-update-container-{{ $book->id }}" class="mt-3 hidden">
                    <p class="text-sm text-gray-600 mb-2">Preview foto baru:</p>
                    <img id="preview-update-image-{{ $book->id }}" src="" alt="Preview" class="w-32 h-40 object-cover rounded-lg border-2 border-cyan-300">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <button
                    type="button"
                    @click="$dispatch('close-modal', 'edit-book-{{ $book->id }}')"
                    class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors font-medium"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-5 py-2.5 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors font-medium"
                >
                    Update Buku
                </button>
            </div>
        </form>
    </div>

    <!-- Tab Content: Kelola Item -->
    <div x-show="activeTab === 'items'" x-cloak class="space-y-4">
        <!-- Add New Item Form -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <h4 class="text-sm font-semibold text-gray-900 mb-3">
                <i class="fas fa-plus-circle text-green-600 mr-1"></i> Tambah Item Baru
            </h4>
            <div class="flex gap-2">
                <input
                    type="text"
                    x-model="newItem.kode_buku"
                    placeholder="Kode Buku (contoh: BK-001)"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                <button
                    type="button"
                    @click="addItem()"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium"
                >
                    <i class="fas fa-plus mr-1"></i> Tambah
                </button>
            </div>
        </div>

        <!-- Items List -->
        <div class="space-y-2 max-h-96 overflow-y-auto">
            <template x-for="(item, index) in items" :key="item.id">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <!-- View Mode -->
                    <div x-show="editingItem !== item.id" class="flex items-center justify-between w-full">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-cyan-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-barcode text-cyan-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900" x-text="item.kode_buku"></p>
                                <p class="text-xs text-gray-500">
                                    Status: 
                                    <span :class="{
                                        'text-green-600': item.status === 'available',
                                        'text-yellow-600': item.status === 'borrowed',
                                        'text-orange-600': item.status === 'damaged',
                                        'text-red-600': item.status === 'lost'
                                    }" class="font-medium" x-text="item.status === 'available' ? 'Tersedia' : item.status === 'borrowed' ? 'Dipinjam' : item.status === 'damaged' ? 'Rusak' : 'Hilang'"></span>
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-1">
                            <button
                                type="button"
                                @click="editingItem = item.id"
                                class="p-2 hover:bg-yellow-100 text-yellow-600 rounded transition-colors"
                            >
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            <button
                                type="button"
                                @click="deleteItem(item.id, index)"
                                :disabled="item.status === 'borrowed'"
                                :class="item.status === 'borrowed' ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-100'"
                                class="p-2 text-red-600 rounded transition-colors"
                            >
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Edit Mode -->
                    <div x-show="editingItem === item.id" class="w-full">
                        <div class="flex gap-2 mb-2">
                            <input
                                type="text"
                                x-model="item.kode_buku"
                                class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                            >
                            <select
                                x-model="item.status"
                                class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                            >
                                <option value="available">Tersedia</option>
                                <option value="borrowed">Dipinjam</option>
                                <option value="damaged">Rusak</option>
                                <option value="lost">Hilang</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button
                                type="button"
                                @click="updateItem(item)"
                                class="px-3 py-1 bg-cyan-600 hover:bg-cyan-700 text-white text-sm rounded-lg transition-colors"
                            >
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                            <button
                                type="button"
                                @click="editingItem = null"
                                class="px-3 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm rounded-lg transition-colors"
                            >
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </template>

            <div x-show="items.length === 0" class="text-center py-8 text-gray-500">
                <i class="fas fa-inbox text-3xl mb-2"></i>
                <p class="text-sm">Belum ada item untuk buku ini</p>
            </div>
        </div>
    </div>
</div>

<script>
    function previewUpdateImage{{ $book->id }}(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview-update-image-{{ $book->id }}');
        const container = document.getElementById('preview-update-container-{{ $book->id }}');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            container.classList.add('hidden');
        }
    }

    function addItem() {
        if (!this.newItem.kode_buku) {
            alert('Kode buku tidak boleh kosong');
            return;
        }

        fetch('{{ route("book-items.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                book_id: {{ $book->id }},
                kode_buku: this.newItem.kode_buku
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Gagal menambahkan item');
            }
        })
        .catch(err => alert('Terjadi kesalahan'));
    }

    function updateItem(item) {
        fetch(`/admin/book-items/${item.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                kode_buku: item.kode_buku,
                status: item.status
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                this.editingItem = null;
                alert(data.message);
            } else {
                alert(data.message || 'Gagal mengupdate item');
            }
        })
        .catch(err => alert('Terjadi kesalahan'));
    }

    function deleteItem(itemId, index) {
        if (!confirm('Yakin ingin menghapus item ini?')) return;

        fetch(`/admin/book-items/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                this.items.splice(index, 1);
                alert(data.message);
            } else {
                alert(data.message || 'Gagal menghapus item');
            }
        })
        .catch(err => alert('Terjadi kesalahan'));
    }
</script>
