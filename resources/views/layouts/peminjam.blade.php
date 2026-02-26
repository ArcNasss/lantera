<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Lantera Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true }" x-cloak>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-white border-r border-gray-200 flex flex-col transition-all duration-300">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <h1 x-show="sidebarOpen" class="text-3xl font-bold text-cyan-500">lantera</h1>
                <h1 x-show="!sidebarOpen" class="text-2xl font-bold text-cyan-500">L</h1>
            </div>

            <!-- Menu Navigation -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('peminjam.list-buku') }}" class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('peminjam.list-buku') ? 'text-cyan-600 bg-cyan-50' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">
                    <i class="fas fa-book-open w-5 h-5 shrink-0 flex items-center justify-center"></i>
                    <span x-show="sidebarOpen" class="font-medium">daftar Buku</span>
                </a>

                @auth
                    <!-- Peminjaman Menu -->
                    <div x-data="{ open: {{ request()->routeIs(['peminjam.loan.*', 'cart.*', 'loan.*']) ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 {{ request()->routeIs(['users.*', 'books.*', 'categories.*']) ? 'text-cyan-600 bg-cyan-50' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-book-open-reader w-5 h-5 shrink-0 flex items-center justify-center"></i>
                                <span x-show="sidebarOpen" class="font-medium">Peminjaman</span>
                            </div>
                            <i x-show="sidebarOpen" :class="open ? 'rotate-180' : ''" class="fas fa-chevron-down w-4 h-4 transition-transform shrink-0"></i>
                        </button>
                        <div x-show="open && sidebarOpen" x-collapse class="ml-8 mt-2 space-y-2">
                            <a href="{{ route('cart.index') }}" class="block px-4 py-2 text-sm  {{ request()->routeIs('cart.*') ? 'text-cyan-600 font-semibold ' : 'text-gray-600 hover:text-cyan-600' }}" >Keranjang peminjaman</a>
                            <a href="{{ route('peminjam.loan.index') }}" class="block px-4 py-2 text-sm  {{ request()->routeIs(['peminjam.loan.index', 'loans.*']) ? 'text-cyan-600 font-semibold' : 'text-gray-600 hover:text-cyan-600'  }}">Riwayat Peminjaman</a>
                        </div>
                    </div>
                @endauth
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bars w-6 h-6 text-xl"></i>
                        </button>
                        <h2 class="text-2xl font-semibold text-gray-800">@yield('Dashboard')</h2>
                    </div>

                    <div class="flex items-center space-x-4">
                        @auth
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
                                    <i class="fas fa-chevron-down w-4 h-4 text-gray-400"></i>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Settings</a>
                                    <hr class="my-2">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Login/Register Buttons -->
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-cyan-500 hover:bg-cyan-600 rounded-lg transition-colors">
                                    Register
                                </a>
                            </div>
                        @endauth
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
</body>
</html>
