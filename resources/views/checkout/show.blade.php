@extends('layouts.app')

@section('title', 'Checkout Pengiriman')

@section('content')
    {{-- Meta Token untuk AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Main Wrapper: Background Cream --}}
    <div class="bg-[#FFFBF2] min-h-screen py-8 md:py-12 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Halaman --}}
            <div class="mb-8 animate-fade-in-down">
                <h1 class="text-3xl md:text-4xl font-extrabold text-[#3E2723] mb-2">Checkout Pengiriman</h1>
                <div class="h-1 w-20 bg-[#D84315] rounded-full"></div>
                <p class="text-gray-500 mt-2">Lengkapi data pengiriman untuk menyelesaikan pesanan.</p>
            </div>

            {{-- FITUR PILIH ALAMAT TERSIMPAN --}}
            @if($addresses->count() > 0)
            <div class="mb-8 bg-white rounded-2xl shadow-sm border border-orange-100 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-orange-100 p-2 rounded-lg text-[#D84315]">
                        <i class="fas fa-address-book text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#3E2723]">Pilih Alamat Tersimpan</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                    @foreach($addresses as $addr)
                        {{-- Kirim data alamat lengkap ke fungsi JS --}}
                        <div onclick='fillAddress(@json($addr))' 
                             class="cursor-pointer border border-gray-200 rounded-xl p-4 hover:border-[#D84315] hover:bg-orange-50 transition-all group relative">
                            
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-bold text-[#3E2723]">{{ $addr->recipient_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $addr->phone_number }}</p>
                                    <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ $addr->address_detail }}</p>
                                </div>
                                <div class="h-4 w-4 rounded-full border border-gray-300 group-hover:border-[#D84315] group-hover:bg-[#D84315]"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Tombol Reset --}}
                <button type="button" onclick="resetAddressForm()" class="text-xs text-[#D84315] font-bold mt-4 underline hover:text-[#3E2723]">
                    Gunakan Alamat Baru (Input Manual)
                </button>
            </div>
            @endif
            {{-- END FITUR ALAMAT --}}

            <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
                @csrf
                {{-- Hidden Inputs --}}
                <input type="hidden" id="weight" name="weight" value="{{ $totalWeight }}">
                <input type="hidden" id="shipping_service" name="shipping_service">
                <input type="hidden" id="shipping_cost_input" name="shipping_cost" value="0">
                
                {{-- INPUT PENTING: ID Alamat (Untuk mencegah duplikasi) --}}
                <input type="hidden" id="address_id" name="address_id" value=""> 

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    {{-- KOLOM KIRI: FORM DATA (Lebar 7/12) --}}
                    <div class="lg:col-span-7 space-y-6">

                        {{-- 1. Kartu Alamat --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-6 md:p-8">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                                <div class="bg-orange-100 p-2 rounded-lg text-[#D84315]">
                                    <i class="fas fa-map-marker-alt text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#3E2723]">Alamat Penerima</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                {{-- Nama --}}
                                <div>
                                    <label class="block text-sm font-semibold text-[#5D4037] mb-2">Nama Penerima</label>
                                    <input type="text" name="recipient_name"
                                        value="{{ old('recipient_name', auth()->user()->name) }}" required
                                        class="w-full rounded-xl border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] shadow-sm transition-colors py-2.5">
                                </div>
                                {{-- Telepon --}}
                                <div>
                                    <label class="block text-sm font-semibold text-[#5D4037] mb-2">Nomor Telepon</label>
                                    <input type="tel" name="phone_number" placeholder="08123456789" required
                                        class="w-full rounded-xl border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] shadow-sm transition-colors py-2.5">
                                </div>
                            </div>

                            {{-- Alamat Lengkap --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-[#5D4037] mb-2">Alamat Lengkap</label>
                                <textarea name="address_detail" rows="3" placeholder="Nama jalan, nomor rumah, patokan..." required
                                    class="w-full rounded-xl border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] shadow-sm transition-colors py-2.5"></textarea>
                            </div>
                            
                            {{-- Kode Pos --}}
                            <div>
                                <label class="block text-sm font-semibold text-[#5D4037] mb-2">Kode Pos</label>
                                <input type="number" name="postal_code" placeholder="Contoh: 25163" required
                                    class="w-full rounded-xl border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] shadow-sm transition-colors py-2.5">
                            </div>
                        </div>

                        {{-- 2. Kartu Pengiriman (RajaOngkir) --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-6 md:p-8">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                                <div class="bg-orange-100 p-2 rounded-lg text-[#D84315]">
                                    <i class="fas fa-shipping-fast text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#3E2723]">Metode Pengiriman</h3>
                            </div>

                            {{-- Dropdowns Wilayah --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-[#5D4037] mb-2">Provinsi Tujuan</label>
                                    <select id="province_id" name="province_id"
                                        class="w-full rounded-xl border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] py-2.5">
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-[#5D4037] mb-2">Kota / Kabupaten</label>
                                    <select id="city_id" name="city_id" disabled
                                        class="w-full rounded-xl border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] bg-gray-50 py-2.5">
                                        <option value="">-- Pilih Kota --</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-[#5D4037] mb-2">Kecamatan</label>
                                    <select id="district_id" name="district_id" disabled
                                        class="w-full rounded-xl border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] bg-gray-50 py-2.5">
                                        <option value="">-- Pilih Kecamatan --</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-[#5D4037] mb-2">Kurir</label>
                                    <select id="courier" name="courier"
                                        class="w-full rounded-xl border-gray-300 focus:border-[#D84315] focus:ring-[#D84315] py-2.5">
                                        <option value="">-- Pilih Kurir --</option>
                                        <option value="jne">JNE</option>
                                        <option value="pos">POS Indonesia</option>
                                        <option value="tiki">TIKI</option>
                                        <option value="sicepat">Sicepat</option>
                                        <option value="jnt">J&T</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Tombol Cek Ongkir --}}
                            <button type="button"
                                class="btn-check-ongkir w-full bg-orange-100 hover:bg-orange-200 text-[#D84315] font-bold py-3 rounded-xl transition-colors border border-orange-200 flex items-center justify-center gap-2 mb-6">
                                <i class="fas fa-search"></i> Cek Ongkos Kirim
                            </button>

                            {{-- Loading Indicator --}}
                            <div id="loading-indicator" class="hidden text-center py-4">
                                <div
                                    class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-orange-200 border-t-[#D84315]">
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Sedang menghitung ongkir...</p>
                            </div>

                            {{-- Hasil Ongkir (Radio Buttons) --}}
                            <div id="result-options" class="space-y-3">
                                {{-- Opsi ongkir akan dimuat di sini via AJAX --}}
                            </div>
                        </div>

                    </div>

                    {{-- KOLOM KANAN: RINGKASAN --}}
                    <div class="lg:col-span-5">
                        <div class="bg-white rounded-2xl shadow-lg border border-orange-100 p-6 md:p-8 lg:sticky lg:top-24">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                                <div class="bg-orange-100 p-2 rounded-lg text-[#D84315]">
                                    <i class="fas fa-file-invoice-dollar text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#3E2723]">Ringkasan Pesanan</h3>
                            </div>

                            {{-- List Item --}}
                            <div class="max-h-60 overflow-y-auto custom-scrollbar mb-6 pr-2 space-y-4">
                                @foreach ($cartItems as $item)
                                    <div class="flex items-start gap-4">
                                        <div
                                            class="h-16 w-16 flex-shrink-0 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden">
                                            <img src="{{ asset($item['image'] ?? 'placeholder.jpg') }}"
                                                alt="{{ $item['name'] }}" class="h-full w-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-bold text-[#3E2723] line-clamp-2">{{ $item['name'] }}
                                            </h4>
                                            <div class="flex justify-between items-center mt-1">
                                                <p class="text-xs text-gray-500">{{ $item['quantity'] }} x Rp
                                                    {{ number_format($item['price']) }}</p>
                                                <p class="text-sm font-bold text-[#5D4037]">Rp
                                                    {{ number_format($item['quantity'] * $item['price']) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Perhitungan --}}
                            <div class="space-y-3 border-t border-dashed border-gray-200 pt-4">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span class="font-bold text-[#3E2723]" data-subtotal="{{ $subtotal }}">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Ongkos Kirim</span>
                                    <span id="summary-ongkir" class="font-bold text-[#D84315]">Rp 0</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center border-t border-gray-200 pt-4 mt-4 mb-6">
                                <span class="text-lg font-bold text-[#3E2723]">Total Tagihan</span>
                                <span id="summary-total" class="text-2xl font-bold text-[#D84315]">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- Tombol Bayar --}}
                            <button type="submit" id="btn-submit-checkout" disabled
                                class="w-full bg-gray-400 cursor-not-allowed text-white font-bold py-4 rounded-xl shadow-md transition-all duration-300">
                                Pilih Pengiriman Dulu
                            </button>
                            <p class="text-xs text-center text-gray-400 mt-3">*Pastikan data sudah benar sebelum membayar
                            </p>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        // Variabel global untuk menyimpan target otomatisasi
        let autoSelectCityId = null;
        let autoSelectDistrictId = null;

        // --- FUNGSI 1: Mengisi Form saat Alamat Diklik ---
        function fillAddress(data) {
            // 1. Isi Input Text
           console.log("Data Alamat yang dipilih:", data); // Cek di Console (F12) apakah ID kecamatan ada?

            // 1. Isi Input Text
            $('input[name="recipient_name"]').val(data.recipient_name);
            $('input[name="phone_number"]').val(data.phone_number);
            $('textarea[name="address_detail"]').val(data.address_detail);
            $('input[name="postal_code"]').val(data.postal_code);

            // 2. ISI HIDDEN INPUT ADDRESS ID
            $('#address_id').val(data.id); 

            // 3. Set Variable Auto Select (PERBAIKAN DISINI)
            // Kita cek semua kemungkinan nama kolom dari database
            autoSelectCityId = data.city_id || data.city; 
            
            // Cek 'district_id', atau 'district' (benar), atau 'disctrict' (typo database)
            autoSelectDistrictId = data.district_id || data.district || data.disctrict; 

            // Debugging: Pastikan ID kecamatan tertangkap
            if(!autoSelectDistrictId) {
                console.warn("Peringatan: ID Kecamatan tidak ditemukan di data alamat ini. Cek database kolom 'district' atau 'disctrict'.");
            } else {
                console.log("ID Kecamatan yang akan dipilih otomatis:", autoSelectDistrictId);
            }

            // 4. Pilih Provinsi untuk memicu rantai AJAX
            let provinceVal = data.province_id || data.province;
            $('#province_id').val(provinceVal).trigger('change');
            
            // Beri visual feedback
            alert('Alamat ' + data.recipient_name + ' dipilih. Mohon tunggu dropdown wilayah dimuat otomatis...');
        }

        // --- FUNGSI 2: Reset Form untuk Manual ---
        function resetAddressForm() {
            $('#checkout-form')[0].reset();
            
            // KOSONGKAN HIDDEN ID (Agar controller tahu ini alamat baru)
            $('#address_id').val(''); 

            $('#city_id').empty().append('<option value="">-- Pilih Kota --</option>').prop('disabled', true);
            $('#district_id').empty().append('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
            autoSelectCityId = null;
            autoSelectDistrictId = null;
        }

        $(document).ready(function() {
            // --- Helper Format Rupiah ---
            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(angka);
            }

            // --- 1. Chained Dropdown: Provinsi -> Kota ---
            $('#province_id').on('change', function() {
                let provinceId = $(this).val();
                
                // Reset Dropdown bawahnya saat provinsi berubah
                $('#city_id').empty().append('<option value="">-- Pilih Kota --</option>').prop('disabled', true);
                $('#district_id').empty().append('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);

                if (provinceId) {
                    $.ajax({
                        url: `/cities/${provinceId}`,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            $('#city_id').empty().append('<option value="">-- Pilih Kota --</option>')
                                .prop('disabled', false).removeClass('bg-gray-50');

                            $.each(response, function(key, value) {
                                $('#city_id').append(`<option value="${value.id}">${value.name}</option>`);
                            });

                            // --- LOGIKA AUTO SELECT KOTA ---
                            if (autoSelectCityId) {
                                $('#city_id').val(autoSelectCityId).trigger('change');
                                autoSelectCityId = null; // Reset
                            }
                        }
                    });
                }
            });

            // --- 2. Chained Dropdown: Kota -> Kecamatan ---
            $('#city_id').on('change', function() {
                let cityId = $(this).val();
                
                // Reset Dropdown bawahnya saat kota berubah
                $('#district_id').empty().append('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);

                if (cityId) {
                    $.ajax({
                        url: `/districts/${cityId}`,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            $('#district_id').empty().append('<option value="">-- Pilih Kecamatan --</option>')
                                .prop('disabled', false).removeClass('bg-gray-50');

                            $.each(response, function(key, value) {
                                $('#district_id').append(`<option value="${value.id}">${value.name}</option>`);
                            });

                            // --- LOGIKA AUTO SELECT KECAMATAN ---
                            if (autoSelectDistrictId) {
                                $('#district_id').val(autoSelectDistrictId);
                                autoSelectDistrictId = null; // Reset
                            }
                        }
                    });
                }
            });

            // --- 3. Cek Ongkir ---
            $('.btn-check-ongkir').click(function(e) {
                e.preventDefault();
                let token = $("meta[name='csrf-token']").attr("content");
                let district_id = $('#district_id').val();
                let courier = $('#courier').val();
                let weight = $('#weight').val();

                if (!district_id || !courier) {
                    alert('Mohon pilih Kecamatan dan Kurir terlebih dahulu.');
                    return;
                }

                $('#loading-indicator').removeClass('hidden');
                $('#result-options').empty();
                $(this).prop('disabled', true).addClass('opacity-50 cursor-not-allowed');

                $.ajax({
                    url: "/check-ongkir",
                    type: "POST",
                    data: {
                        _token: token,
                        district_id: district_id,
                        courier: courier,
                        weight: weight
                    },
                    success: function(response) {
                        $('#loading-indicator').addClass('hidden');
                        $('.btn-check-ongkir').prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');

                        if (response && response.length > 0) {
                            let html = '<p class="text-sm font-bold text-[#5D4037] mb-3">Pilih Layanan:</p>';
                            $.each(response, function(index, val) {
                                let cost = val.cost;
                                html += `
                                    <label class="group relative flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-[#D84315] hover:bg-orange-50 transition-all duration-200 shadow-sm">
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center h-5">
                                                <input type="radio" name="shipping_option" value="${cost}" data-service="${val.service} (${val.description})" class="service-radio h-4 w-4 text-[#D84315] border-gray-300 focus:ring-[#D84315]">
                                            </div>
                                            <div>
                                                <span class="block text-sm font-bold text-[#3E2723] uppercase">${val.service}</span>
                                                <span class="block text-xs text-gray-500">${val.description} • Estimasi ${val.etd} hari</span>
                                            </div>
                                        </div>
                                        <div class="text-sm font-bold text-[#D84315]">${formatRupiah(cost)}</div>
                                        <div class="absolute inset-0 rounded-xl border-2 border-transparent group-hover:border-[#D84315] pointer-events-none transition-all"></div>
                                    </label>
                                `;
                            });
                            $('#result-options').html(html);
                        } else {
                            $('#result-options').html('<div class="p-4 bg-red-50 text-red-600 rounded-lg text-sm">Tidak ada layanan tersedia. Coba kurir lain.</div>');
                        }
                    },
                    error: function() {
                        $('#loading-indicator').addClass('hidden');
                        $('.btn-check-ongkir').prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
                        alert('Maaf, gagal mengambil data ongkir.');
                    }
                });
            });

            // --- 4. Hitung Total ---
            $(document).on('change', '.service-radio', function() {
                let shippingCost = parseInt($(this).val());
                let serviceName = $(this).data('service');
                let subtotalText = $('span[data-subtotal]').data('subtotal');
                let subtotal = parseInt(subtotalText);
                let total = subtotal + shippingCost;

                $('#summary-ongkir').text(formatRupiah(shippingCost));
                $('#summary-total').text(formatRupiah(total));
                $('#shipping_cost_input').val(shippingCost);
                $('#shipping_service').val(serviceName);
                
                $('#btn-submit-checkout')
                    .prop('disabled', false)
                    .removeClass('bg-gray-400 cursor-not-allowed')
                    .addClass('bg-[#5D4037] hover:bg-[#3E2723] hover:shadow-lg hover:-translate-y-1')
                    .html(`Bayar Sekarang <i class="fas fa-arrow-right ml-2"></i>`);
            });
        });
    </script>
@endpush