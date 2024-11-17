<x-layout-dashboard>
    <x-slot:title>
        Ekstraksi Pesan
    </x-slot:title>

    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Extract Hidden Message</h2>

            <form id="extractForm" class="space-y-4" enctype="multipart/form-data" action="{{ route('steganography.extract.process') }}" method="POST">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Select Image:</label>
                    <input type="file" name="image" accept=".png"
                        class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100"
                        required>
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Extract Message
                </button>
            </form>

            @if (session('message')) 
            <div id="result" class="mt-4">
                <h3 class="font-bold text-lg mb-2">Extracted Message:</h3>
                <div id="messageText" class="p-4 bg-gray-50 rounded-lg">{{ session('message') }}</div>
            </div>
            @endif

            @if (session('error'))
                <div id="error" class="mt-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded"></div>
                </div>
            @endif
            
        </div>
    </div>
</x-layout-dashboard>
