@extends('layouts.navbaradmin')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Tambah Pesanan</h1>
    <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="text" name="nama_customer" placeholder="Nama Customer" class="w-full border p-2">
        <input type="text" name="produk" placeholder="Produk" class="w-full border p-2">
        <input type="number" name="jumlah" placeholder="Jumlah" class="w-full border p-2">
        <input type="number" name="total_harga" placeholder="Total Harga" class="w-full border p-2">
        <select name="status" class="w-full border p-2">
            <option value="pending">Pending</option>
            <option value="diproses">Diproses</option>
            <option value="selesai">Selesai</option>
        </select>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
