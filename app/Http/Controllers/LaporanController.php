<?php

// app/Http/Controllers/LaporanController.php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('product');

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $orders = $query->get();

        return view('admin.laporan.laporanpesanan', compact('orders'));
    }

    public function exportPdf(Request $request)
{
    // 1. Ambil Filter Tanggal (Sama seperti di Laporan Pesanan)
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    $query = Order::with('user', 'orderItems.product');

    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    $orders = $query->latest()->get();

    // 2. Load View PDF
    $pdf = Pdf::loadView('admin.laporan.pdf', compact('orders', 'startDate', 'endDate'));

    // 3. Download PDF
    return $pdf->download('laporan-pesanan-' . date('Y-m-d') . '.pdf');
}
}

