<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Lantera Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('image/logoRounded.png') }}" type="image/png">
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true }" x-cloak>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-white  flex flex-col transition-all duration-300">
            <!-- Logo -->
            <div class="h-20  flex items-center px-6">
            <div class="flex items-center gap-3 w-full"
                :class="sidebarOpen ? 'justify-start' : 'justify-center'">

                <img
                    x-show="sidebarOpen"
                    x-transition
                    src="{{ asset('image/smpn1balen.png') }}"
                    alt="Logo SMPN 1 Balen"
                    class="h-8 w-auto object-contain"
                >

                <div
                    x-show="sidebarOpen"
                    x-transition
                    class="border-l border-gray-300 h-8"
                ></div>

                <img
                    src="{{ asset('image/logoLantera.png') }}"
                    alt="Lantera Logo"
                    class="h-8 w-auto object-contain"
                >


                <div x-show="sidebarOpen" x-transition class="min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-cyan-500 leading-none whitespace-nowrap">Lantera</span>
                    </div>
                    <p class="mt-1 text-[10px] font-semibold uppercase tracking-wider text-gray-400 leading-none">
                        SMPN 1 Balen
                    </p>
                </div>
            </div>
        </div>

            <!-- Menu Navigation -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'text-cyan-600 bg-cyan-50' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">
                    <i class="fas fa-home w-5 h-5 shrink-0 flex items-center justify-center"></i>
                    <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
                </a>

                <!-- Manajemen Menu -->
                <div x-data="{ open: {{ request()->routeIs(['users.*', 'books.*', 'categories.*']) ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 {{ request()->routeIs(['users.*', 'books.*', 'categories.*']) ? 'text-cyan-600 bg-cyan-50' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-sliders w-5 h-5 shrink-0 flex items-center justify-center"></i>
                            <span x-show="sidebarOpen" class="font-medium">Manajemen</span>
                        </div>
                        <i x-show="sidebarOpen" :class="open ? 'rotate-180' : ''" class="fas fa-chevron-down w-4 h-4 transition-transform shrink-0"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-collapse class="ml-8 mt-2 space-y-2">
                        <a href="{{ route('users.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('users.*') ? 'text-cyan-600 font-semibold' : 'text-gray-600 hover:text-cyan-600' }}">Kelola User</a>
                        <a href="{{ route('categories.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('categories.*') ? 'text-cyan-600 font-semibold' : 'text-gray-600 hover:text-cyan-600' }}">Kategori Buku</a>
                        <a href="{{ route('books.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('books.*') ? 'text-cyan-600 font-semibold' : 'text-gray-600 hover:text-cyan-600' }}">Kelola Buku</a>
                    </div>
                </div>

                <!-- Peminjaman Menu -->
                <div x-data="{ open: {{ request()->routeIs(['admin.peminjaman.*']) ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 {{ request()->routeIs(['admin.peminjaman.*']) ? 'text-cyan-600 bg-cyan-50' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-book-open w-5 h-5 shrink-0 flex items-center justify-center"></i>
                            <span x-show="sidebarOpen" class="font-medium">Peminjaman</span>
                        </div>
                        <i x-show="sidebarOpen" :class="open ? 'rotate-180' : ''" class="fas fa-chevron-down w-4 h-4 transition-transform shrink-0"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-collapse class="ml-8 mt-2 space-y-2">
                        <a href="{{ route('admin.peminjaman.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('admin.peminjaman.index') ? 'text-cyan-600 font-semibold' : 'text-gray-600 hover:text-cyan-600' }}">Daftar Peminjaman</a>
                        <a href="{{ route('admin.peminjaman.riwayat') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('admin.peminjaman.riwayat') ? 'text-cyan-600 font-semibold' : 'text-gray-600 hover:text-cyan-600' }}">Riwayat Pengembalian</a>
                    </div>
                </div>

                <!-- Denda Menu -->
                <a href="{{ route('admin.denda.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.denda.*') ? 'bg-cyan-50 text-cyan-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-money-bill-wave w-5 h-5 shrink-0 flex items-center justify-center"></i>
                    <span x-show="sidebarOpen" class="font-medium">Denda</span>
                </a>

                <!-- Buku Tamu Menu -->
                <a href="{{ route('admin.guest-book.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.guest-book.*') ? 'bg-cyan-50 text-cyan-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-book-open w-5 h-5 shrink-0 flex items-center justify-center"></i>
                    <span x-show="sidebarOpen" class="font-medium">Buku Tamu</span>
                </a>

                {{-- <!-- Laporan -->
                <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                    <i class="fas fa-chart-line w-5 h-5 shrink-0 flex items-center justify-center"></i>
                    <span x-show="sidebarOpen" class="font-medium">Laporan</span>
                </a> --}}

                <!-- Pengaturan -->
                <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                    <i class="fas fa-cog w-5 h-5 shrink-0 flex items-center justify-center"></i>
                    <span x-show="sidebarOpen" class="font-medium">Pengaturan</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white border-b-2 border-gray-100 h-20 flex items-center px-6">
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h2 class="text-2xl font-semibold text-gray-800">@yield('Dashboard')</h2>
                    </div>

                    <div class="flex items-center space-x-4">

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                                <div class="w-8 h-8 bg-cyan-500 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="text-left hidden md:block">
                                    <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->role }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
