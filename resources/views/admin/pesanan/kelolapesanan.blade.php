@extends('layouts.navbaradmin')

@section('content')
    <div class="container mx-auto px-4 sm:px-8 py-8">
        
        {{-- HEADER & ACTIONS --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Kelola Pesanan</h1>
                <p class="text-gray-500 text-sm mt-1">Daftar semua transaksi pesanan pelanggan.</p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                {{-- Form Pencarian --}}
                <form action="{{ route('orders.index') }}" method="GET" class="relative w-full md:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari No. Order / Nama..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-[#5D4037] focus:border-[#5D4037] text-sm transition shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    
                    {{-- Hidden input untuk menjaga sorting saat search --}}
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                    @endif
                </form>

                {{-- Tombol Tambah --}}
                <a href="{{ route('orders.create') }}"
                    class="bg-[#5D4037] hover:bg-[#3E2723] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 flex items-center justify-center gap-2 text-sm whitespace-nowrap">
                    <i class="fas fa-plus"></i> Tambah Pesanan
                </a>
            </div>
        </div>

        {{-- TABEL DATA --}}
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            
                            {{-- KOLOM SORTABLE --}}
                            <th class="px-5 py-4 cursor-pointer hover:bg-gray-100 transition" onclick="window.location='{{ route('orders.index', ['sort' => 'order_number', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}'">
                                <div class="flex items-center gap-1">
                                    No. Order
                                    @if(request('sort') == 'order_number')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-[#5D4037]"></i>
                                    @else
                                        <i class="fas fa-sort text-gray-300"></i>
                                    @endif
                                </div>
                            </th>

                            <th class="px-5 py-4">Pelanggan</th>
                            <th class="px-5 py-4">Metode Bayar</th>
                            <th class="px-5 py-4 text-center">Bukti Bayar</th>

                            <th class="px-5 py-4 cursor-pointer hover:bg-gray-100 transition" onclick="window.location='{{ route('orders.index', ['sort' => 'total_amount', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}'">
                                <div class="flex items-center gap-1">
                                    Total & Ongkir
                                    @if(request('sort') == 'total_amount')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-[#5D4037]"></i>
                                    @else
                                        <i class="fas fa-sort text-gray-300"></i>
                                    @endif
                                </div>
                            </th>

                            <th class="px-5 py-4 text-center cursor-pointer hover:bg-gray-100 transition" onclick="window.location='{{ route('orders.index', ['sort' => 'status', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}'">
                                <div class="flex items-center justify-center gap-1">
                                    Status
                                    @if(request('sort') == 'status')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-[#5D4037]"></i>
                                    @else
                                        <i class="fas fa-sort text-gray-300"></i>
                                    @endif
                                </div>
                            </th>

                            <th class="px-5 py-4 cursor-pointer hover:bg-gray-100 transition" onclick="window.location='{{ route('orders.index', ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}'">
                                <div class="flex items-center gap-1">
                                    Tanggal
                                    @if(request('sort') == 'created_at' || !request('sort'))
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-[#5D4037]"></i>
                                    @else
                                        <i class="fas fa-sort text-gray-300"></i>
                                    @endif
                                </div>
                            </th>

                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-5 py-4 text-sm font-medium text-gray-900">#{{ $order->order_number }}</td>
                                <td class="px-5 py-4 text-sm text-gray-700">
                                    <div class="font-bold">{{ $order->user->name ?? 'Guest' }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $order->shipping_address ? Str::limit($order->shipping_address, 20) : '-' }}
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-600">
                                    {{ $order->payment_method ? ucfirst($order->payment_method) : '-' }}
                                </td>

                                {{-- Kolom Bukti Bayar --}}
                                <td class="px-5 py-4 text-center">
                                    @if($order->payment_proof)
                                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank"
                                           class="inline-flex items-center gap-1 px-3 py-1 bg-green-50 text-green-700 rounded-md text-xs font-bold hover:bg-green-100 transition border border-green-200">
                                            <i class="fas fa-image"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Belum Upload</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    <div class="font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                </td>
                                
                                <td class="px-5 py-4 text-center">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border 
                                        {{ $order->status == 'completed' ? 'bg-green-100 text-green-800 border-green-200' : 
                                           ($order->status == 'cancelled' ? 'bg-red-100 text-red-800 border-red-200' : 
                                           ($order->status == 'processing' ? 'bg-blue-100 text-blue-800 border-blue-200' : 'bg-gray-100 text-gray-800 border-gray-200')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                
                                <td class="px-5 py-4 text-sm text-gray-600">
                                    {{ $order->created_at->format('d M Y') }}
                                    <span class="block text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</span>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('orders.printLabel', $order->id) }}" target="_blank"
                                            class="p-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition" title="Cetak Label">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <a href="{{ route('orders.edit', $order->id) }}"
                                            class="p-2 bg-yellow-50 text-yellow-600 rounded hover:bg-yellow-100 transition" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline-block"
                                            onsubmit="return confirm('Hapus pesanan ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded hover:bg-red-100 transition" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-search text-4xl text-gray-300 mb-3"></i>
                                        <p>Data pesanan tidak ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if ($orders->hasPages())
                <div class="px-5 py-4 bg-white border-t border-gray-200">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection