@extends('layouts.admin')

@section('title', 'Kategori Buku')
@section('page-title', 'Kategori Buku')

@section('content')
    <!-- Flash Messages -->
    @if(session('success') || request()->query('created') == '1')
        <x-flash-message type="success" />
    @endif
    @if(session('deleted'))
        <x-flash-message type="deleted" />
    @endif
    @if(session('updated') || request()->query('updated') == '1')
        <x-flash-message type="updated" />
    @endif
    @if(session('error'))
        <x-flash-message type="error" message="{{ session('error') }}" />
    @endif

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-2xl font-bold text-gray-900">Kategori Buku</h3>
        <button
            @click="$dispatch('open-modal', 'create-category')"
            class="flex items-center gap-2 px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors text-sm font-medium"
        >
            <i class="fas fa-plus"></i>
            <span>Tambah Kategori</span>
        </button>
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('categories.index') }}" id="filter-form" class="mb-5">
        <div class="relative w-80">
            <i class="fas fa-search text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 text-sm"></i>
            <input
                type="text"
                name="search"
                id="search-input"
                value="{{ request('search') }}"
                placeholder="Search"
                class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-full text-sm focus:outline-none focus:border-gray-400"
                autocomplete="off"
            >
        </div>
    </form>

    <script>
        (function () {
            var form = document.getElementById('filter-form');
            var searchInput = document.getElementById('search-input');
            var debounceTimer;
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function () { form.submit(); }, 400);
            });
        })();
    </script>

    <!-- Category List Accordion -->
    @if($categories->count())
        <div x-data="{ openRow: null }" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-cyan-500 text-white text-sm">
                            <th class="px-4 py-3 text-center font-semibold w-16"></th>
                            <th class="px-4 py-3 text-center font-semibold w-16">No</th>
                            <th class="px-4 py-3 text-left font-semibold">Kategori</th>
                            <th class="px-4 py-3 text-left font-semibold w-56">Daftar Buku</th>
                            <th class="px-4 py-3 text-center font-semibold w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($categories as $index => $category)
                            <tr :class="openRow === {{ $category->id }} ? 'bg-cyan-50/60' : 'hover:bg-gray-50'" class="transition-colors">
                                <td class="px-4 py-3 text-center">
                                    <button
                                        type="button"
                                        @click="openRow = openRow === {{ $category->id }} ? null : {{ $category->id }}"
                                        :class="openRow === {{ $category->id }} ? 'bg-cyan-500 text-white shadow-sm' : 'bg-cyan-100 hover:bg-cyan-200 text-cyan-700'"
                                        class="w-8 h-8 rounded-lg transition-colors"
                                        :aria-expanded="openRow === {{ $category->id }}"
                                        title="Lihat daftar buku"
                                    >
                                        <i class="fas" :class="openRow === {{ $category->id }} ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-medium text-gray-700">{{ $categories->firstItem() + $index }}</td>
                                <td class="px-4 py-3">
                                    <p class="text-sm font-semibold text-gray-900">{{ $category->nama_kategori }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-cyan-50 text-cyan-700 border border-cyan-200 font-medium">
                                        {{ $category->books_count }} buku
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button
                                            @click="$dispatch('open-modal', 'edit-category-{{ $category->id }}')"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-100 hover:bg-yellow-200 text-yellow-600 transition-colors"
                                            title="Edit"
                                        >
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <button
                                            @click="$dispatch('open-confirm-delete', { url: '{{ route('categories.destroy', $category->id) }}' })"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 hover:bg-red-200 text-red-600 transition-colors"
                                            title="Hapus"
                                        >
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr x-show="openRow === {{ $category->id }}" x-transition.opacity.duration.150ms class="bg-slate-50/70">
                                <td colspan="5" class="px-4 py-4">
                                    @if($category->books->count())
                                        <div class="rounded-xl bg-white overflow-hidden shadow-sm">
                                            <div class="px-4 py-3 bg-slate-50/80 flex items-center justify-between">
                                                <p class="text-sm font-semibold text-slate-700">Daftar Buku</p>
                                            </div>
                                            <table class="w-full">
                                                <thead>
                                                    <tr class="bg-white text-slate-500 text-xs uppercase tracking-wide">
                                                        <th class="px-4 py-2.5 text-left font-semibold">No</th>
                                                        <th class="px-4 py-2.5 text-left font-semibold">Judul Buku</th>
                                                        {{-- <th class="px-4 py-2.5 text-left font-semibold">Penulis</th>
                                                        <th class="px-4 py-2.5 text-left font-semibold w-28">Tahun</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody class="text-sm">
                                                    @foreach($category->books as $bookIndex => $book)
                                                        <tr class="odd:bg-white even:bg-slate-50/60 hover:bg-cyan-50/50 transition-colors">
                                                            <td class="px-4 py-2.5 text-slate-500 font-medium">{{ $bookIndex + 1 }}</td>
                                                            <td class="px-4 py-2.5 text-slate-800 font-semibold">{{ $book->judul }}</td>
                                                            {{-- <td class="px-4 py-2.5 text-slate-600">{{ $book->penulis }}</td>
                                                            <td class="px-4 py-2.5 text-slate-600">{{ $book->tahun ?? '-' }}</td> --}}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="rounded-xl bg-white px-4 py-6 text-center text-sm text-slate-500 shadow-sm">
                                            Belum ada buku pada kategori ini.
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-20 text-gray-400">
            <i class="fas fa-tags text-5xl mb-3 block"></i>
            <p class="text-base font-medium text-gray-500">Belum ada kategori</p>
            <p class="text-sm mt-1">Klik tombol "Tambah Kategori" untuk membuat kategori baru</p>
        </div>
    @endif

    <!-- Pagination -->
    @if($categories->hasPages())
    <div class="mt-6 flex items-center justify-between">
        <p class="text-sm text-gray-500">
            Menampilkan {{ $categories->firstItem() ?? 0 }}-{{ $categories->lastItem() ?? 0 }} dari {{ $categories->total() }} data
        </p>
        <div class="flex items-center gap-1">
            @if ($categories->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center text-gray-300 rounded-lg cursor-not-allowed">
                    <i class="fas fa-chevron-left text-xs"></i>
                </span>
            @else
                <a href="{{ $categories->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-chevron-left text-xs"></i>
                </a>
            @endif

            @php
                $start = max(1, $categories->currentPage() - 1);
                $end   = min($categories->lastPage(), $categories->currentPage() + 1);
            @endphp

            @if($start > 1)
                <a href="{{ $categories->url(1) }}" class="w-8 h-8 flex items-center justify-center text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">1</a>
                @if($start > 2)
                    <span class="w-8 h-8 flex items-center justify-center text-sm text-gray-400">...</span>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $categories->currentPage())
                    <span class="w-8 h-8 flex items-center justify-center text-sm bg-cyan-500 text-white rounded-lg font-medium">{{ $i }}</span>
                @else
                    <a href="{{ $categories->url($i) }}" class="w-8 h-8 flex items-center justify-center text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">{{ $i }}</a>
                @endif
            @endfor

            @if($end < $categories->lastPage())
                @if($end < $categories->lastPage() - 1)
                    <span class="w-8 h-8 flex items-center justify-center text-sm text-gray-400">...</span>
                @endif
                <a href="{{ $categories->url($categories->lastPage()) }}" class="w-8 h-8 flex items-center justify-center text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">{{ $categories->lastPage() }}</a>
            @endif

            @if ($categories->hasMorePages())
                <a href="{{ $categories->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-chevron-right text-xs"></i>
                </a>
            @else
                <span class="w-8 h-8 flex items-center justify-center text-gray-300 rounded-lg cursor-not-allowed">
                    <i class="fas fa-chevron-right text-xs"></i>
                </span>
            @endif
        </div>
    </div>
    @endif

    <!-- Modals -->
    <x-modal name="create-category" title="Tambah Kategori" maxWidth="md">
        @include('admin.categories.partials.create-form')
    </x-modal>

    @foreach($categories as $category)
        <x-modal name="edit-category-{{ $category->id }}" title="Edit Kategori" maxWidth="md">
            @include('admin.categories.partials.edit-form', ['category' => $category])
        </x-modal>
    @endforeach

    <x-confirm-delete />
@endsection
