<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Lantera</title>    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left Side - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
            <div class="max-w-md w-full space-y-8">
                <!-- Logo -->
                <div>
                    <h1 class="text-4xl font-bold text-cyan-500">lantera</h1>
                </div>

                <!-- Register Form -->
                <div class="mt-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Register</h2>
                    <p class="text-gray-600 text-sm mb-6">Buat akun baru</p>

                    <form class="space-y-6" action="{{ route('register') }}" method="POST">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama<span class="text-red-500">*</span>
                            </label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                required
                                class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500"
                                placeholder="Masukkan nama lengkap"
                                value="{{ old('name') }}"
                            >
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nomor_identitas" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor identitas<span class="text-red-500">*</span>
                            </label>
                            <input
                                id="nomor_identitas"
                                name="nomor_identitas"
                                type="text"
                                required
                                class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500"
                                placeholder="Masukkan nomor identitas"
                                value="{{ old('nomor_identitas') }}"
                            >
                            @error('nomor_identitas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Kata Sandi<span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500"
                                    placeholder="Masukkan kata sandi"
                                >
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i id="eyeIcon" class="fas fa-eye h-5 w-5 text-gray-400"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Kata Sandi<span class="text-red-500">*</span>
                            </label>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500"
                                placeholder="Ulangi kata sandi"
                            >
                        </div>

                        <div>
                            <button
                                type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cyan-500 hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-colors"
                            >
                                Daftar
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                Sudah punya akun?
                                <a href="{{ route('login') }}" class="font-medium text-cyan-500 hover:text-cyan-600">
                                    Masuk Disini!
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side - Welcome Section -->
        <div class="hidden lg:flex lg:w-1/2 bg-linear-to-br from-cyan-500 to-cyan-800 items-center justify-center p-12">
            <div class="max-w-lg text-white">
                <h2 class="text-4xl font-bold mb-4">Selamat datang di Lantera</h2>
                <p class="text-lg text-cyan-50 mb-8">
                    Solusi pintar untuk komunikasi dan administrasi Perpustakaan.
                </p>
                <img src="{{ asset('image/authImage.png')}}" alt="" class="w-sm m-auto">
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
