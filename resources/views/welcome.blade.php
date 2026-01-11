@extends('layouts.app')

@section('content')
    <div class="font-sans text-[#4A3426] bg-[#FFFBF2] min-h-screen overflow-x-hidden">

        {{-- ... (SECTION HERO & FEATURES BIARKAN SAMA, KITA FOKUS DI SECTION PRODUK) ... --}}
        {{-- Saya sertakan kembali section Hero/Features secara ringkas agar struktur tidak rusak --}}

        <section class="relative px-4 py-12 md:py-20 lg:px-12 overflow-hidden">
            {{-- ... (Isi Hero sama seperti sebelumnya) ... --}}
            <div class="container mx-auto max-w-7xl">
                <div class="flex flex-col-reverse md:flex-row items-center gap-8 md:gap-16">
                    <div class="w-full md:w-1/2 space-y-6 text-center md:text-left z-10">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-[#3E2723]">
                            Cemilan Gurih dengan <br class="hidden md:block"> Pengalaman Unik
                        </h1>
                        <p class="text-base md:text-lg text-gray-600 leading-relaxed max-w-lg mx-auto md:mx-0">
                            Teman setia di sela aktivitasmu. Renyahnya bikin nagih!
                        </p>
                        <div class="pt-4">
                            <a href="{{ route('home') }}#produk"
                                class="inline-flex items-center gap-2 bg-[#5D4037] hover:bg-[#3E2723] text-white font-semibold px-8 py-4 rounded-full shadow-lg transition-all transform hover:-translate-y-1">
                                See More <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 flex justify-center relative">
                        <img src="{{ asset('gambar/nurhayati.png') }}" alt="Keripik Nurhayati"
                            class="relative z-10 w-full max-w-md drop-shadow-2xl rounded-3xl">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 bg-[#5D4037] shadow-sm relative z-20">
            {{-- ... (Isi Features sama seperti sebelumnya, hanya padding saya sesuaikan sedikit) ... --}}
            <div class="container mx-auto px-4 max-w-7xl">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 rounded-2xl bg-[#FFFBF2] flex items-center gap-4 shadow-md">
                        <div class="w-12 h-12 bg-[#5D4037] rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shipping-fast text-xl text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#3E2723]">Fast Delivery</h3>
                            <p class="text-xs text-gray-600">Pengiriman cepat & aman.</p>
                        </div>
                    </div>
                    <div class="p-6 rounded-2xl bg-[#FFFBF2] flex items-center gap-4 shadow-md">
                        <div class="w-12 h-12 bg-[#5D4037] rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-credit-card text-xl text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#3E2723]">Secure Payment</h3>
                            <p class="text-xs text-gray-600">Transaksi terjamin aman.</p>
                        </div>
                    </div>
                    <div class="p-6 rounded-2xl bg-[#FFFBF2] flex items-center gap-4 shadow-md">
                        <div class="w-12 h-12 bg-[#5D4037] rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-headset text-xl text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#3E2723]">Support 24/7</h3>
                            <p class="text-xs text-gray-600">Siap membantu Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION 3: PRODUCTS (BAGIAN YANG DIPERBAIKI) --}}
        <section id="produk" class="py-12 md:py-24 px-3 md:px-4 bg-[#FFFBF2]">
            <div class="container mx-auto max-w-7xl">

                {{-- Section Header --}}
                <div class="flex justify-between items-end mb-6 md:mb-12 px-1">
                    <div class="text-left">
                        <h2 class="text-2xl md:text-4xl font-bold text-[#3E2723] mb-1 md:mb-3">Produk Unggulan</h2>
                        <p class="text-xs md:text-base text-gray-600 max-w-md">Rasa favorit yang wajib dicoba!</p>
                    </div>
                    {{-- Tombol Lihat Semua versi Mobile (Icon saja agar hemat tempat) --}}
                    <a href="{{ route('products.catalog') }}"
                        class="text-[#5D4037] text-sm font-semibold hover:underline flex items-center gap-1">
                        Lihat Semua <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                {{-- Product Grid: KUNCI PERUBAHAN ADA DI SINI --}}
                {{-- grid-cols-2: Menampilkan 2 kolom di HP --}}
                {{-- gap-3: Jarak antar produk lebih rapat di HP agar rapi --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-8">
                    @forelse ($products as $product)
                        <a href="{{ route('product.show', $product) }}" class="group block h-full">
                            <div
                                class="bg-white rounded-xl md:rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 h-full flex flex-col border border-[#f3e5d8]">

                                {{-- Image Container --}}
                                {{-- aspect-square: Memastikan gambar kotak presisi (Instagram style) --}}
                                <div class="relative aspect-square overflow-hidden bg-gray-50">
                                    <img src="{{ asset($product->image ?? 'placeholder.jpg') }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">

                                    {{-- Badge Rating (Melayang di pojok kiri atas) --}}
                                    <div
                                        class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg shadow-sm flex items-center gap-1">
                                        <i class="fas fa-star text-yellow-400 text-[10px] md:text-xs"></i>
                                        <span
                                            class="text-[10px] md:text-xs font-bold text-gray-700">{{ $product->rating ?? '5.0' }}</span>
                                    </div>
                                </div>

                                {{-- Product Info --}}
                                <div class="p-3 md:p-5 flex-1 flex flex-col">
                                    {{-- Nama Produk: Font lebih kecil di mobile agar muat --}}
                                    <h3
                                        class="text-sm md:text-lg font-bold text-[#3E2723] mb-1 md:mb-2 line-clamp-2 leading-tight">
                                        {{ $product->name }}
                                    </h3>

                                    <div class="mt-auto">
                                        {{-- Harga --}}
                                        <p class="text-sm md:text-lg font-bold text-[#D84315]">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </p>

                                        {{-- Tombol Beli Mini (Opsional, menambah estetika e-commerce) --}}
                                        <div class="mt-2 flex items-center gap-2">
                                            <span
                                                class="text-[10px] md:text-sm text-gray-400 line-through decoration-red-400">
                                                {{-- Simulasi harga coret (opsional) --}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <div class="inline-block p-4 md:p-6 rounded-full bg-orange-100 mb-4">
                                <i class="fas fa-box-open text-2xl md:text-4xl text-[#5D4037]"></i>
                            </div>
                            <p class="text-gray-500 text-sm md:text-lg">Produk belum tersedia.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Tombol Bawah (Opsional jika user sudah scroll sampai bawah) --}}
                <div class="mt-8 md:mt-12 text-center md:hidden">
                    <a href="{{ route('products.catalog') }}"
                        class="inline-block w-full border border-[#5D4037] text-[#5D4037] font-semibold px-6 py-3 rounded-full text-sm hover:bg-[#5D4037] hover:text-white transition-colors">
                        Lihat Katalog Lengkap
                    </a>
                </div>
            </div>
        </section>

    </div>
@endsection
