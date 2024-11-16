<x-layout-auth>
    <x-slot:title>
        Login
    </x-slot:title>

    <form action="/login" method="POST" class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        @csrf

        <!-- Menampilkan Pesan Sukses -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Menampilkan Pesan Error -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="{{ old('email') }}" 
                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 @error('email') border-red-500 @enderror" 
                placeholder="Enter your email" 
                required
            >
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 @error('password') border-red-500 @enderror" 
                placeholder="Enter your password" 
                required
            >
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition"
        >
            Login
        </button>

        <!-- Register Link -->
        <p class="text-center text-gray-600 mt-4">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a>
        </p>
    </form>
</x-layout-auth>
