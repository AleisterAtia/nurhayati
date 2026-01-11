@extends('layouts.app')

@section('title', $product->name)

@section('content')
    {{-- Main Wrapper: Background Cream --}}
    <div class="bg-[#FFFBF2] min-h-screen py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- 1. BREADCRUMB --}}
            <nav class="flex mb-8 text-sm font-medium text-gray-500 animate-fade-in-down" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="hover:text-[#D84315] transition-colors">
                            <i class="fas fa-home mr-2"></i>Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-xs mx-2 text-gray-400"></i>
                            <a href="{{ route('home') }}#produk" class="hover:text-[#D84315] transition-colors">Katalog</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-xs mx-2 text-gray-400"></i>
                            <span class="text-[#5D4037] font-semibold">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            {{-- 2. PRODUCT LAYOUT (Grid 2 Kolom) --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-orange-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0 md:gap-8">

                    {{-- KOLOM KIRI: GAMBAR PRODUK --}}
                    <div class="relative bg-gray-100 h-96 md:h-[600px] group overflow-hidden">
                        <img src="{{ asset($product->image ?? 'placeholder.jpg') }}" alt="{{ $product->name }}"
                            class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105">

                        {{-- Badge Stok (Overlay) --}}
                        @if ($product->stock > 0)
                            <div
                                class="absolute top-4 left-4 bg-green-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                Ready Stock
                            </div>
                        @else
                            <div
                                class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                Habis
                            </div>
                        @endif
                    </div>

                    {{-- KOLOM KANAN: INFORMASI PRODUK --}}
                    <div class="p-8 md:p-12 flex flex-col justify-center">

                        <div class="mb-6">
                            <span class="text-[#D84315] font-bold tracking-wider uppercase text-sm">Cemilan Khas</span>
                            <h1 class="text-3xl md:text-5xl font-extrabold text-[#3E2723] mt-2 mb-4 leading-tight">
                                {{ $product->name }}
                            </h1>

                            {{-- Rating & Review --}}
                            <div class="flex items-center gap-4 mb-6">
                                <div class="flex items-center text-yellow-400 text-lg">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-gray-500 text-sm border-l border-gray-300 pl-4">Terjual 1.2k+</span>
                            </div>

                            <div class="text-4xl font-bold text-[#D84315] mb-6">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            <div class="prose text-gray-600 leading-relaxed mb-8">
                                <h3 class="font-bold text-[#5D4037] mb-2">Deskripsi Produk:</h3>
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>

                        {{-- Form Add to Cart --}}
                        <form action="{{ route('cart.add', $product) }}" method="POST"
                            class="mt-auto border-t border-gray-100 pt-8">
                            @csrf

                            <div class="flex flex-col sm:flex-row gap-4 items-end sm:items-center mb-6">
                                {{-- Quantity Selector --}}
                                <div class="w-full sm:w-auto">
                                    <label for="quantity"
                                        class="block text-sm font-medium text-gray-700 mb-2">Jumlah:</label>
                                    <div class="flex items-center border-2 border-[#5D4037] rounded-full w-max">
                                        <button type="button" onclick="decreaseQty()"
                                            class="w-12 h-10 flex items-center justify-center text-[#5D4037] hover:bg-orange-50 rounded-l-full transition">
                                            <i class="fas fa-minus text-sm"></i>
                                        </button>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1"
                                            max="{{ $product->stock }}" readonly
                                            class="w-16 text-center border-none p-0 text-[#5D4037] font-bold text-lg focus:ring-0">
                                        <button type="button" onclick="increaseQty()"
                                            class="w-12 h-10 flex items-center justify-center text-[#5D4037] hover:bg-orange-50 rounded-r-full transition">
                                            <i class="fas fa-plus text-sm"></i>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2 ml-1">Stok tersedia: {{ $product->stock }}</p>
                                </div>

                                {{-- Add Button --}}
                                <button type="submit"
                                    class="flex-1 w-full bg-[#5D4037] hover:bg-[#3E2723] text-white font-bold py-3.5 px-8 rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>Tambah ke Keranjang</span>
                                </button>
                            </div>

                            {{-- Fitur Tambahan (Jaminan) --}}
                            <div class="grid grid-cols-2 gap-4 mt-6">
                                <div class="flex items-center gap-3 text-sm text-gray-600">
                                    <i class="fas fa-shield-alt text-[#D84315] text-xl"></i>
                                    <span>Jaminan Halal & Higienis</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-600">
                                    <i class="fas fa-shipping-fast text-[#D84315] text-xl"></i>
                                    <span>Pengiriman Cepat</span>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function increaseQty() {
            const qtyInput = document.getElementById('quantity');
            // Pastikan tidak melebihi stok (jika ada data stok di atribut max)
            const maxStock = parseInt(qtyInput.getAttribute('max')) || 999;
            const currentVal = parseInt(qtyInput.value);

            if (currentVal < maxStock) {
                qtyInput.value = currentVal + 1;
            }
        }

        function decreaseQty() {
            const qtyInput = document.getElementById('quantity');
            const currentVal = parseInt(qtyInput.value);

            if (currentVal > 1) {
                qtyInput.value = currentVal - 1;
            }
        }
    </script>
@endpush
