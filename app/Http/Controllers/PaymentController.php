<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
 public function show($unique_code)
    {
        $order = Order::where('id', $unique_code)
                      ->where('user_id', auth()->id())
                      ->firstOrFail();

        // Jika status bukan 'pending', mungkin sudah bayar
       if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // Data untuk QRIS (Contoh: menggunakan format standar QRIS)
        // Ganti dengan generator QRIS payment gateway Anda jika ada.
        // Ini adalah contoh statis, idealnya Anda generate payload QRIS yang valid.
        $qrisString = "00020101021126580014ID.CO.KERIPIK.WWW01189360091500000000000208123456780303UME51440014ID.CO.MERCHANT015204123453033605802ID5917Keripik Nurhayati6005Padang62070703T1T6304E12A"; // Ganti dengan payload QRIS Anda

        return view('payments.show', compact('order', 'qrisString'));
    }

    
}
