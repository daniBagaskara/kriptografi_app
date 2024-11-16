<x-layout-dashboard>
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
            <h5 class="text-lg font-semibold flex items-center space-x-2">
                <i class="fas fa-comment"></i>
                <span>Total Pesan</span>
            </h5>
            <h3 class="text-2xl font-bold">{{ $totalTexts }}</h3>
        </div>
        <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
            <h5 class="text-lg font-semibold flex items-center space-x-2">
                <i class="fas fa-image"></i>
                <span>Total Gambar</span>
            </h5>
            <h3 class="text-2xl font-bold">{{ $totalImages }}</h3>
        </div>
        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-lg">
            <h5 class="text-lg font-semibold flex items-center space-x-2">
                <i class="fas fa-file"></i>
                <span>Total File</span>
            </h5>
            <h3 class="text-2xl font-bold">{{ $totalFiles }}</h3>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white shadow-lg rounded-lg p-6 text-center feature-card">
            <i class="fas fa-comment text-blue-500 text-4xl mb-4"></i>
            <h5 class="text-lg font-semibold">Enkripsi Pesan</h5>
            <p class="text-gray-600 mb-4">Enkripsi pesan teks menggunakan super enkripsi</p>
            <a href="{{ route('enkripsi-text.form') }}"
                class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                Mulai
            </a>
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

    {{-- <!-- Recent Activity -->
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
                @if ($historys->isEmpty())
                <tr>
                    <td class="p-3 text-center" colspan="4">Tidak ada data</td>
                </tr>
                @else
                    @foreach ($historys as $history)
                    <tr>
                        <td class="p-3">{{ $history->created_at->format('Y-m-d H:i') }}</td>
                        <td class="p-3">{{ $history->data_type }}</td>
                        <td class="p-3">message1.txt</td>
                        <td class="p-3"><span
                                class="bg-green-500 text-white py-1 px-3 rounded-full text-sm">Sukses</span></td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div> --}}
</x-layout-dashboard>
