<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Supplier - Magura</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-purple-600 min-h-screen p-6 hidden lg:block">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-white">Magura</h1>
                <p class="text-purple-200 text-sm">Sistem Gudang</p>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center text-purple-100 hover:bg-purple-700 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('barang.index') }}" class="flex items-center text-purple-100 hover:bg-purple-700 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Data Barang
                </a>
                <a href="{{ route('barang_masuk.index') }}" class="flex items-center text-purple-100 hover:bg-purple-700 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Barang Masuk
                </a>
                <a href="{{ route('barang_keluar.index') }}" class="flex items-center text-purple-100 hover:bg-purple-700 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Barang Keluar
                </a>
                <a href="{{ route('kategori.index') }}" class="flex items-center text-purple-100 hover:bg-purple-700 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Kategori
                </a>
                <a href="{{ route('supplier.index') }}" class="flex items-center text-white bg-purple-700 px-4 py-3 rounded-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Supplier
                </a>
            </nav>
            <div class="mt-8">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center text-purple-100 hover:bg-purple-700 w-full px-4 py-2 rounded-lg transition text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 lg:p-8">
            <div class="mb-8">
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Edit Supplier</h1>
                <p class="text-gray-600">Edit data supplier</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-6">
                            <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Supplier</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $supplier->nama) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label for="kontak" class="block text-gray-700 font-medium mb-2">Kontak</label>
                            <input type="text" name="kontak" id="kontak" value="{{ old('kontak', $supplier->kontak) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @error('kontak')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label for="telepon" class="block text-gray-700 font-medium mb-2">Telepon</label>
                            <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $supplier->telepon) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @error('telepon')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label for="alamat" class="block text-gray-700 font-medium mb-2">Alamat</label>
                            <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $supplier->alamat) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @error('alamat')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                            Update
                        </button>
                        <a href="{{ route('supplier.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
