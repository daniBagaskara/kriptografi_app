<x-layout-dashboard>
    <x-slot:title>
        Steganografi
    </x-slot:title>

    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Steganografi</h2>
            <form action="{{ route('steganography.hide.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gambar</label>
                    <input type="file" name="image" accept=".png"
                    class="mt-1 block w-full text-sm text-gray-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-sm file:font-semibold
                          file:bg-blue-50 file:text-blue-700
                          hover:file:bg-blue-100"
                    required>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Pesan</label>
                    <textarea name="message" rows="4"
                        class="block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required></textarea>
                </div>
                <button type="submit"
                    class="mt-4 w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Proses
                </button>
        </div>
    </div>
</x-layout-dashboard>
