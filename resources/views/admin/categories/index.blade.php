@extends('layouts.admin')

@section('title', 'Kategori Buku')
@section('page-title', 'Kategori Buku')

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

    <div class="bg-white-600 rounded-lg shadow">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Kategori Buku</h3>
                <p class="text-sm text-gray-600 mt-1">Manajemen kategori koleksi perpustakaan</p>
            </div>
            <button
                @click="$dispatch('open-modal', 'create-category')"
                class="flex items-center space-x-2 px-5 py-2.5 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors font-medium"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Tambah Kategori</span>
            </button>
        </div>

        <!-- Search & Filter -->
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <form method="GET" action="{{ route('categories.index') }}" class="flex items-center justify-between gap-4">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari kategori..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                        >
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex items-center space-x-2 px-5 py-2.5 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Cari</span>
                    </button>
                    @if(request('search'))
                    <a href="{{ route('categories.index') }}" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors font-medium">
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Total Info -->
        {{-- <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-cyan-50 to-blue-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-cyan-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-medium">TOTAL KATEGORI</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $categories->total() }}</p>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Category Grid -->
        <div class="p-6">
            @forelse($categories as $category)
                @if($loop->first || $loop->index % 3 == 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 {{ $loop->first ? '' : 'mt-6' }}">
                @endif

                <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-xl transition-all">
                    <!-- Header Card -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 font-medium">Kategori</p>
                                <p class="text-xs text-gray-500">{{ $category->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <!-- Toggle Switch -->
                            <div x-data="{ isActive: {{ $category->is_active ? 'true' : 'false' }} }">
                                <button
                                    @click="
                                        isActive = !isActive;
                                        fetch('{{ route('categories.toggle', $category->id) }}', {
                                            method: 'PATCH',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json',
                                                'Content-Type': 'application/json'
                                            }
                                        })
                                    "
                                    :class="isActive ? 'bg-cyan-500' : 'bg-gray-300'"
                                    class="relative inline-flex items-center h-7 rounded-full w-14 transition-colors duration-300 ease-in-out focus:outline-none"
                                >
                                    <span class="sr-only">Toggle status</span>
                                    <span
                                        :class="isActive ? 'translate-x-7' : 'translate-x-1'"
                                        class="inline-block w-6 h-6 transform bg-white rounded-full transition-transform duration-300 ease-in-out shadow-lg"
                                    ></span>
                                    <span
                                        :class="isActive ? 'opacity-100' : 'opacity-0'"
                                        class="absolute left-2 text-xs font-semibold text-white transition-opacity duration-300"
                                    >On</span>
                                    <span
                                        :class="isActive ? 'opacity-0' : 'opacity-100'"
                                        class="absolute right-2 text-xs font-semibold text-gray-600 transition-opacity duration-300"
                                    >Off</span>
                                </button>
                            </div>

                            <!-- Menu 3 titik -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1 hover:bg-gray-100 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-10" style="display: none;">
                                    <button
                                        @click="$dispatch('open-modal', 'edit-category-{{ $category->id }}'); open = false"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    >
                                        Edit Kategori
                                    </button>
                                    <button
                                        @click="$dispatch('open-confirm-delete', { url: '{{ route('categories.destroy', $category->id) }}' }); open = false"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                    >
                                        Hapus Kategori
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Name -->
                    <h3 class="text-lg font-bold text-gray-900 mb-3">{{ $category->nama_kategori }}</h3>

                    <!-- Info -->
                    <div class="space-y-2 mb-4">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Total Buku:</span>
                            <span class="text-cyan-600 font-semibold">{{ $category?->books?->count() ?? 0 }} Buku</span>
                        </p>
                        <p class="text-sm text-gray-600">
                            Dibuat: {{ $category->created_at->format('d/m/Y') }}
                        </p>
                    </div>

                    <!-- Button -->
                    <a href="{{ route('categories.show', $category->id) }}"

                        class="w-full px-4 py-2.5 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors font-medium"
                    >
                        Lihat
                    </a>
                </div>

                @if($loop->last || ($loop->index + 1) % 3 == 0)
                    </div>
                @endif
            @empty
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <p class="text-xl font-semibold text-gray-700 mb-2">Belum ada kategori</p>
                    <p class="text-gray-500 mb-6">Klik tombol "Tambah Kategori" untuk membuat kategori baru</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    Menampilkan {{ $categories->currentPage() }} dari {{ $categories->lastPage() }} halaman
                </p>
                <div class="flex items-center space-x-2">
                    {{-- Previous Button --}}
                    @if ($categories->onFirstPage())
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $categories->previousPageUrl() }}" class="px-3 py-2 text-gray-700 hover:bg-gray-200 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @for ($i = 1; $i <= $categories->lastPage(); $i++)
                        @if ($i == $categories->currentPage())
                            <span class="px-4 py-2 bg-cyan-500 text-white rounded-lg font-medium">{{ $i }}</span>
                        @else
                            <a href="{{ $categories->url($i) }}" class="px-4 py-2 text-gray-700 hover:bg-gray-200 rounded-lg transition-colors">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Next Button --}}
                    @if ($categories->hasMorePages())
                        <a href="{{ $categories->nextPageUrl() }}" class="px-3 py-2 text-gray-700 hover:bg-gray-200 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @else
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        </div
    </div>

    <!-- Modal Create Category -->
    <x-modal name="create-category" title="Tambah Kategori" maxWidth="md">
        @include('admin.categories.partials.create-form')
    </x-modal>

    <!-- Confirm Delete Modal -->
    <x-confirm-delete />
@endsection
