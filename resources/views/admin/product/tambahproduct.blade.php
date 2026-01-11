@extends('layouts.navbaradmin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Tambah Produk</h2>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Nama Produk -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                <input type="text" name="name" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 
                              focus:ring-blue-500 focus:border-blue-500 shadow-sm">
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" required rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 
                                 focus:ring-blue-500 focus:border-blue-500 shadow-sm"></textarea>
            </div>

            <!-- Harga -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                <input type="number" name="price" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 
                              focus:ring-blue-500 focus:border-blue-500 shadow-sm">
            </div>

            <!-- Stok -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                <input type="number" name="stock" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 
                              focus:ring-blue-500 focus:border-blue-500 shadow-sm">
            </div>

            <!-- Gambar Produk -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                <input type="file" name="image" accept="image/*"
                       class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                              file:rounded-xl file:border-0 file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 
                               text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition">
                    💾 Simpan Produk
                </button>
            </div>
        </form>
    </div>
@endsection
