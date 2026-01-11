@extends('layouts.navbaradmin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Overview')

@section('content')
    <div class="animate-fade-in-down">

        {{-- SECTION 1: STATISTIC CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            {{-- Card 1: Total Users --}}
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Pengguna</p>
                        <h2 class="text-3xl font-bold text-[#3E2723] group-hover:text-[#D84315] transition-colors">
                            {{ number_format($totalUsers) }}
                        </h2>
                    </div>
                    <div
                        class="h-12 w-12 bg-orange-100 rounded-full flex items-center justify-center text-[#D84315] group-hover:bg-[#D84315] group-hover:text-white transition-all duration-300">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                    <span class="text-green-500 font-medium">Updated</span>
                    <span class="ml-1">Just now</span>
                </div>
            </div>

            {{-- Card 2: Total Orders --}}
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Pesanan</p>
                        <h2 class="text-3xl font-bold text-[#3E2723] group-hover:text-[#D84315] transition-colors">
                            {{ number_format($totalOrders) }}
                        </h2>
                    </div>
                    <div
                        class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-shopping-bag text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <span class="text-gray-500">Data pesanan masuk</span>
                </div>
            </div>

            {{-- Card 3: Revenue --}}
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Pendapatan</p>
                        <h2 class="text-3xl font-bold text-[#3E2723] group-hover:text-[#D84315] transition-colors">
                            Rp {{ number_format($revenue, 0, ',', '.') }}
                        </h2>
                    </div>
                    <div
                        class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <span class="text-gray-500">Total pendapatan bersih</span>
                </div>
            </div>
        </div>

        {{-- SECTION 2: LATEST USERS TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-bold text-[#3E2723]">Pengguna Terbaru</h2>
                <a href="#" class="text-sm text-[#D84315] hover:text-[#BF360C] font-medium hover:underline">Lihat
                    Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-orange-50/50 text-[#5D4037] text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-semibold">Nama Pengguna</th>
                            <th class="px-6 py-4 font-semibold">Email</th>
                            <th class="px-6 py-4 font-semibold">Role</th>
                            <th class="px-6 py-4 font-semibold">Tanggal Bergabung</th>
                            <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($latestUsers as $user)
                            <tr class="hover:bg-orange-50/30 transition-colors duration-200 group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        {{-- Avatar Inisial --}}
                                        <div
                                            class="h-9 w-9 rounded-full bg-[#D7CCC8] flex items-center justify-center text-[#5D4037] font-bold text-xs">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-400 md:hidden">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{-- Badge Role Dinamis --}}
                                    @if ($user->role === 'admin')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                            Admin
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            Customer
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $user->created_at->format('d M Y') }}
                                    <span
                                        class="text-xs text-gray-400 block">{{ $user->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        class="text-gray-400 hover:text-[#D84315] transition-colors p-2 rounded-full hover:bg-orange-50">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data pengguna.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
