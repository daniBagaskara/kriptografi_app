<x-layout-dashboard>
    <x-slot:title>
        Dekripsi File
    </x-slot:title>

    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dekripsi File (AES-256-CBC)</h2>
            <form action="{{ route('dekripsi-file.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="file" class="block text-gray-700 font-medium mb-2">Pilih File</label>
                    <div class="relative">
                        <input type="file" name="file" id="file" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" />
                        <label for="file" class="absolute left-0 top-0 flex items-center pl-2 h-full cursor-pointer">
                            <i class="fas fa-folder-open text-gray-400"></i>
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="key" class="block text-gray-700 font-medium mb-2">Key:</label>
                    <input type="text" name="key" id="key" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Dekripsi</button>
                </div>
            </form>
        </div>
    </div>
</x-layout-dashboard>