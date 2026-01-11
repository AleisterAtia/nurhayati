<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductReview;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id'   => 'required|exists:orders,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:500',
        ]);

        // 1. Validasi: Pastikan order milik user & statusnya selesai
        $order = Order::where('id', $request->order_id)
                      ->where('user_id', auth()->id())
                      ->where('status', 'completed')
                      ->firstOrFail();

        // 2. Cek apakah user sudah pernah review produk ini di order ini?
        $existingReview = ProductReview::where('user_id', auth()->id())
                                       ->where('order_id', $order->id)
                                       ->where('product_id', $request->product_id)
                                       ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah mengulas produk ini sebelumnya.');
        }

        // 3. Simpan Review
        ProductReview::create([
            'user_id'    => auth()->id(),
            'product_id' => $request->product_id,
            'order_id'   => $request->order_id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        // 4. HITUNG RATA-RATA & UPDATE TABEL PRODUCTS
        $product = Product::find($request->product_id);
        // Ambil rata-rata dari tabel reviews
        $avgRating = ProductReview::where('product_id', $product->id)->avg('rating');
        // Update kolom rating di tabel products
        $product->update(['rating' => round($avgRating, 1)]); // misal 4.5

        return back()->with('success', 'Terima kasih atas ulasan');
    }
}
