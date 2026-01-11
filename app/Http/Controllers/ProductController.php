<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // List produk

       public function user()
    {
        // 1. Menghitung Total User dari Database
        $totalUsers = User::count();

        // 2. Menghitung Total Order (Pastikan Model Order ada)
        // Jika belum ada tabel orders, ganti angka ini dengan 0 atau data dummy sementara
        $totalOrders = Order::count();

        // 3. Menghitung Total Pendapatan (Revenue)
        // Asumsi kolom 'total_price' ada di tabel orders dan status 'paid'
        $revenue = Order::where('status', 'completed')->sum('total_amount');

        // 4. Mengambil 5 User Terbaru
        $latestUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalOrders', 'revenue', 'latestUsers'));
    }

    public function index()
    {
        $products = Product::all();
        return view('admin.product.kelolaproduct', compact('products'));
    }

    // Form tambah
    public function create()
    {
        return view('admin.product.tambahproduct');
    }

    // Simpan produk
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $data = $request->except('_token');

    if ($request->hasFile('image')) {
        $filename = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/products'), $filename);
        $data['image'] = 'uploads/products/' . $filename;
    }

    Product::create($data);

    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
}

    // Detail produk
    public function show(Product $product)
    {
        return view('admin.product.showproduct', compact('product'));
    }

    // Form edit
    public function edit(Product $product)
    {
        return view('admin.product.editproduct', compact('product'));
    }

    // Update produk
    public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $data = $request->except('_token');

    if ($request->hasFile('image')) {
        $filename = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/products'), $filename);
        $data['image'] = 'uploads/products/' . $filename;

        // hapus gambar lama kalau ada
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
    }

    $product->update($data);

    return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
}

    // Hapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }

     public function home()
    {
        // Ambil semua data produk dari database
         $products = Product::orderBy('rating', 'desc')->take(4)->get();

    return view('welcome', compact('products'));

        // Cara lain yang lebih singkat menggunakan compact:
        // return view('welcome', compact('products'));
    }

     public function showPublic(Product $product)
    {
        // Laravel akan otomatis mencari produk berdasarkan {product} di URL
        return view('products.show', compact('product'));
    }

 public function catalog(Request $request)
{
    // Query builder langsung dimulai tanpa mengambil kategori
    $query = Product::query();

    // Handle Sort (Urutkan)
    if ($request->filled('urutkan')) {
        $sort = explode('-', $request->urutkan);
        if (count($sort) == 2) {
            $column = $sort[0];
            $direction = $sort[1];
            // Validasi kolom untuk keamanan
            if (in_array($column, ['name', 'price'])) {
                $query->orderBy($column, $direction);
            }
        }
    } else {
        // Urutan default
        $query->latest();
    }

    // Eksekusi query dengan paginasi
    $products = $query->paginate(12)->withQueryString();

    // Kirim data products saja ke view, tanpa categories
    return view('products.catalog', compact('products'));
}
}
