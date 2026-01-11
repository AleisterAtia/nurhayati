@extends('layouts.navbaradmin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
    <div class="animate-fade-in-down pb-12">
        <div class="max-w-5xl mx-auto">

            {{-- Breadcrumb & Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <nav class="flex text-sm text-gray-500 mb-1" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2">
                            <li><a href="{{ route('products.index') }}" class="hover:text-[#D84315]">Produk</a></li>
                            <li><span class="mx-1">/</span></li>
                            <li class="font-medium text-gray-800" aria-current="page">Tambah Baru</li>
                        </ol>
                    </nav>
                    <h1 class="text-2xl font-bold text-[#3E2723]">Tambah Produk Baru</h1>
                </div>
                <a href="{{ route('products.index') }}" 
                   class="text-sm font-medium text-gray-500 hover:text-[#D84315] flex items-center gap-1 transition-colors">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- KOLOM KIRI: Form Input --}}
                    <div class="lg:col-span-2 space-y-6">
                        
                        {{-- Kartu Info Dasar --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                            <h3 class="text-lg font-bold text-[#3E2723] mb-6 flex items-center gap-2">
                                <i class="fas fa-pen-nib text-[#D84315]"></i> Detail Produk
                            </h3>

                            <div class="space-y-6">
                                {{-- Nama Produk --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-[#D84315] focus:ring-0 transition-all duration-200 font-medium text-gray-800 placeholder-gray-400"
                                        placeholder="Contoh: Keripik Singkong Balado">
                                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Deskripsi --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                                    <textarea name="description" required rows="5"
                                        class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-[#D84315] focus:ring-0 transition-all duration-200 text-gray-600 placeholder-gray-400 leading-relaxed"
                                        placeholder="Jelaskan rasa, tekstur, dan keunggulan produk ini...">{{ old('description') }}</textarea>
                                    @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Kartu Harga & Stok --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Harga --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Satuan <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-gray-500 font-bold">Rp</span>
                                        </div>
                                        <input type="number" name="price" value="{{ old('price') }}" required
                                            class="w-full pl-12 pr-4 py-3 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-[#D84315] focus:ring-0 transition-all duration-200 font-bold text-gray-800"
                                            placeholder="0">
                                    </div>
                                    @error('price') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Stok --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stok Awal <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="number" name="stock" value="{{ old('stock') }}" required
                                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-[#D84315] focus:ring-0 transition-all duration-200 font-medium text-gray-800"
                                            placeholder="0">
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <span class="text-gray-400 text-xs">Unit</span>
                                        </div>
                                    </div>
                                    @error('stock') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- KOLOM KANAN: Upload Gambar & Action --}}
                    <div class="lg:col-span-1 space-y-6">
                        
                        {{-- Kartu Upload Gambar --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-[#3E2723] mb-4">Foto Produk</h3>
                            
                            {{-- Area Upload --}}
                            <div class="relative w-full aspect-square bg-gray-50 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 group hover:border-[#D84315] hover:bg-orange-50/30 transition-all cursor-pointer" onclick="document.getElementById('imageInput').click()">
                                
                                {{-- Preview Image (Hidden by default) --}}
                                <img id="imagePreview" class="hidden w-full h-full object-cover">
                                
                                {{-- Placeholder State --}}
                                <div id="uploadPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                    <div class="bg-white p-3 rounded-full shadow-sm mb-3">
                                        <i class="fas fa-cloud-upload-alt text-2xl text-[#D84315]"></i>
                                    </div>
                                    <p class="text-sm font-bold text-gray-700">Upload Foto</p>
                                    <p class="text-xs text-gray-400 mt-1">Klik untuk memilih</p>
                                </div>
                            </div>

                            <input type="file" id="imageInput" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                            
                            <div class="mt-4 bg-blue-50 text-blue-700 px-4 py-3 rounded-lg text-xs flex gap-2 items-start">
                                <i class="fas fa-info-circle mt-0.5"></i>
                                <span>Gunakan foto rasio 1:1 (Persegi) dengan format JPG/PNG, maks 2MB.</span>
                            </div>
                            @error('image') <p class="text-xs text-red-500 mt-2">{{ $message }}</p> @enderror
                        </div>

                        {{-- Kartu Tombol Aksi --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Aksi</h3>
                            
                            <button type="submit"
                                class="w-full bg-[#5D4037] hover:bg-[#3E2723] text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 mb-3 flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i> Simpan Produk
                            </button>

                            <a href="{{ route('products.index') }}"
                                class="block w-full text-center py-3 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-colors">
                                Batal
                            </a>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Script untuk Preview Gambar --}}
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('imagePreview');
                const placeholder = document.getElementById('uploadPlaceholder');
                
                output.src = reader.result;
                output.classList.remove('hidden'); // Tampilkan gambar
                placeholder.classList.add('hidden'); // Sembunyikan ikon upload placeholder
            };
            
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
@endsection