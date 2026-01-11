@extends('layouts.navbaradmin')

@section('title', 'Kelola Produk')
@section('page-title', 'Daftar Produk')

@section('content')
    <div class="animate-fade-in-down">

        {{-- Header Actions --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            {{-- Tombol Tambah --}}
            <a href="{{ route('products.create') }}"
                class="group inline-flex items-center gap-2 bg-[#5D4037] hover:bg-[#3E2723] text-white px-6 py-3 rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 font-medium">
                <div
                    class="bg-white/20 rounded-full w-6 h-6 flex items-center justify-center group-hover:rotate-90 transition-transform duration-300">
                    <i class="fas fa-plus text-xs"></i>
                </div>
                <span>Tambah Produk</span>
            </a>

            {{-- Optional: Search Bar Kecil (Hanya UI) --}}
            {{--
            <div class="relative w-full md:w-64">
                <input type="text" placeholder="Cari produk..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-orange-200 focus:ring-[#D84315] focus:border-[#D84315] bg-white text-sm">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            --}}
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm flex justify-between items-center animate-fade-in-down"
                role="alert">
                <div class="flex items-center gap-3">
                    <div class="bg-green-200 rounded-full p-1">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        {{-- Card Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    {{-- Table Header --}}
                    <thead class="bg-[#5D4037] text-[#FFFBF2]">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider text-center">Gambar</th>
                            <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-orange-100">
                        @forelse($products as $product)
                            <tr class="hover:bg-orange-50/50 transition-colors duration-200 group">

                                {{-- Nama Produk --}}
                                <td class="px-6 py-4">
                                    <div class="font-bold text-[#3E2723]">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-400 mt-1 line-clamp-1">
                                        {{ $product->description ?? 'Tidak ada deskripsi' }}</div>
                                </td>

                                {{-- Harga --}}
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-orange-50 text-[#D84315] px-3 py-1 rounded-lg text-sm font-bold border border-orange-100 shadow-sm">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Stok --}}
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $product->stock > 0 ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                        @if ($product->stock > 0)
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                            {{ $product->stock }} Unit
                                        @else
                                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                            Habis
                                        @endif
                                    </span>
                                </td>

                                {{-- Gambar --}}
                                <td class="px-6 py-4 text-center">
                                    <div
                                        class="h-14 w-14 rounded-xl border border-orange-100 overflow-hidden bg-gray-50 mx-auto shadow-sm group-hover:shadow-md transition-shadow">
                                        @if ($product->image)
                                            <img src="{{ asset($product->image) }}"
                                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                                alt="{{ $product->name }}">
                                        @else
                                            <div class="flex items-center justify-center h-full text-gray-300">
                                                <i class="fas fa-image text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="w-9 h-9 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 border border-blue-100 hover:bg-blue-600 hover:text-white transition-all duration-200 shadow-sm"
                                            title="Edit Produk">
                                            <i class="fas fa-pen-nib text-sm"></i>
                                        </a>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Apakah Yang Mulia yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-50 text-red-600 border border-red-100 hover:bg-red-600 hover:text-white transition-all duration-200 shadow-sm"
                                                title="Hapus Produk">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-orange-50 p-6 rounded-full mb-4">
                                            <i class="fas fa-box-open text-4xl text-orange-300"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-[#5D4037] mb-1">Belum ada produk</h3>
                                        <p class="text-gray-500 text-sm mb-6">Silakan tambahkan produk baru untuk memulai
                                            katalog Yang Mulia.</p>
                                        <a href="{{ route('products.create') }}"
                                            class="text-[#D84315] hover:text-[#BF360C] font-medium text-sm hover:underline">
                                            + Tambah Produk Sekarang
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer (Jika ada pagination) --}}
            @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="px-6 py-4 border-t border-orange-100 bg-orange-50/30">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
