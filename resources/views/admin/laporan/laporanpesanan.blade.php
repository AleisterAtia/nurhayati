@extends('layouts.navbaradmin')

@section('title', 'Laporan Pesanan')
@section('page-title', 'Laporan Pesanan')

@section('content')
    <div class="container mx-auto px-4 sm:px-8 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Laporan Pesanan</h1>
                <p class="text-gray-500 text-sm mt-1">Rekap data transaksi berdasarkan periode tanggal.</p>
            </div>
            {{-- Tombol Export PDF --}}
            <a href="{{ route('laporan.export.pdf', request()->all()) }}" target="_blank"
                class="mt-4 md:mt-0 bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300 flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>

        {{-- Filter Section --}}
        <div class="bg-white p-6 rounded-xl shadow-md mb-8 border border-gray-100">
            <form method="GET" action="{{ route('laporan.laporanpesanan') }}"
                class="flex flex-col md:flex-row items-end gap-4">
                <div class="w-full md:w-auto">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="from" value="{{ request('from') }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 border">
                </div>
                <div class="w-full md:w-auto">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="to" value="{{ request('to') }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 border">
                </div>
                <div class="w-full md:w-auto pb-0.5">
                    <button type="submit"
                        class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow transition duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-filter"></i> Filter Data
                    </button>
                </div>
            </form>
        </div>

        {{-- Table Section --}}
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr
                            class="bg-gray-50 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <th class="px-5 py-4 text-center w-16">No</th>
                            <th class="px-5 py-4">Nama Customer</th>
                            <th class="px-5 py-4">Produk</th>
                            <th class="px-5 py-4 text-center">Jumlah</th>
                            <th class="px-5 py-4">Total Harga</th>
                            <th class="px-5 py-4 text-center">Status</th>
                            <th class="px-5 py-4">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-5 py-4 text-center text-sm text-gray-500">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- FIX: Menggunakan relasi user, bukan customer_name --}}
                                <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                    {{ $order->user->name ?? 'Guest/Terhapus' }}
                                </td>

                                {{-- FIX: Menggunakan kolom 'produk' (string) atau 'orderItems' jika ada --}}
                                {{-- Jika error lagi, ganti $order->produk dengan $order->nama_produk sesuai DB --}}
                                <td class="px-5 py-4 text-sm text-gray-600">
                                    {{ $order->produk ?? '-' }}
                                </td>

                                {{-- FIX: Menggunakan kolom 'jumlah' --}}
                                <td class="px-5 py-4 text-center text-sm text-gray-600">
                                    {{ $order->jumlah ?? 1 }}
                                </td>

                                {{-- FIX: Menggunakan kolom 'total_amount' --}}
                                <td class="px-5 py-4 text-sm font-bold text-gray-800">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>

                                <td class="px-5 py-4 text-center">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'shipped' => 'bg-indigo-100 text-indigo-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $class = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $class }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-sm text-gray-600">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-file-invoice text-4xl mb-3 text-gray-300"></i>
                                        <p>Tidak ada data pesanan pada periode ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
