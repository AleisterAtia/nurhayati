<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pesanan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2 style="text-align:center">Laporan Pesanan</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Customer</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
        @foreach($orders as $order)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->product->name }}</td>
            <td>{{ $order->quantity }}</td>
            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>{{ $order->created_at->format('d-m-Y') }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
