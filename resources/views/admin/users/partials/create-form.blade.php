<div x-data="{
    errors: {},
    isSubmitting: false,

    submitForm(event) {
        event.preventDefault();
        this.errors = {};
        this.isSubmitting = true;

        const formData = new FormData(event.target);

        fetch('{{ route('users.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else if (data.errors) {
                this.errors = data.errors;
                this.isSubmitting = false;
            }
        })
        .catch(err => {
            console.error(err);
            this.isSubmitting = false;
        });
    }
}">
<form @submit="submitForm" class="space-y-4">

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
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 border-gray-300 focus:ring-cyan-500"
            :class="errors.name ? 'border-red-500 focus:ring-red-500' : ''"
            required
        >
        <p x-show="errors.name" x-text="errors.name ? errors.name[0] : ''" class="mt-1 text-sm text-red-600"></p>
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
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 border-gray-300 focus:ring-cyan-500"
            :class="errors.nomor_identitas ? 'border-red-500 focus:ring-red-500' : ''"
            required
        >
        <p x-show="errors.nomor_identitas" x-text="errors.nomor_identitas ? errors.nomor_identitas[0] : ''" class="mt-1 text-sm text-red-600"></p>
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
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 border-gray-300 focus:ring-cyan-500"
                :class="errors.role ? 'border-red-500 focus:ring-red-500' : ''"
                required
            >
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
                <option value="peminjam">Peminjam</option>
            </select>
            <p x-show="errors.role" x-text="errors.role ? errors.role[0] : ''" class="mt-1 text-sm text-red-600"></p>
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
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 border-gray-300 focus:ring-cyan-500"
                :class="errors.password ? 'border-red-500 focus:ring-red-500' : ''"
                required
            >
            <p x-show="errors.password" x-text="errors.password ? errors.password[0] : ''" class="mt-1 text-sm text-red-600"></p>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end pt-4">
        <button
            type="submit"
            :disabled="isSubmitting"
            class="px-6 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed"
        >
            <span x-show="!isSubmitting">Simpan</span>
            <span x-show="isSubmitting">Menyimpan...</span>
        </button>
    </div>
</form>
</div>
