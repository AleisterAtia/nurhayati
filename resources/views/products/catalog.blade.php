@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
    {{-- Main Wrapper: Background Cream sesuai tema --}}
    <div class="bg-[#FFFBF2] min-h-screen py-8 px-4 sm:px-6 lg:px-8 font-sans">

        <div class="max-w-7xl mx-auto">

            {{-- === BAGIAN BREADCRUMB (BARU) === --}}
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    {{-- Item 1: Home --}}
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-[#5D4037] transition-colors">
                            <i class="fas fa-home mr-2"></i>
                            Beranda
                        </a>
                    </li>

                    {{-- Separator --}}
                    <li>
                        <div class="flex items-center animate__animated animate__fadeInUp">
                            <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                            {{-- Item 2: Halaman Aktif (Katalog) --}}
                            <span class="text-sm font-bold text-[#5D4037]">Katalog Produk</span>
                        </div>
                    </li>
                </ol>
            </nav>
            {{-- === END BREADCRUMB === --}}

            {{-- Header Bagian Katalog --}}
            <div class="text-center mb-10 space-y-2 animate-fade-in-down">
                <h1 class="text-3xl md:text-4xl font-bold text-[#3E2723]">Katalog Produk</h1>
                <p class="text-gray-600 max-w-2xl mx-auto">Temukan berbagai keripik tradisional pilihan terbaik dengan cita
                    rasa khas Nusantara.</p>
            </div>

            {{-- Filter & Sorting Toolbar --}}
            <div
                class="flex flex-col md:flex-row justify-between items-center mb-8 bg-white p-4 rounded-xl shadow-sm border border-orange-100">

                {{-- Kiri: Jumlah Produk --}}
                <p class="text-[#5D4037] font-medium mb-4 md:mb-0 text-sm md:text-base">
                    Menampilkan <span class="font-bold">{{ $products->count() }}</span> dari <span
                        class="font-bold">{{ $products->total() }}</span> produk
                </p>

                {{-- Kanan: Form Sorting --}}
                <form action="{{ route('products.catalog') }}" method="GET"
                    class="flex items-center gap-3 w-full md:w-auto">
                    <label for="sort" class="text-sm font-medium text-gray-600 whitespace-nowrap">Urutkan:</label>
                    <div class="relative w-full md:w-48">
                        <select name="urutkan" id="sort" onchange="this.form.submit()"
                            class="appearance-none bg-orange-50 border border-orange-200 text-[#5D4037] text-sm rounded-lg focus:ring-[#D84315] focus:border-[#D84315] block w-full pl-4 pr-10 py-2.5 cursor-pointer hover:bg-orange-100 transition-colors">
                            <option value="name-asc" @selected(request('urutkan') == 'name-asc')>Nama A-Z</option>
                            <option value="name-desc" @selected(request('urutkan') == 'name-desc')>Nama Z-A</option>
                            <option value="price-asc" @selected(request('urutkan') == 'price-asc')>Harga Terendah</option>
                            <option value="price-desc" @selected(request('urutkan') == 'price-desc')>Harga Tertinggi</option>
                        </select>
                        {{-- Icon Panah Dropdown Custom --}}
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-[#5D4037]">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Grid Produk --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($products as $product)
                    {{-- Kartu Produk --}}
                    <div
                        class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden border border-orange-100 h-full transform hover:-translate-y-1">

                        {{-- Link Pembungkus (Gambar & Info) --}}
                        <a href="{{ route('product.show', $product) }}" class="block flex-1 relative overflow-hidden">
                            {{-- Image Container --}}
                            <div class="aspect-[4/3] w-full overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset($product->image ?? 'placeholder.jpg') }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-500">

                                {{-- Overlay Badge (Rating) --}}
                                <div
                                    class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg shadow-sm flex items-center gap-1">
                                    <span class="text-yellow-500 text-xs">⭐</span>
                                    <span class="text-xs font-bold text-gray-700">{{ $product->rating ?? '5.0' }}</span>
                                </div>
                            </div>

                            {{-- Product Info --}}
                            <div class="p-5">
                                <h3
                                    class="text-lg font-bold text-[#3E2723] mb-1 leading-tight group-hover:text-[#D84315] transition-colors line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                <div class="flex items-baseline gap-2 mb-3">
                                    <span class="text-xl font-bold text-[#D84315]">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 line-clamp-2">
                                    {{ Str::limit($product->description ?? 'Nikmati kerenyahan keripik yang dibuat dari bahan pilihan.', 80) }}
                                </p>
                            </div>
                        </a>

                        {{-- Action Button --}}
                        <div class="p-5 pt-0 mt-auto">
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 bg-[#5D4037] hover:bg-[#3E2723] text-white font-medium py-2.5 px-4 rounded-xl transition-colors duration-300 shadow-sm hover:shadow-md active:scale-95">
                                    <i class="fas fa-shopping-cart text-sm"></i>
                                    <span>Tambah</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                        <div class="bg-orange-50 p-6 rounded-full mb-4">
                            <i class="fas fa-search text-4xl text-orange-300"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-[#5D4037] mb-2">Produk Tidak Ditemukan</h3>
                        <p class="text-gray-500 max-w-md mx-auto">
                            Maaf, kami tidak dapat menemukan produk yang sesuai dengan kriteria penyortiran Anda.
                        </p>
                        <a href="{{ route('products.catalog') }}"
                            class="mt-6 text-[#D84315] hover:text-[#BF360C] font-medium hover:underline">
                            Muat Ulang Katalog
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12 flex justify-center">
                <div class="pagination-custom">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Custom CSS untuk Pagination --}}
    @push('styles')
        <style>
            .pagination-custom nav div[class*="flex justify-between"] {
                display: none;
            }

            .pagination-custom nav div[class*="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"]>div:first-child {
                display: none;
            }

            .pagination-custom span.relative.z-0.inline-flex.shadow-sm.rounded-md {
                box-shadow: none !important;
                gap: 0.5rem;
            }

            .pagination-custom span[aria-current="page"]>span {
                background-color: #5D4037 !important;
                color: white !important;
                border-color: #5D4037 !important;
                border-radius: 0.5rem;
            }

            .pagination-custom a {
                border-radius: 0.5rem;
                color: #5D4037 !important;
                border: 1px solid #EFEBE9 !important;
            }

            .pagination-custom a:hover {
                background-color: #FFF3E0 !important;
            }
        </style>
    @endpush
@endsection
