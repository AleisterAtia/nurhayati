<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada

class ProductController extends Controller
{
    // ==========================================
    // DASHBOARD & ADMIN VIEWS
    // ==========================================

    public function user()
    {
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $revenue = Order::where('status', 'completed')->sum('total_amount');
        $latestUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalOrders', 'revenue', 'latestUsers'));
    }

    public function index()
    {
        $products = Product::all();
        return view('admin.product.kelolaproduct', compact('products'));
    }

    public function create()
    {
        return view('admin.product.tambahproduct');
    }

    // ==========================================
    // STORE (SIMPAN PRODUK KE STORAGE)
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $data = $request->except('_token');

        if ($request->hasFile('image')) {
            // Buat nama file unik
            $filename = time() . '.' . $request->image->extension();
            
            // 1. Simpan fisik file ke: storage/app/public/products
            // Folder 'products' akan otomatis dibuat jika belum ada
            $request->file('image')->storeAs('products', $filename, 'public');
            
            // 2. Simpan path string ke Database: storage/products/namafile.jpg
            $data['image'] = 'storage/products/' . $filename;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(Product $product)
    {
        return view('admin.product.showproduct', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.product.editproduct', compact('product'));
    }

    // ==========================================
    // UPDATE (EDIT PRODUK & GANTI GAMBAR)
    // ==========================================
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $data = $request->except('_token');

        if ($request->hasFile('image')) {
            // 1. Upload Gambar Baru
            $filename = time() . '.' . $request->image->extension();
            $request->file('image')->storeAs('products', $filename, 'public');
            $data['image'] = 'storage/products/' . $filename;

            // 2. Hapus Gambar Lama (Cek apakah pakai Storage atau Cara Lama)
            if ($product->image) {
                // Hapus prefix 'storage/' untuk mendapatkan path relatif storage
                $pathInStorage = str_replace('storage/', '', $product->image);

                // Cek di Storage (Cara Baru)
                if (Storage::disk('public')->exists($pathInStorage)) {
                    Storage::disk('public')->delete($pathInStorage);
                }
                // Cek di Public Uploads (Cara Lama - Legacy Support)
                elseif (file_exists(public_path($product->image))) {
                    unlink(public_path($product->image));
                }
            }
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
    }

    // ==========================================
    // DESTROY (HAPUS PRODUK & GAMBAR)
    // ==========================================
    public function destroy(Product $product)
    {
        // Hapus gambar sebelum menghapus data di DB
        if ($product->image) {
            $pathInStorage = str_replace('storage/', '', $product->image);
            
            // Hapus dari Storage
            if (Storage::disk('public')->exists($pathInStorage)) {
                Storage::disk('public')->delete($pathInStorage);
            } 
            // Hapus dari Public (Legacy)
            elseif (file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }

    // ==========================================
    // PUBLIC ROUTES (KATALOG & HOME)
    // ==========================================

    public function home()
    {
        $products = Product::orderBy('rating', 'desc')->take(4)->get();
        return view('welcome', compact('products'));
    }

    public function showPublic(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function catalog(Request $request)
    {
        $query = Product::query();

        if ($request->filled('urutkan')) {
            $sort = explode('-', $request->urutkan);
            if (count($sort) == 2) {
                $column = $sort[0];
                $direction = $sort[1];
                if (in_array($column, ['name', 'price'])) {
                    $query->orderBy($column, $direction);
                }
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        return view('products.catalog', compact('products'));
    }
}