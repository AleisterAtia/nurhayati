{{-- @extends('layouts.navbar') --}}

@section('title', 'Beranda')

@section('content')

    {{-- Hero Section --}}
    <section class="relative overflow-hidden">
        {{-- Tambahkan class object-center di sini --}}
        <img src="{{ asset('gambar/heroooo.png') }}" class="w-full h-[500px] object-cover object-center brightness-75"
            alt="Hero Background">

        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold animate__animated animate__fadeInDown">
                Keripik<span class="text-yellow-300">Nurhayati</span>
            </h1>
            <p class="mt-4 text-lg md:text-xl animate__animated animate__fadeInUp">
                Nikmati keripik lezat, manis, dan penuh cinta setiap hari ✨
            </p>
            <a href="#produk"
                class="mt-6 inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-full shadow-lg transition">
                Pesan Sekarang
            </a>
        </div>
    </section>

    {{-- Produk Unggulan --}}
    <section id="produk" class="py-16 bg-gray-50">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold">Produk Unggulan</h2>
            <p class="text-gray-600">Keripik pilihan terbaik dari Nurhayati</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto px-6">

            {{-- Loop data dari database --}}
            @foreach ($products as $product)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:scale-105 transition">

                    {{-- Tampilkan GAMBAR dari database --}}
                    <img src="{{ asset($product->image) }}" class="w-full h-56 object-cover" alt="{{ $product->name }}">

                    <div class="p-5 text-center">

                        {{-- Tampilkan NAMA dari database --}}
                        <h3 class="font-semibold text-lg">{{ $product->name }}</h3>

                        {{-- Tampilkan DESKRIPSI dari database --}}
                        <p class="text-gray-600 text-sm mt-1 mb-3">{{ $product->description }}</p>

                        {{-- Tampilkan HARGA dari database --}}
                        <p class="text-gray-800 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                        {{-- MODIFIKASI DI SINI: Ubah button menjadi form --}}
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                            @csrf {{-- Token keamanan Laravel, wajib ada --}}
                            <button type="submit"
                                class="bg-yellow-400 hover:bg-yellow-500 px-4 py-2 rounded-full font-medium">
                                Beli Sekarang
                            </button>
                        </form>

                    </div>
                </div>
            @endforeach

        </div>
    </section>

    {{-- Testimoni --}}
    <section class="py-16 bg-white">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold">Apa Kata Mereka?</h2>
            <p class="text-gray-600">Testimoni pelanggan setia Daracake</p>
        </div>
        <div class="flex justify-center space-x-6 max-w-4xl mx-auto">
            <div class="bg-gray-100 p-6 rounded-xl shadow-md w-1/3">
                <p>"Rasanya enak banget, apalagi chocolate keripik-nya 🤤"</p>
                <h4 class="mt-4 font-semibold">– Sinta</h4>
            </div>
            <div class="bg-gray-100 p-6 rounded-xl shadow-md w-1/3">
                <p>"Pengiriman cepat, packaging aman. Recommended!"</p>
                <h4 class="mt-4 font-semibold">– Andi</h4>
            </div>
            <div class="bg-gray-100 p-6 rounded-xl shadow-md w-1/3">
                <p>"Keripiknya lembut, manisnya pas. Anak-anak suka 👍"</p>
                <h4 class="mt-4 font-semibold">– Rina</h4>
            </div>
        </div>
    </section>

    {{-- Tentang Kami --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-5xl mx-auto text-center px-6">
            <h2 class="text-3xl font-bold">Tentang Keripik Nurhayati</h2>
            <p class="mt-4 text-gray-600 leading-relaxed">
                Keripik berdiri sejak 2020, menghadirkan berbagai jenis keripik premium yang dibuat dengan bahan berkualitas
                dan penuh cinta. Misi kami adalah membuat setiap momen Anda lebih manis dengan keripik terbaik. 🎂
            </p>
        </div>
    </section>


@endsection
