<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi Pengiriman - #{{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            .no-print {
                display: none;
            }
        }

        /* Style agar tampilan mirip label pengiriman */
        .shipping-label {
            width: 100%;
            max-width: 800px;
            /* Lebar maksimal label */
            margin: 20px auto;
            border: 2px solid #000;
            padding: 20px;
            font-family: sans-serif;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="max-w-3xl mx-auto mt-4 mb-4 no-print">
        <button onclick="window.history.back()" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">
            &larr; Kembali
        </button>
    </div>

    <div class="shipping-label bg-white">
        <div class="flex justify-between items-center border-b-2 border-black pb-4 mb-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('gambar/nurhayati.png') }}" alt="Logo" class="h-12 w-12 object-contain">
                <div>
                    <h1 class="font-bold text-xl uppercase">Keripik Nurhayati</h1>
                    <p class="text-xs text-gray-600">Oleh-oleh Khas & Cemilan Gurih</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-bold uppercase tracking-widest">RESI</h2>
                <p class="text-sm font-bold mt-1 border border-black px-2 py-1 inline-block">
                    NON-COD
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8 mb-6">
            <div>
                <h3 class="text-xs font-bold text-gray-500 uppercase mb-1">PENGIRIM (FROM):</h3>
                <p class="font-bold text-lg">Keripik Nurhayati</p>
                <p class="text-sm text-gray-700">Jl. Contoh No. 123, Kota Padang</p>
                <p class="text-sm text-gray-700">Telp: 0812-3456-7890</p>
            </div>

            <div>
                <h3 class="text-xs font-bold text-gray-500 uppercase mb-1">PENERIMA (TO):</h3>
                <p class="font-bold text-xl">{{ $order->user->name ?? $order->nama_customer }}</p>
                <p class="text-sm text-gray-800 leading-relaxed mt-1">
                    {{ $order->shipping_address }}
                </p>
                <p class="text-sm font-bold mt-2">Telp: {{ $order->user->phone ?? '-' }}</p>
            </div>
        </div>

        <div class="border-t-2 border-dashed border-gray-400 pt-4">
            <h3 class="text-xs font-bold text-gray-500 uppercase mb-2">DETAIL ISI PAKET (ORDER
                #{{ $order->order_number }})</h3>

            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-300">
                        <th class="py-2 w-1/2">Produk</th>
                        <th class="py-2 text-center">Jml</th>
                        <th class="py-2 text-right">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Logika Tampilan Produk --}}
                    @if (isset($order->produk))
                        {{-- Jika data produk disimpan dalam satu kolom string --}}
                        <tr>
                            <td class="py-2 align-top">{{ $order->produk }}</td>
                            <td class="py-2 text-center align-top">{{ $order->jumlah ?? 1 }}</td>
                            <td class="py-2 text-right align-top font-medium">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @else
                        {{-- Fallback jika menggunakan data dummy atau struktur lain --}}
                        <tr>
                            <td class="py-2 align-top">-</td>
                            <td class="py-2 text-center align-top">-</td>
                            <td class="py-2 text-right align-top">-</td>
                        </tr>
                    @endif
                </tbody>

                {{-- Footer Tabel untuk Total --}}
                <tfoot>
                    {{-- Baris Ongkir (Opsional, jika ingin ditampilkan) --}}
                    @if (isset($order->shipping_cost) && $order->shipping_cost > 0)
                        <tr>
                            <td colspan="2" class="pt-2 text-right text-xs text-gray-500">Ongkos Kirim:</td>
                            <td class="pt-2 text-right text-xs text-gray-500">
                                Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endif

                    {{-- Baris Grand Total --}}
                    <tr class="border-t border-gray-300">
                        <td colspan="2" class="pt-2 text-right font-bold uppercase">Total Harga:</td>
                        <td class="pt-2 text-right font-bold text-lg">
                            {{-- Asumsi total_amount sudah termasuk ongkir. Jika belum, tambahkan logic penjumlahan --}}
                            Rp {{ number_format($order->total_amount + ($order->shipping_cost ?? 0), 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-4 text-xs text-gray-500 italic bg-gray-50 p-2 rounded border border-gray-200">
                <p><span class="font-bold">Catatan:</span>
                    {{ $order->notes ?? 'Barang mudah hancur, mohon jangan dibanting/ditindih.' }}</p>
            </div>
        </div>

        <div class="mt-6 border-t-2 border-black pt-4 flex justify-between items-end">
            <div class="text-xs text-gray-500">
                Dicetak pada: {{ now()->format('d M Y H:i') }}
            </div>
            <div class="text-center">
                {{-- Simulasi Barcode (Visual Saja) --}}
                <div class="h-10 bg-gray-800 w-48 mb-1 mx-auto"
                    style="mask-image: repeating-linear-gradient(90deg, black, black 2px, transparent 2px, transparent 4px);">
                </div>
                <span class="text-sm font-mono tracking-widest font-bold">{{ $order->order_number }}</span>
            </div>
        </div>
    </div>

</body>

</html>
