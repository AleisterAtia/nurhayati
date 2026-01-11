@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    {{-- Main Wrapper: Background Cream --}}
    <div class="bg-[#FFFBF2] min-h-screen py-8 md:py-12 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Header --}}
            <div class="mb-8 animate-fade-in-down">
                <h1 class="text-3xl md:text-4xl font-extrabold text-[#3E2723] mb-2">Keranjang Belanja</h1>
                <div class="h-1 w-20 bg-[#D84315] rounded-full"></div>
            </div>

            @if (isset($cartItems) && count($cartItems) > 0)
                <div class="flex flex-col lg:flex-row gap-8">

                    {{-- KOLOM KIRI: DAFTAR ITEM (2/3 Lebar) --}}
                    <div class="lg:w-2/3 space-y-4">
                        <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
                            {{-- Header Tabel (Hanya di Desktop) --}}
                            <div class="hidden md:grid grid-cols-12 gap-4 p-4 bg-orange-50 text-sm font-semibold text-[#5D4037] border-b border-orange-100">
                                <div class="col-span-6">Produk</div>
                                <div class="col-span-3 text-center">Jumlah</div>
                                <div class="col-span-3 text-right">Subtotal</div>
                            </div>

                            {{-- List Items --}}
                            <div class="divide-y divide-gray-100">
                                @foreach ($cartItems as $id => $item)
                                    <div class="p-4 md:p-6 grid grid-cols-1 md:grid-cols-12 gap-6 items-center group hover:bg-orange-50/30 transition-colors duration-200">

                                        {{-- 1. Info Produk (Gambar & Nama) --}}
                                        <div class="md:col-span-6 flex items-center gap-4">
                                            {{-- Gambar --}}
                                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-xl border border-gray-200 bg-gray-100">
                                                <img src="{{ asset($item['image'] ?? 'placeholder.jpg') }}"
                                                    alt="{{ $item['name'] }}"
                                                    class="h-full w-full object-cover object-center">
                                            </div>
                                            {{-- Detail --}}
                                            <div>
                                                <h3 class="text-lg font-bold text-[#3E2723] group-hover:text-[#D84315] transition-colors">
                                                    {{ $item['name'] }}
                                                </h3>
                                                <p class="text-sm text-gray-500 mb-2">Harga Satuan: Rp
                                                    {{ number_format($item['price']) }}</p>

                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Hapus item ini?')"
                                                        class="text-xs text-red-500 hover:text-red-700 flex items-center gap-1 font-medium transition-colors">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        {{-- 2. Kontrol Jumlah (DIPERBAIKI: Input Manual & Validasi Stok) --}}
                                        <div class="md:col-span-3 flex justify-start md:justify-center">
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="cart-update-form">
                                                @csrf
                                                @method('PATCH')
                                                <div class="flex items-center border border-[#5D4037] rounded-full h-9">
                                                    
                                                    {{-- Tombol Minus --}}
                                                    <button type="button" onclick="updateQuantity(this, -1, {{ $item['stock'] }})"
                                                        class="w-8 h-full flex items-center justify-center text-[#5D4037] hover:bg-orange-100 rounded-l-full transition">
                                                        <i class="fas fa-minus text-xs"></i>
                                                    </button>

                                                    {{-- Input Manual (Bisa diketik, ada max stok) --}}
                                                    <input type="number" name="quantity" 
                                                        value="{{ $item['quantity'] }}"
                                                        min="1" 
                                                        max="{{ $item['stock'] }}"
                                                        class="qty-input w-12 text-center border-none p-0 text-sm font-bold text-[#5D4037] bg-transparent focus:ring-0 appearance-none"
                                                        onchange="validateManualInput(this, {{ $item['stock'] }})"
                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 

                                                    {{-- Tombol Plus --}}
                                                    <button type="button" onclick="updateQuantity(this, 1, {{ $item['stock'] }})"
                                                        class="w-8 h-full flex items-center justify-center text-[#5D4037] hover:bg-orange-100 rounded-r-full transition">
                                                        <i class="fas fa-plus text-xs"></i>
                                                    </button>
                                                </div>
                                                
                                                {{-- Info Stok --}}
                                                <div class="text-center mt-1">
                                                    <span class="text-[10px] text-gray-400">Stok: {{ $item['stock'] }}</span>
                                                </div>
                                            </form>
                                        </div>

                                        {{-- 3. Subtotal Item --}}
                                        <div class="md:col-span-3 flex justify-between md:justify-end items-center mt-2 md:mt-0">
                                            <span class="md:hidden text-sm text-gray-500 font-medium">Subtotal:</span>
                                            <span class="text-lg font-bold text-[#D84315]">
                                                Rp {{ number_format($item['price'] * $item['quantity']) }}
                                            </span>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Tombol Lanjut Belanja --}}
                        <div class="hidden lg:block mt-6">
                            <a href="{{ route('home') }}#produk"
                                class="inline-flex items-center gap-2 text-[#5D4037] hover:text-[#D84315] font-semibold transition-colors">
                                <i class="fas fa-arrow-left"></i> Lanjut Belanja
                            </a>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: RINGKASAN --}}
                    <div class="lg:w-1/3">
                        <div class="bg-white rounded-2xl shadow-lg border border-orange-100 p-6 lg:sticky lg:top-24">
                            <h2 class="text-xl font-bold text-[#3E2723] mb-6 border-b border-gray-100 pb-4">Ringkasan Pesanan</h2>

                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Total Item</span>
                                    <span class="font-medium">{{ count($cartItems) }} Item</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span class="font-medium">Rp {{ number_format($subtotal) }}</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center border-t border-dashed border-gray-300 pt-4 mb-6">
                                <span class="text-lg font-bold text-[#3E2723]">Total Belanja</span>
                                <span class="text-2xl font-bold text-[#D84315]">Rp {{ number_format($subtotal) }}</span>
                            </div>

                            <a href="{{ route('checkout.show') }}"
                                class="block w-full bg-[#5D4037] hover:bg-[#3E2723] text-white text-center font-bold py-3.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                Checkout Sekarang <i class="fas fa-chevron-right ml-2 text-xs"></i>
                            </a>

                            <div class="block lg:hidden mt-4 text-center">
                                <a href="{{ route('home') }}#produk" class="text-sm text-[#5D4037] hover:text-[#D84315] font-semibold">
                                    Atau Lanjut Belanja
                                </a>
                            </div>

                            <div class="mt-6 flex items-center justify-center gap-2 text-xs text-gray-400">
                                <i class="fas fa-lock"></i> Transaksi Aman & Terenkripsi
                            </div>
                        </div>
                    </div>

                </div>
            @else
                {{-- KOSONG STATE --}}
                <div class="flex flex-col items-center justify-center py-16 text-center bg-white rounded-3xl shadow-sm border border-orange-50 max-w-2xl mx-auto">
                    <div class="bg-orange-50 p-6 rounded-full mb-6 animate-bounce-slow">
                        <i class="fas fa-shopping-basket text-5xl text-[#D84315]"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-[#3E2723] mb-3">Keranjang Belanja Kosong</h2>
                    <p class="text-gray-500 max-w-md mx-auto mb-8 leading-relaxed">
                        Sepertinya belum menambahkan camilan lezat apapun. Mari jelajahi katalog kami!
                    </p>
                    <a href="{{ route('home') }}#produk"
                        class="inline-flex items-center gap-2 bg-[#5D4037] hover:bg-[#3E2723] text-white font-bold px-8 py-3 rounded-full shadow-lg transition-all duration-300">
                        Mulai Belanja <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Fungsi untuk tombol Plus/Minus
        function updateQuantity(button, change, maxStock) {
            const form = button.closest('form');
            const input = form.querySelector('.qty-input');
            let currentValue = parseInt(input.value) || 0;
            let newValue = currentValue + change;

            // Validasi Min 1
            if (newValue < 1) {
                newValue = 1;
            }

            // Validasi Max Stok
            if (newValue > maxStock) {
                alert('Maksimal stok tersedia hanya ' + maxStock + ' item.');
                newValue = maxStock;
            }

            // Jika nilai berubah, submit form
            if (newValue !== currentValue) {
                input.value = newValue;
                form.submit();
            }
        }

        // Fungsi untuk Input Manual (Ketik Sendiri)
        function validateManualInput(input, maxStock) {
            let value = parseInt(input.value);

            // Jika kosong atau bukan angka, kembalikan ke 1
            if (isNaN(value) || value < 1) {
                input.value = 1;
            } 
            // Jika melebihi stok
            else if (value > maxStock) {
                alert('Stok tidak mencukupi! Maksimal: ' + maxStock);
                input.value = maxStock;
            }

            // Submit form setelah validasi selesai
            input.form.submit();
        }
    </script>
    
    {{-- CSS untuk menghilangkan panah input number --}}
    <style>
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush