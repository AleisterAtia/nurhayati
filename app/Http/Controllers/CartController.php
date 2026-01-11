<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session('cart', []);
        
        // [MODIFIKASI] Ambil Stok Terbaru & Hitung Subtotal
        // Kita perlu stok terbaru dari database untuk dikirim ke View (agar input number punya batas max)
        $subtotal = 0;
        foreach ($cartItems as $id => &$item) { // Pakai & (reference) agar array $cartItems bisa diubah
            $product = Product::find($id);
            
            // Jika produk ditemukan, update info stok di array session sementara (untuk tampilan saja)
            if ($product) {
                $item['stock'] = $product->stock;
                
                // Opsional: Jika keranjang melebihi stok real-time, turunkan otomatis
                if($item['quantity'] > $product->stock) {
                    $item['quantity'] = $product->stock;
                }
            } else {
                $item['stock'] = 0;
            }

            $subtotal += $item['price'] * $item['quantity'];
        }
        unset($item); // Lepaskan reference

        // Simpan kembali cart yang sudah divalidasi stoknya (opsional, biar sinkron)
        session()->put('cart', $cartItems);

        // Hitung Ongkir
        $shippingOption = session('shipping_option', 'regular');
        $shippingCost = $this->getShippingCost($shippingOption);
        $total = $subtotal + $shippingCost;

        return view('cart.index', compact('cartItems', 'subtotal', 'shippingCost', 'total', 'shippingOption'));
    }

    private function getShippingCost($option)
    {
        switch ($option) {
            case 'express': return 20000;
            case 'sameday': return 35000;
            case 'regular': default: return 10000;
        }
    }

    public function updateShipping(Request $request)
    {
        $request->validate(['shipping_option' => 'required|in:regular,express,sameday']);
        session()->put('shipping_option', $request->shipping_option);
        return redirect()->route('cart.index');
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        // [BARU] Cek Stok Tersedia
        $currentQtyInCart = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;
        
        if (($currentQtyInCart + $quantity) > $product->stock) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $product->stock);
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);

        $cart = session()->get('cart');
        $product = Product::find($id); // [BARU] Ambil data produk untuk cek stok

        if (isset($cart[$id]) && $product) {
            // [BARU] Validasi Stok sebelum update
            if ($request->quantity > $product->stock) {
                return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia (' . $product->stock . ')');
            }

            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function remove($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}