@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Main Wrapper --}}
    <div class="bg-[#FFFBF2] min-h-screen py-10 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-10">
                <h1 class="text-3xl font-extrabold text-[#3E2723]">Profil Saya</h1>
                <p class="text-gray-500 mt-2">Kelola informasi profil Anda dan buku alamat pengiriman.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: Form Biodata --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-6 sticky top-24">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                            <div class="bg-orange-100 p-2 rounded-lg text-[#D84315]">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <h3 class="text-lg font-bold text-[#3E2723]">Biodata Diri</h3>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Avatar --}}
                            <div class="flex justify-center mb-6">
                                <div class="h-24 w-24 rounded-full bg-[#3E2723] text-white flex items-center justify-center text-3xl font-bold border-4 border-orange-100">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ auth()->user()->name }}"
                                        class="w-full rounded-xl border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] text-sm py-2.5">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
                                    <input type="email" value="{{ auth()->user()->email }}" disabled
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-500 text-sm py-2.5 cursor-not-allowed">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nomor Telepon</label>
                                    <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" placeholder="0812..."
                                        class="w-full rounded-xl border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] text-sm py-2.5">
                                </div>

                                <hr class="border-dashed border-gray-200 my-4">

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ganti Password (Opsional)</label>
                                    <input type="password" name="password" placeholder="Password Baru"
                                        class="w-full rounded-xl border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] text-sm py-2.5 mb-2">
                                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                                        class="w-full rounded-xl border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] text-sm py-2.5">
                                </div>
                            </div>

                            <button type="submit" class="w-full mt-6 bg-[#3E2723] hover:bg-brown-700 text-white font-bold py-3 rounded-xl shadow transition-all duration-300">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>

                {{-- KOLOM KANAN: Daftar Alamat --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Section Header --}}
                    <div class="flex justify-between items-end">
                        <div>
                            <h2 class="text-2xl font-bold text-[#3E2723]">Buku Alamat</h2>
                            <p class="text-sm text-gray-500">Daftar alamat pengiriman yang tersimpan.</p>
                        </div>
                        <button onclick="toggleForm()" 
                            class="bg-orange-100 hover:bg-orange-200 text-[#D84315] px-4 py-2 rounded-lg font-bold text-sm transition-colors flex items-center gap-2">
                            <i class="fas fa-plus"></i> Tambah Alamat
                        </button>
                    </div>

                    {{-- Form Tambah Alamat (Hidden by default) --}}
                    <div id="form-tambah-alamat" class="hidden bg-white rounded-2xl p-6 border-2 border-[#D84315] border-dashed animate-fade-in-down">
                        <h3 class="font-bold text-[#3E2723] mb-4">Tambah Alamat Baru</h3>
                        
                        <form action="{{ route('profile.address.add') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <input type="text" name="recipient_name" placeholder="Nama Penerima" required class="rounded-xl border-gray-300 text-sm w-full focus:ring-[#D84315] focus:border-[#D84315]">
                                <input type="text" name="phone_number" placeholder="No. Telepon" required class="rounded-xl border-gray-300 text-sm w-full focus:ring-[#D84315] focus:border-[#D84315]">
                            </div>
                            <div class="mb-4">
                                <textarea name="address_detail" placeholder="Detail Alamat (Jalan, No Rumah, RT/RW)" rows="2" required class="rounded-xl border-gray-300 text-sm w-full focus:ring-[#D84315] focus:border-[#D84315]"></textarea>
                            </div>
                            
                            {{-- Dropdown Wilayah --}}
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                {{-- Provinsi --}}
                                <select name="province_id" id="province_id" class="rounded-xl border-gray-300 text-sm w-full">
    <option value="">Provinsi</option>
    @foreach($provinces as $p)
        {{-- 
           PERHATIKAN: API Komerce biasanya menggunakan 'id' dan 'name'.
           Jika masih tidak muncul, coba kembalikan ke 'province_id' dan 'province'.
        --}}
        <option value="{{ $p->id }}">{{ $p->name }}</option>
    @endforeach
</select>
                                
                                {{-- Kota --}}
                                <select name="city_id" id="city_id" disabled required class="rounded-xl border-gray-300 bg-gray-50 text-sm w-full focus:ring-[#D84315] focus:border-[#D84315]">
                                    <option value="">Kota</option>
                                </select>
                                
                                {{-- Kecamatan --}}
                                <select name="district_id" id="district_id" disabled required class="rounded-xl border-gray-300 bg-gray-50 text-sm w-full focus:ring-[#D84315] focus:border-[#D84315]">
                                    <option value="">Kecamatan</option>
                                </select>
                                
                                {{-- Kode Pos --}}
                                <input type="number" name="postal_code" placeholder="Kode Pos" required class="rounded-xl border-gray-300 text-sm w-full focus:ring-[#D84315] focus:border-[#D84315]">
                            </div>

                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="toggleForm()" class="text-gray-500 font-bold text-sm px-4 py-2 hover:bg-gray-100 rounded-lg">Batal</button>
                                <button type="submit" class="bg-[#D84315] text-white font-bold text-sm px-6 py-2 rounded-lg hover:shadow-lg hover:bg-[#bf360c] transition-all">Simpan Alamat</button>
                            </div>
                        </form>
                    </div>

                    {{-- List Alamat --}}
                    @forelse($addresses as $address)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:border-orange-200 transition-colors group relative">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-bold text-[#3E2723] text-lg">{{ $address->recipient_name }}</span>
                                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded-full border border-gray-200">Rumah</span>
                                </div>
                                <p class="text-[#D84315] font-semibold text-sm mb-2">{{ $address->phone_number }}</p>
                                <p class="text-gray-600 text-sm leading-relaxed max-w-xl">
                                    {{ $address->address_detail }}<br>
                                    
                                    {{-- 
                                        PENTING: Karena tidak ada tabel provinces/cities lokal,
                                        kita tidak bisa memanggil $address->province->name.
                                        Solusi: Tampilkan ID Wilayah atau hanya Kode Pos & Detail saja.
                                        (Idealnya: simpan nama kota/provinsi sebagai string di database saat create)
                                    --}}
                                    
                                    <span class="text-gray-400 text-xs mt-1 block">
                                        (Wilayah ID: {{ $address->city_id }}, {{ $address->province_id }})
                                    </span>
                                    Kode Pos: {{ $address->postal_code }}
                                </p>
                            </div>
                            
                            <div class="flex flex-col gap-2">
                                <form action="{{ route('profile.address.delete', $address->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus alamat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition-colors" title="Hapus Alamat">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                        <div class="text-gray-300 mb-3 text-4xl"><i class="fas fa-map-marked-alt"></i></div>
                        <p class="text-gray-500">Belum ada alamat tersimpan.</p>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- JQuery Wajib --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    // Fungsi Toggle Form
    function toggleForm() {
        $('#form-tambah-alamat').toggleClass('hidden');
    }

    $(document).ready(function() {
        // --- 1. Dropdown Provinsi -> Kota ---
        $('#province_id').on('change', function() {
            let provinceId = $(this).val();
            
            // Reset Dropdown bawahnya
            $('#city_id').empty().append('<option value="">-- Pilih Kota --</option>').prop('disabled', true).addClass('bg-gray-50');
            $('#district_id').empty().append('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true).addClass('bg-gray-50');

            if (provinceId) {
                $.ajax({
                    url: `/cities/${provinceId}`, // Pastikan route ini ada di web.php
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $('#city_id').prop('disabled', false).removeClass('bg-gray-50');
                        $.each(response, function(key, value) {
                            // Value menggunakan ID dari RajaOngkir
                            $('#city_id').append(`<option value="${value.id}">${value.name}</option>`);
                        });
                    },
                    error: function() {
                        alert('Gagal mengambil data kota. Cek koneksi internet.');
                    }
                });
            }
        });

        // --- 2. Dropdown Kota -> Kecamatan ---
        $('#city_id').on('change', function() {
            let cityId = $(this).val();

            // Reset Dropdown Kecamatan
            $('#district_id').empty().append('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true).addClass('bg-gray-50');

            if (cityId) {
                $.ajax({
                    url: `/districts/${cityId}`, // Pastikan route ini ada di web.php
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $('#district_id').prop('disabled', false).removeClass('bg-gray-50');
                        $.each(response, function(key, value) {
                            // Value menggunakan ID dari RajaOngkir
                            $('#district_id').append(`<option value="${value.id}">${value.name}</option>`);
                        });
                    },
                    error: function() {
                        alert('Gagal mengambil data kecamatan.');
                    }
                });
            }
        });
    });
</script>
@endpush