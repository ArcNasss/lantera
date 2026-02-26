@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')
    <!-- Flash Messages -->
    @if(session('success'))
        <x-flash-message type="success" />
    @endif

    @if(session('deleted'))
        <x-flash-message type="deleted" />
    @endif

    @if(session('updated'))
        <x-flash-message type="updated" />
    @endif

    @if(session('error'))
        <x-flash-message type="error" message="{{ session('error') }}" />
    @endif

    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Kelola User</h3>
                <p class="text-sm text-gray-600 mt-1">Manajemen data pengguna sistem</p>
            </div>
            <button
                @click="$dispatch('open-modal', 'create-user')"
                class="flex items-center space-x-2 px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors"
            >
                <i class="fas fa-plus w-5 h-5"></i>
                <span>Tambah User</span>
            </button>
        </div>

        <!-- Search & Filter -->
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('users.index') }}" class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0 gap-3">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama atau NISN..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        >
                        <i class="fas fa-search w-5 h-5 text-gray-400 absolute left-3 top-2.5"></i>
                    </div>
                </div>
                <div class="flex gap-2">
                    <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Semua Role</option>
                        <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="peminjam" {{ request('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                    </select>
                    <button type="submit" class="flex items-center space-x-2 px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors">
                        <i class="fas fa-search w-5 h-5"></i>
                        <span>Cari</span>
                    </button>
                    @if(request('search') || request('role'))
                    <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors">
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
                        <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Nama</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Nomor identitas</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Role</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal Daftar</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users ?? [] as $index => $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->nomor_identitas }}</td>
                        <td class="px-6 py-4">
                            @php
                                $roleColors = [
                                    'admin' => 'bg-red-100 text-red-700',
                                    'petugas' => 'bg-green-100 text-green-700',
                                    'peminjam' => 'bg-blue-100 text-blue-700'
                                ];
                            @endphp
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $roleColors[$user->role] }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Edit -->
                                <button
                                @click="$dispatch('open-modal','update-user-{{ $user->id }}' )"
                                 class="w-8 h-8 flex items-center justify-center bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg transition-colors">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <!-- Delete -->
                                <button
                                    type="button"
                                    @click="$dispatch('open-confirm-delete', { url: '{{ route('users.destroy', $user->id) }}' })"
                                    class="w-8 h-8 flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors"
                                >
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Edit for this user -->
                    <x-modal name="update-user-{{ $user->id }}" title="Edit User" maxWidth="md">
                        @include('admin.users.partials.update-form', ['user' => $user])
                    </x-modal>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-users w-16 h-16 mx-auto text-gray-400 mb-4 block text-6xl"></i>
                            <p class="text-lg font-medium">Tidak ada data user</p>
                            <p class="text-sm mt-1">Klik tombol "Tambah User" untuk menambahkan user baru</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    Menampilkan 1 dari 32 halaman
                </p>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-2 text-gray-500 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-chevron-left w-5 h-5"></i>
                    </button>

                    <button class="px-4 py-2 bg-cyan-500 text-white rounded-lg">1</button>
                    <button class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">2</button>
                    <button class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">3</button>
                    <span class="px-2 text-gray-500">...</span>
                    <button class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">99</button>

                    <button class="px-3 py-2 text-gray-500 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-chevron-right w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <x-modal name="create-user" title="Tambah User" maxWidth="md">
        @include('admin.users.partials.create-form')
    </x-modal>

    <!-- Confirm Delete Modal -->
    <x-confirm-delete />
@endsection
