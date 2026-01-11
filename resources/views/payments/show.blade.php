@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
    <div class="bg-[#FFFBF2] min-h-screen py-12 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-4xl mx-auto">

            {{-- Form untuk Update Metode Pembayaran --}}
            <form action="{{ route('orders.update-payment-method', $order->id) }}" method="POST" id="payment-form" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- Header: Status & Total --}}
                <div class="bg-white rounded-3xl shadow-xl border-t-8 border-[#D84315] overflow-hidden mb-8 animate-fade-in-down">
                    <div class="p-8 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-orange-100 text-[#D84315] mb-4">
                            <i class="fas fa-wallet text-3xl"></i>
                        </div>
                        <h1 class="text-3xl font-extrabold text-[#3E2723] mb-2">Selesaikan Pembayaran</h1>
                        <p class="text-gray-500 mb-6">Order ID: <span class="font-mono font-bold text-[#5D4037]">#{{ $order->order_number ?? $order->id }}</span></p>

                        <div class="bg-orange-50 rounded-2xl p-6 border border-orange-100 max-w-xl mx-auto">
                            <p class="text-sm text-gray-500 mb-1">Total yang harus dibayar:</p>
                            <div class="flex items-center justify-center gap-3">
                                <span class="text-3xl md:text-4xl font-bold text-[#D84315]">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    {{-- KOLOM KIRI: TRANSFER BANK --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="h-8 w-1 bg-[#5D4037] rounded-full"></div>
                            <h2 class="text-xl font-bold text-[#3E2723]">Pilih Metode Transfer</h2>
                        </div>

                        {{-- Bank BRI --}}
                        <label class="block cursor-pointer">
                            <input type="radio" name="payment_method" value="Bank BRI" class="peer sr-only" required>
                            <div class="bg-white p-6 rounded-2xl shadow-sm border-2 border-transparent peer-checked:border-[#D84315] peer-checked:bg-orange-50 hover:shadow-md transition-all group relative overflow-hidden">
                                <div class="absolute top-4 right-4 text-[#D84315] opacity-0 peer-checked:opacity-100 transition-opacity">
                                    <i class="fas fa-check-circle text-2xl"></i>
                                </div>
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-[#3E2723]">Bank BRI</h3>
                                        <p class="text-sm text-gray-500">A.n Keripik Nurhayati</p>
                                    </div>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/68/BANK_BRI_logo.svg" alt="BRI" class="h-8">
                                </div>
                                <div class="bg-gray-50 p-3 rounded-xl flex justify-between items-center border border-gray-200 peer-checked:bg-white">
                                    <span class="font-mono text-lg font-bold text-[#5D4037] tracking-wider">328001036245536</span>
                                    <button type="button" onclick="copyToClipboard('328001036245536')" class="text-sm font-bold text-[#D84315] hover:text-[#BF360C]">SALIN</button>
                                </div>
                            </div>
                        </label>

                        {{-- Bank Mandiri --}}
                        <label class="block cursor-pointer">
                            <input type="radio" name="payment_method" value="Bank Mandiri" class="peer sr-only">
                            <div class="bg-white p-6 rounded-2xl shadow-sm border-2 border-transparent peer-checked:border-[#D84315] peer-checked:bg-orange-50 hover:shadow-md transition-all group relative overflow-hidden">
                                <div class="absolute top-4 right-4 text-[#D84315] opacity-0 peer-checked:opacity-100 transition-opacity">
                                    <i class="fas fa-check-circle text-2xl"></i>
                                </div>
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-[#3E2723]">Bank Mandiri</h3>
                                        <p class="text-sm text-gray-500">A.n PT Keripik Nurhayati</p>
                                    </div>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri" class="h-8">
                                </div>
                                <div class="bg-gray-50 p-3 rounded-xl flex justify-between items-center border border-gray-200 peer-checked:bg-white">
                                    <span class="font-mono text-lg font-bold text-[#5D4037] tracking-wider">0987654321</span>
                                    <button type="button" onclick="copyToClipboard('0987654321')" class="text-sm font-bold text-[#D84315] hover:text-[#BF360C]">SALIN</button>
                                </div>
                            </div>
                        </label>

                    </div>

                    {{-- KOLOM KANAN: QRIS --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="h-8 w-1 bg-[#5D4037] rounded-full"></div>
                            <h2 class="text-xl font-bold text-[#3E2723]">Scan QRIS</h2>
                        </div>

                        <label class="block cursor-pointer">
                            <input type="radio" name="payment_method" value="QRIS" class="peer sr-only">
                            <div class="bg-white p-8 rounded-3xl shadow-lg border-2 border-transparent peer-checked:border-[#D84315] text-center relative overflow-hidden peer-checked:bg-orange-50 transition-all">
                                <div class="absolute top-4 right-4 text-[#D84315] opacity-0 peer-checked:opacity-100 transition-opacity">
                                    <i class="fas fa-check-circle text-2xl"></i>
                                </div>
                                
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_QRIS.svg/1200px-Logo_QRIS.svg.png" alt="Logo QRIS" class="h-8 mx-auto mb-6">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $qrisString ?? 'ID1234567890123' }}" alt="QRIS Code" class="mx-auto mix-blend-multiply">
                                <p class="text-sm font-bold text-[#3E2723] mb-1 mt-4">NMID: ID1234567890123</p>
                                <p class="text-xs text-gray-500">PT KERIPIK NURHAYATI</p>
                            </div>
                        </label>

                        {{-- Tombol Konfirmasi --}}
                    {{-- TAMBAHAN BARU: FORM UPLOAD BUKTI --}}
        <div class="space-y-2">
            <div class="flex items-center gap-3 mb-2">
                <div class="h-8 w-1 bg-[#5D4037] rounded-full"></div>
                <h2 class="text-xl font-bold text-[#3E2723]">Bukti Pembayaran <span class="text-sm font-normal text-gray-500">(Opsional)</span></h2>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <label class="block mb-2 text-sm font-medium text-gray-700">Upload struk/bukti transfer jika sudah membayar:</label>
                <input type="file" name="payment_proof" accept="image/*"
                    class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-bold
                    file:bg-orange-50 file:text-[#D84315]
                    hover:file:bg-orange-100
                    cursor-pointer border border-gray-300 rounded-lg p-2
                "/>
                <p class="text-xs text-gray-400 mt-2">*Format: JPG, PNG. Maks: 2MB.</p>
            </div>
        </div>

        {{-- Tombol Konfirmasi --}}
        <div class="bg-[#5D4037] text-white p-6 rounded-2xl shadow-lg text-center mt-6">
            <h3 class="font-bold text-lg mb-2">Konfirmasi Pembayaran</h3>
            <p class="text-sm text-orange-100 mb-6">Pastikan metode bayar sudah dipilih.</p>
            
            <button type="submit" class="w-full bg-white text-[#5D4037] hover:bg-orange-50 font-bold py-3 px-6 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-1">
                Simpan & Konfirmasi
            </button>
        </div>
                    </div>
                    

                </div>
            </form>

        </div>
    </div>
@endsection