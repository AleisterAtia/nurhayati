@extends('layouts.app')

@section('content')

    {{-- CSS Khusus untuk menyembunyikan batang scroll tapi tetap bisa digeser --}}
    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="font-sans text-[#4A3426] bg-[#FFFBF2] min-h-screen overflow-x-hidden">

        {{-- ========================================== --}}
        {{-- SECTION 1: HERO (KODE ASLI YANG MULIA) --}}
        {{-- ========================================== --}}
        <section class="relative px-4 py-12 md:py-20 lg:px-12 overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-[#FFFBF2] z-0"></div>
            <div class="container mx-auto max-w-7xl relative z-10">
                <div class="flex flex-col-reverse md:flex-row items-center gap-8 md:gap-16">
                    <div class="w-full md:w-1/2 space-y-6 text-center md:text-left">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-[#3E2723]">
                            Cemilan Gurih dengan <br class="hidden md:block"> Pengalaman Unik
                        </h1>
                        <p class="text-base md:text-lg text-gray-600 leading-relaxed max-w-lg mx-auto md:mx-0">
                            Teman setia di sela aktivitasmu. Renyahnya bikin nagih!
                        </p>
                        <div class="pt-4">
                            <a href="#produk"
                                class="inline-flex items-center gap-2 bg-[#5D4037] hover:bg-[#3E2723] text-white font-semibold px-8 py-4 rounded-full shadow-lg transition-all transform hover:-translate-y-1">
                                Pesan Sekarang <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 flex justify-center relative">
                        {{-- Pastikan gambar ini ada --}}
                        <img src="{{ asset('gambar/nurhayati.png') }}" alt="Keripik Nurhayati"
                            class="relative z-10 w-full max-w-md drop-shadow-2xl rounded-3xl hover:scale-105 transition-transform duration-500">
                    </div>
                </div>
            </div>
        </section>

        {{-- ========================================== --}}
        {{-- SECTION 2: FEATURES (KODE ASLI YANG MULIA) --}}
        {{-- ========================================== --}}
        <section class="py-12 bg-[#5D4037] shadow-sm relative z-20">
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

        {{-- ========================================== --}}
        {{-- SECTION 3: PRODUK UNGGULAN (MODIFIKASI SLIDER) --}}
        {{-- ========================================== --}}
        <section id="produk" class="py-16 md:py-24 bg-[#FFFBF2] relative">
            <div class="container mx-auto max-w-7xl px-4">

                {{-- Header Section dengan Tombol Panah --}}
                <div class="flex flex-row justify-between items-end mb-8">
                    <div>
                        <h2 class="text-2xl md:text-4xl font-bold text-[#3E2723] mb-2">Produk Favorit</h2>
                        <p class="text-sm md:text-base text-gray-600">Pilihan terbaik minggu ini</p>
                    </div>
                    
                    {{-- Navigasi Panah (Untuk Desktop & Mobile) --}}
                    <div class="flex gap-2">
                        <button onclick="slideLeft()" 
                            class="w-10 h-10 rounded-full bg-white border border-[#D84315] text-[#D84315] hover:bg-[#D84315] hover:text-white flex items-center justify-center transition-colors shadow-sm">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button onclick="slideRight()" 
                            class="w-10 h-10 rounded-full bg-white border border-[#D84315] text-[#D84315] hover:bg-[#D84315] hover:text-white flex items-center justify-center transition-colors shadow-sm">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                {{-- CONTAINER SLIDER --}}
                {{-- flex gap-4 overflow-x-auto: Ini kuncinya agar bisa digeser --}}
                <div id="product-slider" 
                     class="flex gap-4 md:gap-6 overflow-x-auto pb-8 snap-x snap-mandatory scroll-smooth hide-scrollbar px-1">
                    
                    @forelse ($products as $product)
                        {{-- KARTU PRODUK --}}
                        {{-- w-48 (Mobile) & w-64 (Desktop): Ukuran tetap agar bisa discroll --}}
                        <div class="flex-shrink-0 w-48 md:w-64 snap-center bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-orange-100 flex flex-col overflow-hidden group">
                            
                            {{-- Gambar --}}
                            <div class="relative h-40 md:h-52 bg-gray-100 overflow-hidden">
                                <img src="{{ asset($product->image ?? 'placeholder.jpg') }}" alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                
                                {{-- Rating Badge --}}
                                <div class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-[10px] md:text-xs font-bold text-[#D84315] shadow-sm flex items-center gap-1">
                                    <i class="fas fa-star text-yellow-400"></i> {{ $product->rating ?? '5.0' }}
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="font-bold text-[#3E2723] text-sm md:text-lg mb-1 line-clamp-2 leading-tight min-h-[2.5em]">
                                    {{ $product->name }}
                                </h3>
                                
                                <div class="mt-auto pt-3">
                                    <p class="text-[#D84315] font-extrabold text-base md:text-lg mb-3">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>

                                    {{-- Tombol Beli --}}
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                            class="w-full bg-[#5D4037] hover:bg-[#3E2723] text-white text-xs md:text-sm font-semibold py-2.5 rounded-xl transition-all flex items-center justify-center gap-2 active:scale-95">
                                            <i class="fas fa-plus"></i> Keranjang
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- State Kosong --}}
                        <div class="w-full text-center py-12 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                            <i class="fas fa-cookie-bite text-4xl text-gray-300 mb-2"></i>
                            <p class="text-gray-500">Belum ada produk unggulan.</p>
                        </div>
                    @endforelse

                </div>
                
                {{-- Tombol Lihat Semua (Mobile) --}}
                <div class="mt-4 text-center md:hidden">
                    <a href="{{ route('products.catalog') }}" class="text-[#5D4037] text-sm font-semibold underline">
                        Lihat Katalog Lengkap
                    </a>
                </div>

            </div>
        </section>

    </div>

    {{-- Javascript untuk Slider --}}
    <script>
        
    </script>
@endsection