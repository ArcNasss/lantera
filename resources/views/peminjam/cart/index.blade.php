@extends('layouts.peminjam')

@section('title', 'Keranjang Saya')

@section('content')
    <!-- Flash Messages -->
    @if(session('success'))
        <x-flash-message type="success" />
    @endif

    @if(session('error'))
        <x-flash-message type="error" message="{{ session('error') }}" />
    @endif

    @if(session('deleted'))
        <x-flash-message type="deleted" />
    @endif


    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Keranjang Peminjaman
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Daftar buku didalam keranjang Anda</p>
                </div>
                {{-- <a href="{{ route('peminjam.list-buku') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Katalog
                </a> --}}
            </div>
        </div>

        @if($carts->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-shopping-cart text-gray-400 text-5xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Keranjang Kosong</h3>
                <p class="text-gray-600 mb-6">Belum ada buku yang ditambahkan ke keranjang</p>
                <a href="{{ route('peminjam.list-buku') }}" class="inline-flex items-center px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-book mr-2"></i>
                    Jelajahi Katalog
                </a>
            </div>
        @else
            <!-- Cart Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-cyan-500 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Buku</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Detail</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Stok</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Jumlah</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($carts as $cart)
                            <tr class="hover:bg-gray-50">
                                <!-- Book Image -->
                                <td class="px-6 py-4">
                                    <img src="{{ $cart->book->foto ? Storage::url($cart->book->foto) : 'https://via.placeholder.com/200x280/06b6d4/ffffff?text=No+Image' }}"
                                         alt="{{ $cart->book->judul }}"
                                         class="w-16 h-20 object-cover rounded border border-gray-300">
                                </td>

                                <!-- Book Details -->
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <h3 class="font-semibold text-gray-900">{{ $cart->book->judul }}</h3>
                                        <p class="text-sm text-gray-600">
                                            <i class="fas fa-feather-pointed text-gray-400 mr-1"></i>
                                            {{ $cart->book->penulis }}
                                        </p>
                                        {{-- <p class="text-sm text-gray-600">
                                            <i class="fas fa-building text-gray-400 mr-1"></i>
                                            {{ $cart->book->penerbit }}
                                        </p> --}}
                                        <span class="inline-block px-2 py-0.5 bg-cyan-100 text-cyan-700 text-xs rounded-full">
                                            {{ $cart->book->category->nama_kategori }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Stock -->
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $availableCount = $cart->book->availableItems()->count();
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium whitespace-nowrap {{ $availableCount > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        <i class="fas fa-box mr-1"></i>{{ $availableCount }} tersedia
                                    </span>
                                </td>

                                <!-- Quantity Controls -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="quantity" value="{{ max(1, $cart->quantity - 1) }}">
                                            <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-700 rounded transition-colors"
                                                    {{ $cart->quantity <= 1 ? 'disabled' : '' }}>
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                        </form>

                                        <input type="text"
                                               value="{{ $cart->quantity }}"
                                               readonly
                                               class="w-12 text-center border border-gray-300 rounded py-1 font-semibold">

                                        <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="quantity" value="{{ $cart->quantity + 1 }}">
                                            <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center bg-cyan-500 hover:bg-cyan-600 text-white rounded transition-colors"
                                                    {{ $cart->quantity >= $cart->book->availableItems()->count() ? 'disabled' : '' }}>
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                            <i class="fas fa-trash text-sm mr-1"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 mt-4">
                <a href="{{ route('peminjam.list-buku') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors text-sm">
                    <i class="fas fa-plus mr-1"></i>
                    Tambah Buku
                </a>
                <form action="{{ route('loans.store') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors text-sm">
                        <i class="fas fa-paper-plane mr-1"></i>
                        Ajukan Peminjaman
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection
