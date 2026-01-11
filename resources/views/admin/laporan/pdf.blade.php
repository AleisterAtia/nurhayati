<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pesanan</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #3E2723; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; color: #333; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .total { font-weight: bold; text-align: right; }
        ul { margin: 0; padding-left: 15px; }
        li { margin-bottom: 2px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Penjualan Keripik Nurhayati</h2>
        <p>Periode: 
            {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : 'Semua Waktu' }} 
            s/d 
            {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : 'Sekarang' }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 15%;">Pelanggan</th>
                <th style="width: 30%;">Detail Produk (Qty)</th>
                <th style="width: 15%;">Total Harga</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($orders as $index => $order)
            @php $grandTotal += $order->total_amount; @endphp
            <tr>
                {{-- 1. Kolom No --}}
                <td style="text-align: center;">{{ $index + 1 }}</td>

                {{-- 2. Kolom Tanggal --}}
                <td>{{ $order->created_at->format('d/m/Y') }}</td>

                {{-- 3. Kolom Pelanggan --}}
                <td>
                    <strong>{{ $order->user->name ?? 'Guest' }}</strong><br>
                    <span style="font-size: 9px; color: #666;">#{{ $order->order_number }}</span>
                </td>

                {{-- 4. Kolom Detail Produk (Looping disini) --}}
                <td>
                    <ul style="list-style-type: square;">
                        @foreach($order->orderItems as $item)
                            <li>
                                {{ $item->product->name ?? 'Produk Dihapus' }}
                                <span style="font-weight: bold; font-size: 10px;">(x{{ $item->quantity }})</span>
                            </li>
                        @endforeach
                    </ul>
                </td>

                {{-- 5. Kolom Total Harga --}}
                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>

                {{-- 6. Kolom Status --}}
                <td>
                    {{ ucfirst($order->status) }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="total">Total Pendapatan</td>
                <td colspan="2" class="total" style="background-color: #eee;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <p>Padang, {{ date('d F Y') }}</p>
        <br><br><br>
        <p>( Admin )</p>
    </div>

</body>
</html>