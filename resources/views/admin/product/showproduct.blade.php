@extends('layouts.navbaradmin')

@section('title', 'Detail Produk')
@section('page-title', 'Detail Produk')

@section('content')
    <div class="bg-white p-6 rounded-2xl shadow space-y-4">
        <h2 class="text-2xl font-bold">{{ $product->name }}</h2>
        <p>{{ $product->description }}</p>
        <p class="text-lg font-semibold">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        <p class="text-lg font-semibold">Stok: {{ $product->stock }}</p>

        <a href="{{ route('products.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg">Kembali</a>
    </div>
@endsection
