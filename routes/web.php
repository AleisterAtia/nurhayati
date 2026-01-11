<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; // Import Request
use Illuminate\Foundation\Auth\EmailVerificationRequest; // Import Khusus Verifikasi
use App\Models\Product;
use App\Http\Controllers\{
    AuthController, 
    CartController, 
    CheckoutController, 
    LaporanController, 
    NotificationController, 
    OrderController, 
    PaymentController, 
    ProductController, 
    ProfileController, 
    RajaOngkirController, 
    ReviewController, 
    SocialiteController
};

// ==========================================================
// 1. RUTE VERIFIKASI EMAIL (TAMBAHKAN INI)
// ==========================================================

// Tampilkan halaman "Silakan Verifikasi Email"
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

// Proses saat link di email diklik
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    // Redirect ke home setelah sukses verifikasi
    return redirect()->route('home')->with('success', 'Email berhasil diverifikasi!');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Proses kirim ulang email verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('resent', 'Link verifikasi baru telah dikirim!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// ==========================================================
// 2. HALAMAN UTAMA & PUBLIK
// ==========================================================

Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/produk/{product}', [ProductController::class, 'showPublic'])->name('product.show');
Route::get('/katalog', [ProductController::class, 'catalog'])->name('products.catalog');

// ==========================================================
// 3. RUTE CUSTOMER (YANG DILINDUNGI & BUTUH VERIFIKASI)
// ==========================================================

// Tambahkan 'verified' di dalam middleware agar user wajib verifikasi email
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Rute Checkout
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Rute Pembayaran
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');

    // Pesanan Saya
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.myorders');
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

    // Profile & Alamat
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/address', [ProfileController::class, 'addAddress'])->name('profile.address.add');
    Route::delete('/profile/address/{id}', [ProfileController::class, 'deleteAddress'])->name('profile.address.delete');

    // Update Pembayaran & Notifikasi
    Route::patch('/orders/{id}/payment-method', [OrderController::class, 'updatePaymentMethod'])->name('orders.update-payment-method');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAsRead');

    // Dashboard Customer (Pindahkan ke sini agar terlindungi)
    Route::get('/dashboard-customer', function () {
        $products = Product::all();
        return view('welcome', ['products' => $products]);
    })->middleware('role:customer')->name('customer.dashboard');
});

// ==========================================================
// 4. KERANJANG BELANJA (Boleh akses walau belum verifikasi, tapi harus login)
// ==========================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/keranjang/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/hapus/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/keranjang/shipping', [CartController::class, 'updateShipping'])->name('cart.shipping.update');
});

// ==========================================================
// 5. OTENTIKASI (Login/Register/Google)
// ==========================================================
Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================================
// 6. ADMIN ROUTES (Hanya untuk Admin)
// ==========================================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    Route::get('/dashboard-admin', [ProductController::class, 'user'])->name('admin.dashboard');
    
    // Resource Controller
    Route::resource('orders', OrderController::class);
    Route::resource('products', ProductController::class);

    // Laporan & Print
    Route::get('/orders/{id}/print-label', [OrderController::class, 'printLabel'])->name('orders.printLabel');
    Route::get('/laporan/pesanan', [OrderController::class, 'laporanPesanan'])->name('laporan.laporanpesanan');
    Route::get('/laporan/pesanan/export', [OrderController::class, 'exportPdf'])->name('laporan.export.pdf');
});

// ==========================================================
// 7. API RAJAONGKIR (Publik / Auth)
// ==========================================================
Route::get('/rajaongkir', [RajaOngkirController::class, 'index'])->name('rajaongkir.index');
Route::get('/cities/{provinceId}', [RajaOngkirController::class, 'getCities']);
Route::get('/districts/{cityId}', [RajaOngkirController::class, 'getDistricts']);
Route::post('/check-ongkir', [RajaOngkirController::class, 'checkOngkir']);