@extends('layouts.admin')

@section('title', 'Buku Tamu')
@section('page-title', 'Buku Tamu')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Data Buku Tamu</h3>
                    <p class="text-sm text-gray-600 mt-1">Daftar pengunjung perpustakaan</p>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('admin.guest-book.index') }}" class="flex items-center justify-between gap-4">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama pengunjung atau keperluan..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        >
                        <i class="fas fa-search w-5 h-5 text-gray-400 absolute left-3 top-2.5"></i>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors">
                        Cari
                    </button>
                    @if(request('search'))
                    <a href="{{ route('admin.guest-book.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors">
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="m-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-cyan-500 text-white">
                        <th class="px-4 py-3 text-center text-sm font-semibold w-16">No</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold w-48">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Keperluan</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-32">Tanggal</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-24">Jam</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($guestBooks as $index => $guest)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-4 text-sm text-gray-900 text-center font-medium">{{ $index + 1 }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-cyan-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-cyan-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $guest->nama }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            {{ Str::limit($guest->keperluan, 100) }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-900 text-center">
                            <div class="text-sm font-medium">{{ \Carbon\Carbon::parse($guest->created_at)->format('d M Y') }}</div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-900 text-center">
                            <div class="text-sm font-medium">{{ \Carbon\Carbon::parse($guest->created_at)->format('H:i') }}</div>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <button onclick="confirmDelete({{ $guest->id }})" class="text-red-600 hover:text-red-800 transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-book-open text-4xl text-gray-400"></i>
                                </div>
                                <p class="text-lg font-semibold text-gray-700 mb-1">Belum Ada Data</p>
                                <p class="text-sm text-gray-500">Belum ada pengunjung yang mengisi buku tamu</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-trash text-3xl text-red-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Data Buku Tamu?</h3>
                <p class="text-gray-600 mb-6">Data yang dihapus tidak dapat dikembalikan</p>
                <div class="flex space-x-3">
                    <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/admin/guest-book/${id}`;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
@endsection
