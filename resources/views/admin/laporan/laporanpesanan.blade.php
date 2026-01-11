@extends('layouts.navbaradmin')

@section('title', 'Laporan Pesanan')
@section('page-title', 'Laporan Pesanan')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 font-sans text-gray-800">

        {{-- HEADER SECTION --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-[#3E2723]">Laporan Pesanan</h1>
                <p class="text-gray-500 mt-1 text-sm">Rekapitulasi data transaksi dan performa penjualan.</p>
            </div>
            
            {{-- Tombol Export dengan Efek --}}
            <a href="{{ route('laporan.export.pdf', request()->all()) }}" target="_blank"
                class="group bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg hover:shadow-red-200 transition-all duration-300 flex items-center gap-2 transform hover:-translate-y-0.5">
                <i class="fas fa-file-pdf text-lg group-hover:animate-bounce"></i> 
                <span>Export PDF</span>
            </a>
        </div>

        {{-- STATS CARDS (RINGKASAN CEPAT) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Card 1: Total Transaksi --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="bg-blue-50 p-4 rounded-xl text-blue-600">
                    <i class="fas fa-shopping-bag text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Transaksi</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $orders->count() }}</h3>
                </div>
            </div>

            {{-- Card 2: Total Pendapatan (Hitung manual dari data yang tampil) --}}
            @php $totalOmset = $orders->sum('total_amount'); @endphp
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="bg-green-50 p-4 rounded-xl text-green-600">
                    <i class="fas fa-wallet text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Omset (Periode Ini)</p>
                    <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h3>
                </div>
            </div>

            {{-- Card 3: Filter Info --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="bg-orange-50 p-4 rounded-xl text-orange-600">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Periode Filter</p>
                    <h3 class="text-sm font-bold text-gray-800">
                        {{ request('from') ? \Carbon\Carbon::parse(request('from'))->format('d M Y') : 'Awal' }} 
                        - 
                        {{ request('to') ? \Carbon\Carbon::parse(request('to'))->format('d M Y') : 'Sekarang' }}
                    </h3>
                </div>
            </div>
        </div>

        {{-- MAIN CARD: FILTER & TABLE --}}
        <div class="bg-white shadow-xl shadow-gray-100 rounded-3xl overflow-hidden border border-gray-100">
            
            {{-- FILTER BAR --}}
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <form method="GET" action="{{ route('laporan.laporanpesanan') }}"
                    class="flex flex-col md:flex-row items-end gap-4">
                    
                    <div class="w-full md:w-auto flex-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Dari Tanggal</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar text-gray-400"></i>
                            </div>
                            <input type="date" name="from" value="{{ request('from') }}"
                                class="pl-10 w-full bg-white border-gray-200 rounded-xl focus:ring-[#5D4037] focus:border-[#5D4037] text-sm py-2.5 shadow-sm">
                        </div>
                    </div>

                    <div class="w-full md:w-auto flex-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sampai Tanggal</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar text-gray-400"></i>
                            </div>
                            <input type="date" name="to" value="{{ request('to') }}"
                                class="pl-10 w-full bg-white border-gray-200 rounded-xl focus:ring-[#5D4037] focus:border-[#5D4037] text-sm py-2.5 shadow-sm">
                        </div>
                    </div>

                    <div class="w-full md:w-auto">
                        <button type="submit"
                            class="w-full md:w-auto bg-[#5D4037] hover:bg-[#3E2723] text-white font-bold px-8 py-2.5 rounded-xl shadow-md transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-filter"></i> Terapkan
                        </button>
                    </div>
                </form>
            </div>

            {{-- TABLE SECTION --}}
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-white border-b border-gray-200 text-left">
                            <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider w-1/3">Detail Item</th>
                            <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Total</th>
                            <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $order)
                            <tr class="hover:bg-orange-50/50 transition duration-150 group">
                                <td class="px-6 py-5 text-sm text-gray-500">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-5 text-sm text-gray-600">
                                    <div class="font-medium">{{ $order->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }} WIB</div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-orange-100 flex items-center justify-center text-[#D84315] font-bold text-xs mr-3">
                                            {{ substr($order->user->name ?? 'G', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $order->user->name ?? 'Guest' }}</p>
                                            <p class="text-xs text-gray-500">#{{ $order->order_number }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <ul class="space-y-1">
                                        {{-- Cek apakah pakai relasi orderItems atau kolom manual --}}
                                        @if($order->orderItems && $order->orderItems->count() > 0)
                                            @foreach($order->orderItems as $item)
                                                <li class="text-sm text-gray-600 flex justify-between border-b border-dashed border-gray-100 pb-1 last:border-0">
                                                    <span>{{ $item->product->name ?? 'Produk dihapus' }}</span>
                                                    <span class="font-bold text-gray-800 text-xs bg-gray-100 px-2 py-0.5 rounded-md">x{{ $item->quantity }}</span>
                                                </li>
                                            @endforeach
                                        @else
                                            {{-- Fallback jika pakai kolom manual --}}
                                            <li class="text-sm text-gray-600">
                                                {{ $order->produk ?? '-' }} 
                                                <span class="font-bold text-xs ml-1">(x{{ $order->jumlah ?? 1 }})</span>
                                            </li>
                                        @endif
                                    </ul>
                                </td>

                                <td class="px-6 py-5 text-right">
                                    <span class="block text-sm font-bold text-[#3E2723]">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-center">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200', 'label' => 'Menunggu'],
                                            'processing' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'label' => 'Diproses'],
                                            'shipped' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'border' => 'border-indigo-200', 'label' => 'Dikirim'],
                                            'completed' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200', 'label' => 'Selesai'],
                                            'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'label' => 'Batal'],
                                        ];
                                        $config = $statusConfig[$order->status] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'border' => 'border-gray-200', 'label' => ucfirst($order->status)];
                                    @endphp
                                    <span class="px-3 py-1.5 rounded-full text-xs font-bold border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                        {{ $config['label'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-50 p-4 rounded-full mb-3">
                                            <i class="fas fa-search text-3xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">Data Tidak Ditemukan</h3>
                                        <p class="text-gray-500 text-sm mt-1">Coba ubah filter tanggal untuk melihat data lainnya.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- FOOTER TABLE (Pagination jika ada) --}}
            @if(method_exists($orders, 'hasPages') && $orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $orders->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection