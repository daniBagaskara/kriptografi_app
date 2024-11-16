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
                    <a href="#" class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                    <a href="#" class="py-2 px-4 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-comment"></i>
                        Enkripsi Pesan
                    </a>
                    <a href="#" class="py-2 px-4 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-image"></i>
                        Enkripsi Gambar
                    </a>
                    <a href="#" class="py-2 px-4 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-file"></i>
                        Enkripsi File
                    </a>
                    <a href="#" class="py-2 px-4 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-history"></i>
                        Riwayat
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Area -->
        <main class="w-full lg:w-3/4 lg:px-4">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
                    <h5 class="text-lg font-semibold flex items-center space-x-2">
                        <i class="fas fa-comment"></i>
                        <span>Total Pesan</span>
                    </h5>
                    <h3 class="text-2xl font-bold">150</h3>
                </div>
                <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
                    <h5 class="text-lg font-semibold flex items-center space-x-2">
                        <i class="fas fa-image"></i>
                        <span>Total Gambar</span>
                    </h5>
                    <h3 class="text-2xl font-bold">75</h3>
                </div>
                <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-lg">
                    <h5 class="text-lg font-semibold flex items-center space-x-2">
                        <i class="fas fa-file"></i>
                        <span>Total File</span>
                    </h5>
                    <h3 class="text-2xl font-bold">45</h3>
                </div>
            </div>

            <!-- Feature Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white shadow-lg rounded-lg p-6 text-center feature-card">
                    <i class="fas fa-comment text-blue-500 text-4xl mb-4"></i>
                    <h5 class="text-lg font-semibold">Enkripsi Pesan</h5>
                    <p class="text-gray-600 mb-4">Enkripsi pesan teks menggunakan super enkripsi</p>
                    <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                        Mulai
                    </button>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center feature-card">
                    <i class="fas fa-image text-green-500 text-4xl mb-4"></i>
                    <h5 class="text-lg font-semibold">Enkripsi Gambar</h5>
                    <p class="text-gray-600 mb-4">Enkripsi gambar menggunakan steganografi</p>
                    <button class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
                        Mulai
                    </button>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center feature-card">
                    <i class="fas fa-file text-yellow-500 text-4xl mb-4"></i>
                    <h5 class="text-lg font-semibold">Enkripsi File</h5>
                    <p class="text-gray-600 mb-4">Enkripsi file menggunakan algoritma kriptografi</p>
                    <button class="bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600">
                        Mulai
                    </button>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h5 class="text-lg font-semibold flex items-center space-x-2 mb-4">
                    <i class="fas fa-clock"></i>
                    <span>Aktivitas Terbaru</span>
                </h5>
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">Waktu</th>
                            <th class="p-3">Tipe</th>
                            <th class="p-3">File</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-3">2024-11-15 10:30</td>
                            <td class="p-3">Pesan</td>
                            <td class="p-3">message1.txt</td>
                            <td class="p-3"><span class="bg-green-500 text-white py-1 px-3 rounded-full text-sm">Sukses</span></td>
                        </tr>
                        <tr>
                            <td class="p-3">2024-11-15 10:25</td>
                            <td class="p-3">Gambar</td>
                            <td class="p-3">image1.png</td>
                            <td class="p-3"><span class="bg-green-500 text-white py-1 px-3 rounded-full text-sm">Sukses</span></td>
                        </tr>
                        <tr>
                            <td class="p-3">2024-11-15 10:20</td>
                            <td class="p-3">File</td>
                            <td class="p-3">document1.pdf</td>
                            <td class="p-3"><span class="bg-green-500 text-white py-1 px-3 rounded-full text-sm">Sukses</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
