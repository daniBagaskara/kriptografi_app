<x-layout-dashboard>
    <x-slot:title>
        Enkripsi Text
    </x-slot:title>

    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class=" bg-gray-50 overflow-hidden shadow-lg rounded-lg">
            <div class="p-6">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Super Enkripsi Text (AES + Caesar)
                    </h2>
                </div>

                <!-- Form -->
                <form action="{{ route('enkripsi-text.process') }}" method="POST" class="space-y-6">
                    @csrf
                
                    <!-- Text Input -->
                    <div>
                        <label for="plaintext" class="block text-sm font-medium text-gray-700">
                            Text yang akan dienkripsi:
                        </label>
                        <textarea name="plaintext" id="plaintext" rows="4"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>{{ old('plaintext') }}</textarea>
                        @error('plaintext')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- AES Key -->
                    <div>
                        <label for="key1" class="block text-sm font-medium text-gray-700">AES Key:</label>
                        <input type="password" name="key1" id="key1"
                            class="block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required placeholder="Masukkan AES Key" value="{{ old('key1') }}">
                        @error('key1')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- AES IV -->
                    <div>
                        <label for="iv" class="block text-sm font-medium text-gray-700">AES IV:</label>
                        <input type="text" name="iv" id="iv"
                            class="block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Masukkan IV (16 karakter)" value="{{ old('iv') }}">
                        @error('iv')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- AES Method -->
                    <div>
                        <label for="method" class="block text-sm font-medium text-gray-700">AES Method:</label>
                        <select name="method" id="method"
                            class="block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                            <option value="AES-128-CTR" {{ old('method') === 'AES-128-CTR' ? 'selected' : '' }}>AES-128-CTR</option>
                            <option value="AES-128-CBC" {{ old('method') === 'AES-128-CBC' ? 'selected' : '' }}>AES-128-CBC</option>
                            <option value="AES-128-CFB" {{ old('method') === 'AES-128-CFB' ? 'selected' : '' }}>AES-128-CFB</option>
                        </select>
                        @error('method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Caesar Shift -->
                    <div>
                        <label for="key2" class="block text-sm font-medium text-gray-700">Caesar Shift:</label>
                        <input type="number" name="key2" id="key2"
                            class="block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required min="1" placeholder="Masukkan Caesar Shift" value="{{ old('key2') }}">
                        @error('key2')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700"
                        >Enkripsi</button>
                    </div>
                </form>


                @if (session('success'))
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900">Hasil Enkripsi</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">Text Asli:</p>
                            <p class="mt-1 font-mono bg-white p-2 rounded border">{{ session('original_text') }}</p>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Text Terenkripsi:</p>
                            <p class="mt-1 font-mono bg-white p-2 rounded border break-all">
                                {{ session('encrypted_text') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mt-6 bg-red-50 p-4 rounded-lg">
                        <p class="text-red-600">{{ session('error') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout-dashboard>
