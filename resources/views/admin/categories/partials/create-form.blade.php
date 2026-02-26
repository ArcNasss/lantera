<form id="createCategoryForm" class="space-y-4" action="{{ route('categories.store') }}" method="POST">
    @csrf

    <!-- Nama -->
    <div>
        <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-2">
            Nama Kategori<span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            id="nama_kategori"
            name="nama_kategori"
            placeholder="Masukkan nama kategori"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 @error('nama_kategori') border-red-500 focus:ring-red-500 @else border-gray-300 focus:ring-cyan-500 @enderror"
            required
        >
        @error('nama_kategori')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end pt-4">
        <button
            type="submit"
            class="px-6 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors font-medium"
        >
            Simpan
        </button>
    </div>
</form>
