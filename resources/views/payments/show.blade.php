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

                        {{-- FORM UPLOAD BUKTI (Dipindah ke kiri bawah agar rapi) --}}
                        <div class="mt-8 pt-6 border-t border-dashed border-gray-300">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="h-8 w-1 bg-[#5D4037] rounded-full"></div>
                                <h2 class="text-xl font-bold text-[#3E2723]">Bukti Pembayaran <span class="text-sm font-normal text-gray-500">(Wajib)</span></h2>
                            </div>
                            
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                                <label class="block mb-2 text-sm font-medium text-gray-700">Upload struk transfer / screenshot QRIS:</label>
                                <input type="file" name="payment_proof" accept="image/*"
                                    class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2.5 file:px-4
                                    file:rounded-xl file:border-0
                                    file:text-sm file:font-bold
                                    file:bg-[#5D4037] file:text-white
                                    hover:file:bg-[#3E2723]
                                    cursor-pointer border border-gray-300 rounded-xl p-2 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#D84315]
                                " required/>
                                <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                    <i class="fas fa-info-circle"></i> Format: JPG, PNG. Maks: 2MB.
                                </p>
                            </div>
                        </div>

                    </div>

                    {{-- KOLOM KANAN: QRIS (MODIFIKASI GAMBAR DISINI) --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="h-8 w-1 bg-[#5D4037] rounded-full"></div>
                            <h2 class="text-xl font-bold text-[#3E2723]">Scan QRIS</h2>
                        </div>

                        <label class="block cursor-pointer">
                            <input type="radio" name="payment_method" value="QRIS" class="peer sr-only">
                            <div class="bg-white p-0 rounded-3xl shadow-lg border-2 border-transparent peer-checked:border-[#D84315] text-center relative overflow-hidden peer-checked:bg-orange-50 transition-all">
                                <div class="absolute top-4 right-4 text-[#D84315] opacity-0 peer-checked:opacity-100 transition-opacity z-10">
                                    <i class="fas fa-check-circle text-3xl bg-white rounded-full"></i>
                                </div>
                                
                                {{-- GAMBAR QRIS YANG BARU --}}
                                <div class="relative">
                                    <img src="{{ asset('gambar/qris.jpeg') }}" 
                                         alt="QRIS Code Keripik Nurhayati" 
                                         class="w-full h-auto object-cover rounded-3xl">
                                </div>
                            </div>
                        </label>

                        {{-- Tombol Konfirmasi (Pindah ke Kanan Bawah) --}}
                        <div class="bg-[#5D4037] text-white p-6 rounded-2xl shadow-lg text-center mt-6">
                            <h3 class="font-bold text-lg mb-2">Konfirmasi Pembayaran</h3>
                            <p class="text-sm text-orange-100 mb-6">Pastikan bukti pembayaran sudah diupload.</p>
                            
                            <button type="submit" class="w-full bg-white text-[#5D4037] hover:bg-orange-50 font-bold py-3.5 px-6 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                <span>Kirim Bukti Pembayaran</span>
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

    {{-- Script Copy to Clipboard --}}
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Bisa tambahkan Toast Notification disini jika mau
                alert('Nomor rekening berhasil disalin!');
            }, function(err) {
                console.error('Gagal menyalin: ', err);
            });
        }
    </script>
@endsection