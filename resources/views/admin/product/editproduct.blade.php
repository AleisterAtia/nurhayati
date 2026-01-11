@extends('layouts.navbaradmin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
    <div class="animate-fade-in-down">
        <div class="max-w-4xl mx-auto bg-white shadow-sm border border-orange-100 rounded-2xl p-6 md:p-8">

            {{-- Form Header --}}
            <div class="flex items-center gap-3 mb-8 pb-4 border-b border-orange-100">
                <div class="bg-orange-100 p-2.5 rounded-xl text-[#D84315]">
                    <i class="fas fa-edit text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-[#3E2723]">Form Edit Produk</h2>
                    <p class="text-sm text-gray-500">Perbarui informasi produk di bawah ini.</p>
                </div>
            </div>

            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Bagian Kiri: Input Teks (2/3 Lebar) --}}
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Nama Produk -->
                        <div>
                            <label class="block text-sm font-bold text-[#5D4037] mb-2">Nama Produk <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ $product->name }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] focus:ring-1 outline-none transition-all shadow-sm text-gray-700 placeholder-gray-400"
                                placeholder="Contoh: Keripik Balado Spesial">
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-bold text-[#5D4037] mb-2">Deskripsi</label>
                            <textarea name="description" required rows="5"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] focus:ring-1 outline-none transition-all shadow-sm text-gray-700 placeholder-gray-400"
                                placeholder="Jelaskan detail rasa, bahan, dan keunggulan produk...">{{ $product->description }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Harga -->
                            <div>
                                <label class="block text-sm font-bold text-[#5D4037] mb-2">Harga (Rp) <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-gray-500 font-medium">Rp</span>
                                    <input type="number" name="price" value="{{ $product->price }}" required
                                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] focus:ring-1 outline-none transition-all shadow-sm text-gray-700"
                                        placeholder="0">
                                </div>
                            </div>

                            <!-- Stok -->
                            <div>
                                <label class="block text-sm font-bold text-[#5D4037] mb-2">Stok <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="stock" value="{{ $product->stock }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] focus:ring-1 outline-none transition-all shadow-sm text-gray-700"
                                    placeholder="0">
                            </div>
                        </div>
                    </div>

                    {{-- Bagian Kanan: Upload Gambar (1/3 Lebar) --}}
                    <div class="lg:col-span-1">
                        <label class="block text-sm font-bold text-[#5D4037] mb-2">Gambar Produk</label>

                        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                            <!-- Preview Gambar Lama -->
                            @if ($product->image)
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 mb-2 font-medium">Gambar Saat Ini:</p>
                                    <div
                                        class="relative w-full aspect-square rounded-xl overflow-hidden border border-orange-200 shadow-sm group">
                                        <img src="{{ asset($product->image) }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </div>
                                </div>
                            @endif

                            <!-- Input File Custom -->
                            <div class="w-full">
                                <label
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-orange-50 hover:border-[#D84315] transition-all group relative overflow-hidden">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 z-10">
                                        <i
                                            class="fas fa-cloud-upload-alt text-2xl text-gray-400 group-hover:text-[#D84315] mb-2 transition-colors"></i>
                                        <p class="text-xs text-gray-500 group-hover:text-[#D84315] text-center px-2">
                                            <span class="font-bold">Klik untuk ganti</span>
                                        </p>
                                    </div>
                                    <input type="file" name="image" accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                </label>
                                <p class="text-[10px] text-gray-400 mt-2 text-center">
                                    Format: JPG, PNG, JPEG. Max 2MB.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Tombol Action -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-orange-100 mt-4">
                    <a href="{{ route('products.index') }}"
                        class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-[#5D4037] hover:bg-[#3E2723] text-white font-bold px-6 py-2.5 rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
