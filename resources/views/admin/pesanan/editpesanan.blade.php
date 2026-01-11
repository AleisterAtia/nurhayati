@extends('layouts.navbaradmin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Pesanan <span class="text-[#5D4037]">#{{ $order->order_number }}</span></h1>
                <a href="{{ route('orders.index') }}"
                    class="text-gray-600 hover:text-[#5D4037] font-medium flex items-center gap-2 transition-colors">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100 p-6">
                <form action="{{ route('orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Section: Info Pelanggan --}}
                        <div class="col-span-1 md:col-span-2">
                            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Informasi Pelanggan</h2>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan</label>
                            <input type="text" value="{{ $order->user->name ?? 'Guest' }}" disabled
                                class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 text-gray-500 cursor-not-allowed">
                            <p class="text-xs text-gray-400 mt-1">*Nama pelanggan tidak dapat diubah.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="text" value="{{ $order->user->email ?? '-' }}" disabled
                                class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 text-gray-500 cursor-not-allowed">
                        </div>

                        {{-- Section: Detail Pesanan --}}
                        <div class="col-span-1 md:col-span-2 mt-4">
                            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Detail Pesanan</h2>
                        </div>

                        {{-- Status Pesanan (Bisa Diedit Admin) --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Pesanan</label>
                            <select name="status" id="status"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#5D4037] focus:border-[#5D4037] px-4 py-2 border">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing (Diproses)</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Dikirim)</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                            </select>
                        </div>

                        {{-- Metode Pembayaran (READ ONLY / TIDAK BISA DIUBAH) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                            <input type="text" 
                                value="{{ $order->payment_method ?? 'Belum Dipilih' }}" 
                                readonly
                                class="w-full bg-gray-100 border border-gray-300 rounded-lg shadow-sm px-4 py-2 text-gray-600 font-semibold cursor-not-allowed focus:outline-none">
                        </div>

                        {{-- Alamat Pengiriman --}}
                        <div class="col-span-1 md:col-span-2">
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
                            <textarea name="shipping_address" id="shipping_address" rows="3"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#5D4037] focus:border-[#5D4037] px-4 py-2 border">{{ $order->shipping_address }}</textarea>
                        </div>

                        {{-- Section: Rincian Biaya --}}
                        <div class="col-span-1 md:col-span-2 mt-4">
                            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Rincian Biaya</h2>
                        </div>

                        <div>
                            <label for="total_amount" class="block text-sm font-medium text-gray-700 mb-1">Total Harga Produk (Rp)</label>
                            <input type="number" name="total_amount" id="total_amount" value="{{ $order->total_amount }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#5D4037] focus:border-[#5D4037] px-4 py-2 border">
                        </div>

                        <div>
                            <label for="shipping_cost" class="block text-sm font-medium text-gray-700 mb-1">Ongkos Kirim (Rp)</label>
                            <input type="number" name="shipping_cost" id="shipping_cost"
                                value="{{ $order->shipping_cost }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#5D4037] focus:border-[#5D4037] px-4 py-2 border">
                        </div>

                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-8 flex items-center justify-end gap-4">
                        <a href="{{ route('orders.index') }}"
                            class="px-6 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition font-medium">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-[#5D4037] text-white rounded-lg hover:bg-[#3E2723] shadow-md hover:shadow-lg transition font-medium flex items-center gap-2">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection