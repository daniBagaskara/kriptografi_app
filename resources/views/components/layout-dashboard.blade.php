<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kriptografi</title>
    @vite('resources/css/app.css')
    <style>
        .feature-card {
            transition: transform 0.3s ease-in-out;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-red-600 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-xl font-bold flex items-center space-x-2">
                <i class="fas fa-lock"></i>
                <span>Aplikasi Kriptografi</span>
            </a>
            <div class="flex space-x-4">
                <p class="flex items-center"><i class="fas fa-user"></i> <span>Haloo, {{ auth()->user()->name }}</span></p>
                <form action="{{ route('logout') }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="hover:bg-red-700 py-2 px-4 rounded transition">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto my-8 px-4 flex flex-wrap">
        <!-- Sidebar -->
        <aside class="lg:w-1/4 mb-8 lg:mb-0 lg:px-4 w-full">
            <div class="bg-white shadow-lg rounded-lg p-4">
                <nav class="flex flex-col space-y-2">
                    <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'bg-red-600 hover:bg-red-700 text-white' : 'hover:bg-gray-100' }} py-2 px-4 rounded-lg">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('enkripsi-text.form') }}" class="py-2 px-4 rounded-lg {{ request()->is('enkripsi-text') ? 'bg-red-600 hover:bg-red-700 text-white' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-comment"></i>
                        Enkripsi Pesan
                    </a>
                    <a href="{{ route('dekripsi-text.form') }}" class="py-2 px-4 rounded-lg {{ request()->is('dekripsi-text') ? 'bg-red-600 hover:bg-red-700 text-white' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-comment"></i>
                        Dekripsi Pesan
                    </a>
                    <a href="{{ route('enkripsi-file.form') }}" class="py-2 px-4 rounded-lg {{ request()->is('enkripsi-file') ? 'bg-red-600 hover:bg-red-700 text-white' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-image"></i>
                        Enkripsi File
                    </a>
                    <a href="{{ route('dekripsi-file.form') }}" class="py-2 px-4 rounded-lg {{ request()->is('dekripsi-file') ? 'bg-red-600 hover:bg-red-700 text-white' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-image"></i>
                        Dekripsi File
                    </a>
                    <a href="{{ route('enkripsi-image') }}" class="py-2 px-4 rounded-lg {{ request()->is('enkripsi-image') ? 'bg-red-600 hover:bg-red-700 text-white' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-file"></i>
                        Enkripsi Gambar
                    </a>
                    <a href="{{ route('dekripsi-image') }}" class="py-2 px-4 rounded-lg {{ request()->is('dekripsi-image') ? 'bg-red-600 hover:bg-red-700 text-white' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-file"></i>
                        Dekripsi Gambar
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Area -->
        <main class="w-full lg:w-3/4 lg:px-4">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
