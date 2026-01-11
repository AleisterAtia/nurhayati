<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Http};
use App\Models\{Address, Order, OrderItem};

class CheckoutController extends Controller
{
    public function show()
{
    $cartItems = session('cart', []);

    if (empty($cartItems)) {
        return redirect()->route('products.index')->with('error', 'Keranjang Anda kosong.');
    }

    $addresses = Address::where('user_id', auth()->id())->get();
    $subtotal = 0;
    
    // --- PERHITUNGAN TOTAL BERAT ---
    $totalWeight = 0; 

    foreach ($cartItems as $id => $item) {
        $subtotal += $item['price'] * $item['quantity'];
        
        // Ambil data produk asli dari DB untuk mendapatkan berat
        $product = \App\Models\Product::find($id);
        
        // Jika produk ada, pakai beratnya. Jika tidak, default 200 gram.
        $itemWeight = $product ? $product->weight : 200;
        
        // Berat item * Jumlah yang dibeli
        $totalWeight += $itemWeight * $item['quantity'];
    }
    // -------------------------------

    // Ambil Data Provinsi (Kode lama Yang Mulia)
    $provinces = [];
    try {
        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key'),
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        if ($response->successful()) {
            $provinces = $response->json()['data'] ?? [];
        }
    } catch (\Exception $e) {
        // Log error
    }

    // Kirim $totalWeight ke View
    return view('checkout.show', compact('cartItems', 'subtotal', 'provinces', 'totalWeight', 'addresses'));
}

public function process(Request $request)
{
    // 1. Validasi Input (TAMBAHKAN VALIDASI DISINI)
    $request->validate([
        'recipient_name'   => 'required|string|max:255',
        'phone_number'     => 'required|string|max:20',
        'address_detail'   => 'required|string|max:1000',
        'shipping_service' => 'required|string',
        'shipping_cost'    => 'required|numeric|min:1',
        
        // --- TAMBAHAN WAJIB ---
        // Validasi ini mencegah error "cannot be null"
        'province_id'      => 'required', 
        'city_id'          => 'required',
        'district_id'      => 'required',
        'postal_code'      => 'required|numeric', 
    ]);

    $cartItems = session('cart', []);
    if (empty($cartItems)) {
        return redirect()->route('products.index')->with('error', 'Keranjang Anda kosong.');
    }

    $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));
    $totalAmount = $subtotal + $request->shipping_cost;

    // Format Alamat untuk kolom shipping_address di tabel Orders
    $fullAddress = "[Kurir: " . $request->shipping_service . "] " .
                   $request->address_detail . ", " .
                   "Kode Pos: " . $request->postal_code . ", " . // Tambahkan Kode Pos di sini juga agar lengkap
                   "Penerima: " . $request->recipient_name .
                   " (" . $request->phone_number . ")";

 try {
        DB::beginTransaction();

        // --- LOGIKA BARU: CEK ALAMAT ---
        
        // Cek apakah user memilih alamat lama (address_id ada isinya)
        if (empty($request->address_id)) {
            // JIKA KOSONG: Berarti user input manual -> Buat Alamat Baru
            Address::create([
                'user_id'        => auth()->id(),
                'recipient_name' => $request->recipient_name,
                'phone_number'   => $request->phone_number,
                'address_detail' => $request->address_detail,
                'province'       => $request->province_id, 
                'city'           => $request->city_id,
                'disctrict'       => $request->district_id,
                'postal_code'    => $request->postal_code, 
            ]);
        } 
        // JIKA TIDAK KOSONG: Berarti user pilih dari list -> LEWATI pembuatan alamat baru
        

        // 3. Buat Pesanan (Order)
        // (Kode di bawah ini tetap sama, karena Order menyimpan alamat sebagai Text Snapshot)
        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_number'     => 'INV-' . strtoupper(Str::random(10)),
            'total_amount'     => $totalAmount,
            'shipping_cost'    => $request->shipping_cost,
            'status'           => 'pending',
            'shipping_address' => $fullAddress, // Alamat lengkap tetap tersimpan di sini sebagai text
            'payment_method'   => null,
        ]);

        // 4. Simpan Item Pesanan
        foreach ($cartItems as $id => $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $id,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);
        }

        DB::commit();

        session()->forget('cart');

        return redirect()->route('payment.show', $order);

    } catch (\Exception $e) {
        DB::rollBack();
        // Log::error("Checkout Error: " . $e->getMessage()); // Uncomment jika perlu logging

        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
    }
}
}
