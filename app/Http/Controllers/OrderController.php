<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
{
    // Mulai query
    $query = Order::with('user'); // Eager load user agar lebih efisien

    // 1. Fitur Pencarian (Berdasarkan Nama User atau No Order)
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('order_number', 'like', "%{$search}%")
              ->orWhereHas('user', function($u) use ($search) {
                  $u->where('name', 'like', "%{$search}%");
              });
        });
    }

    // 2. Fitur Pengurutan (Sorting)
    // Default: Created At Descending (Terbaru di atas)
    $sortField = $request->get('sort', 'created_at');
    $sortDirection = $request->get('direction', 'desc');
    
    // Validasi field sorting agar tidak error jika user ubah URL manual
    $allowedSorts = ['order_number', 'total_amount', 'status', 'created_at'];
    if (in_array($sortField, $allowedSorts)) {
        $query->orderBy($sortField, $sortDirection);
    } else {
        $query->latest();
    }

    // 3. Pagination (Batasi 10 per halaman)
    $orders = $query->paginate(10)->withQueryString(); // withQueryString agar search tidak hilang saat pindah hal

    return view('admin.pesanan.kelolapesanan', compact('orders'));
}

    public function create()
    {
        return view('admin.pesanan.tambahpesanan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required',
            'produk' => 'required',
            'jumlah' => 'required|integer',
            'total_harga' => 'required|numeric',
            'status' => 'required',
        ]);

        Order::create($request->all());
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil ditambahkan');
    }

    public function edit(Order $order)
    {
        return view('admin.pesanan.editpesanan', compact('order'));
    }

public function update(Request $request, Order $order)
    {
        // 1. Validasi disesuaikan dengan input yang ada di form Edit (View)
        $validatedData = $request->validate([
            'status'           => 'required|in:pending,processing,shipped,completed,cancelled',
            'payment_method'   => 'nullable|string',
            'shipping_address' => 'required|string',
            'total_amount'     => 'required|numeric',
            'shipping_cost'    => 'nullable|numeric',
        ]);

        // 2. Update data berdasarkan hasil validasi
        // Kita tidak menggunakan $request->all() agar data yang tidak ada di form tidak tertimpa null
        $order->update([
            'status'           => $request->status,
            'payment_method'   => $request->payment_method,
            'shipping_address' => $request->shipping_address,
            'total_amount'     => $request->total_amount,
            'shipping_cost'    => $request->shipping_cost,
        ]);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil diperbarui');
    }

    public function laporanPesanan(Request $request)
    {
        // Mulai query dari model Order
        // Kita gunakan with('user') agar loading data lebih cepat (Eager Loading)
        $query = Order::with('user');

        // Cek apakah ada input filter tanggal 'from' dan 'to'
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereDate('created_at', '>=', $request->from)
                  ->whereDate('created_at', '<=', $request->to);
        }

        // Ambil datanya, urutkan dari yang terbaru
        $orders = $query->orderBy('created_at', 'desc')->get();

        // Kembalikan ke view laporan (sesuaikan nama folder view Yang Mulia)
        // Jika file view ada di resources/views/laporan/pesanan.blade.php, sesuaikan path-nya
        return view('admin.laporan.laporanpesanan', compact('orders'));
    }

public function updatePaymentMethod(Request $request, $id)
    {
        // 1. Validasi (Tambahkan validasi file)
        $request->validate([
            'payment_method' => 'required|string',
            'payment_proof'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi file gambar
        ]);

        $order = Order::where('user_id', auth()->id())->findOrFail($id);
        
        // Simpan Metode Pembayaran
        $order->payment_method = $request->payment_method;

        // 2. Cek apakah user mengupload file?
        if ($request->hasFile('payment_proof')) {
            // Simpan file ke storage
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            // Simpan path ke database
            $order->payment_proof = $path;
            
            // Otomatis ubah status jadi 'Menunggu Verifikasi' karena sudah upload bukti
            // Pastikan ENUM di database mendukung status ini, atau gunakan 'processing' jika tidak ada
            // Sesuai screenshot database Anda, pilihannya: pending, processing, shipped, completed
            // Jadi kita pakai 'pending' dulu atau 'processing' tergantung logika bisnis Anda.
            // Biasanya admin yang mengubah ke 'processing' setelah cek manual.
            
            // Opsional: Anda bisa pakai status 'pending' tapi admin tahu karena kolom payment_proof terisi.
        }

        $order->save();

        return redirect()->route('orders.myorders')
            ->with('success', 'Data pembayaran berhasil disimpan. Terima kasih!');
    }
    /**
     * Fungsi Placeholder untuk Export PDF (Agar tidak error saat tombol diklik)
     */
public function exportPdf(Request $request)
    {
        // Ambil Filter Tanggal dari Request
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Query Data (Sama persis dengan yang di halaman laporan)
        $query = Order::with('user');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Ambil semua data (tanpa pagination)
        $orders = $query->latest()->get();

        // Load View PDF (Pastikan file view ini sudah dibuat di langkah sebelumnya)
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('orders', 'startDate', 'endDate'));

        // Download File PDF
        return $pdf->download('Laporan-Pesanan-' . date('Y-m-d-H-i') . '.pdf');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus');
    }

    public function myOrders()
    {
        // Ambil pesanan hanya milik user yang login, urutkan dari yang terbaru
        $orders = Order::where('user_id', auth()->id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Pastikan folder view-nya sesuai (orders/my_orders.blade.php)
        return view('my_orders', compact('orders'));
    }

    public function printLabel($id)
{
    // Mengambil data order beserta relasi user dan order items (jika ada tabel detail produk)
    // Asumsi relasi items bernama 'orderItems' atau 'products'
    $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);

    return view('admin.pesanan.print_label', compact('order'));
}
}
