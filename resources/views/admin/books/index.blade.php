@extends('layouts.admin')

@section('title', 'Kelola Buku')
@section('page-title', 'Kelola Buku')

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
                <h3 class="text-xl font-bold text-gray-900">Kelola Buku</h3>
                <p class="text-sm text-gray-600 mt-1">Manajemen data buku perpustakaan</p>
            </div>
            <button
                @click="$dispatch('open-modal', 'create-book')"
                class="flex items-center space-x-2 px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors"
            >
                <i class="fas fa-plus w-5 h-5"></i>
                <span>Tambah Data</span>
            </button>
        </div>

        <!-- Search & Filter -->
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('books.index') }}" class="flex items-center justify-between gap-4">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        >
                        <i class="fas fa-search w-5 h-5 text-gray-400 absolute left-3 top-2.5"></i>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <select name="category_id" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors">
                        Cari
                    </button>
                    @if(request('search') || request('category_id'))
                    <a href="{{ route('books.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors">
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
                        <th class="px-6 py-4 text-left text-sm font-semibold">Foto</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Judul</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Kategori</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Penulis</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Penerbit</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tahun</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Stok</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($books as $index => $book)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $books->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            @if($book->foto)
                                <img src="{{ asset('storage/' . $book->foto) }}" alt="{{ $book->judul }}" class="w-12 h-16 object-cover rounded border border-gray-300">
                            @else
                                <div class="w-12 h-16 bg-gray-200 rounded border border-gray-300 flex items-center justify-center">
                                    <i class="fas fa-image w-6 h-6 text-gray-400 text-xl"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $book->judul }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $book->category->nama_kategori }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $book->penulis }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $book->penerbit }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $book->tahun }}</td>
                        <td class="px-6 py-4">
                            @php
                                $availableCount = $book->availableItems()->count();
                                $totalCount = $book->bookItems()->count();
                            @endphp
                            @if($availableCount > 0)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                    {{ $availableCount }}/{{ $totalCount }}
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                    Habis
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Detail -->
                                <button
                                    @click="$dispatch('open-modal', 'detail-book-{{ $book->id }}')"
                                    class="w-8 h-8 flex items-center justify-center bg-cyan-100 hover:bg-cyan-200 text-cyan-600 rounded-lg transition-colors"
                                >
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                                <!-- Edit -->
                                <button
                                    @click="$dispatch('open-modal','edit-book-{{ $book->id }}')"
                                    class="w-8 h-8 flex items-center justify-center bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg transition-colors"
                                >
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <!-- Delete -->
                                <button
                                    type="button"
                                    @click="$dispatch('open-confirm-delete', { url: '{{ route('books.destroy', $book->id) }}' })"
                                    class="w-8 h-8 flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors"
                                >
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Detail for this book -->
                    <x-modal name="detail-book-{{ $book->id }}" title="Detail Buku" maxWidth="2xl">
                        @include('admin.books.partials.detail', ['book' => $book])
                    </x-modal>

                    <!-- Modal Edit for this book -->
                    <x-modal name="edit-book-{{ $book->id }}" title="Edit Buku" maxWidth="2xl">
                        @include('admin.books.partials.update-form', ['book' => $book, 'categories' => $categories])
                    </x-modal>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-book w-16 h-16 mx-auto text-gray-400 mb-4 block text-6xl"></i>
                            <p class="text-lg font-medium">Tidak ada data buku</p>
                            <p class="text-sm mt-1">Klik tombol "Tambah Data" untuk menambahkan buku baru</p>
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
                    Menampilkan {{ $books->currentPage() }} dari {{ $books->lastPage() }} halaman
                </p>
                <div class="flex items-center space-x-2">
                    {{-- Previous Button --}}
                    @if ($books->onFirstPage())
                        <button disabled class="px-3 py-2 text-gray-400 cursor-not-allowed rounded-lg">
                            <i class="fas fa-chevron-left w-5 h-5"></i>
                        </button>
                    @else
                        <a href="{{ $books->previousPageUrl() }}" class="px-3 py-2 text-gray-500 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-chevron-left w-5 h-5"></i>
                        </a>
                    @endif

                    {{-- Page Numbers (First 3, ..., Last) --}}
                    @php
                        $start = max(1, $books->currentPage() - 1);
                        $end = min($books->lastPage(), $books->currentPage() + 1);
                    @endphp

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $books->currentPage())
                            <button class="px-4 py-2 bg-cyan-500 text-white rounded-lg">{{ $i }}</button>
                        @else
                            <a href="{{ $books->url($i) }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($end < $books->lastPage() - 1)
                        <span class="px-2 text-gray-500">...</span>
                    @endif

                    @if($end < $books->lastPage())
                        <a href="{{ $books->url($books->lastPage()) }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">{{ $books->lastPage() }}</a>
                    @endif

                    {{-- Next Button --}}
                    @if ($books->hasMorePages())
                        <a href="{{ $books->nextPageUrl() }}" class="px-3 py-2 text-gray-500 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-chevron-right w-5 h-5"></i>
                        </a>
                    @else
                        <button disabled class="px-3 py-2 text-gray-400 cursor-not-allowed rounded-lg">
                            <i class="fas fa-chevron-right w-5 h-5"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Book -->
    <x-modal name="create-book" title="Tambah Buku" maxWidth="2xl">
        @include('admin.books.partials.create-form', ['categories' => $categories])
    </x-modal>

    <!-- Confirm Delete Modal -->
    <x-confirm-delete />
@endsection
