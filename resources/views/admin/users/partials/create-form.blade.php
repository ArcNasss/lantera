<form id="createUserForm" class="space-y-4" action="{{ route('users.store') }}" method="POST">
    @csrf

    <!-- Nama -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
            Nama Lengkap<span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            id="name"
            name="name"
            placeholder="Masukkan nama lengkap"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 @error('name') border-red-500 focus:ring-red-500 @else border-gray-300 focus:ring-cyan-500 @enderror"
            value="{{ old('name') }}"
            required
        >
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Nomor Identitas -->
    <div>
        <label for="nomor_identitas" class="block text-sm font-medium text-gray-700 mb-2">
            Nomor Identitas<span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            id="nomor_identitas"
            name="nomor_identitas"
            placeholder="Masukkan nomor identitas"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 @error('nomor_identitas') border-red-500 focus:ring-red-500 @else border-gray-300 focus:ring-cyan-500 @enderror"
            value="{{ old('nomor_identitas') }}"
            required
        >
        @error('nomor_identitas')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Role & Password in 2 columns -->
    <div class="grid grid-cols-2 gap-4">
        <!-- Role -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                Role<span class="text-red-500">*</span>
            </label>
            <select
                id="role"
                name="role"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 @error('role') border-red-500 focus:ring-red-500 @else border-gray-300 focus:ring-cyan-500 @enderror"
                required
            >
                <option value="">Pilih Role</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
            </select>
            @error('role')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Password<span class="text-red-500">*</span>
            </label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="••••••••"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 @error('password') border-red-500 focus:ring-red-500 @else border-gray-300 focus:ring-cyan-500 @enderror"
                required
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
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
