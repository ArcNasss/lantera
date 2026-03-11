<form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Kategori -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                Kategori <span class="text-red-500">*</span>
            </label>
            <select
                name="category_id"
                id="category_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                required
            >
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
            <label for="nomor_rak" class="block text-sm font-medium text-gray-700 mb-1">
                Nomor Rak <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                name="nomor_rak"
                id="nomor_rak"
                value="{{ old('nomor_rak') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                placeholder="Contoh: A1, B2"
                required
            >
            @error('nomor_rak')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Judul Buku -->
    <div>
        <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">
            Judul Buku <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            name="judul"
            id="judul"
            value="{{ old('judul') }}"
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
        <label for="synopsis" class="block text-sm font-medium text-gray-700 mb-1">
            Sinopsis
        </label>
        <textarea
            name="synopsis"
            id="synopsis"
            rows="3"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
            placeholder="Masukkan sinopsis atau deskripsi buku (opsional)"
        >{{ old('synopsis') }}</textarea>
        @error('synopsis')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Penulis -->
        <div>
            <label for="penulis" class="block text-sm font-medium text-gray-700 mb-1">
                Penulis <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                name="penulis"
                id="penulis"
                value="{{ old('penulis') }}"
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
            <label for="penerbit" class="block text-sm font-medium text-gray-700 mb-1">
                Penerbit <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                name="penerbit"
                id="penerbit"
                value="{{ old('penerbit') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                placeholder="Nama penerbit"
                required
            >
            @error('penerbit')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Tahun -->
        <div>
            <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">
                Tahun Terbit <span class="text-red-500">*</span>
            </label>
            <input
                type="number"
                name="tahun"
                id="tahun"
                value="{{ old('tahun', date('Y')) }}"
                min="1900"
                max="{{ date('Y') + 1 }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                required
            >
            @error('tahun')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Foto -->
    <div>
        <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">
            Foto Cover Buku
        </label>
        <input
            type="file"
            name="foto"
            id="foto"
            accept="image/jpeg,image/png,image/jpg"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
            onchange="previewImage(event)"
        >
        <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
        @error('foto')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror

        <!-- Preview -->
        <div id="preview-container" class="mt-3 hidden">
            <img id="preview-image" src="" alt="Preview" class="w-32 h-40 object-cover rounded-lg border-2 border-gray-300">
        </div>
    </div>

    <!-- Buttons -->
    <div class="flex items-center justify-end space-x-3 pt-4 border-t">
        <button
            type="button"
            @click="$dispatch('close-modal', 'create-book')"
            class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors font-medium"
        >
            Batal
        </button>
        <button
            type="submit"
            class="px-5 py-2.5 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors font-medium"
        >
            Simpan Buku
        </button>
    </div>
</form>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview-image');
        const container = document.getElementById('preview-container');

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
</script>
