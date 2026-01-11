<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; // Tambahkan ini untuk akses API RajaOngkir
use App\Models\Address; 

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $addresses = Address::where('user_id', $user->id)->get(); 
        
        $provinces = [];
        try {
            $response = Http::withHeaders([
                'key' => config('rajaongkir.api_key') 
            ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');
            
            if ($response->successful()) {
                // PERBAIKAN: Gunakan ['data'] sesuai struktur API Komerce
                $provinces = $response->json()['data'] ?? [];
            }
        } catch (\Exception $e) {
            $provinces = []; 
        }

        // Convert array ke object agar bisa dipanggil dengan $p->id di view
        $provinces = json_decode(json_encode($provinces));

        return view('profile.index', compact('user', 'addresses', 'provinces'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone; 

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number'   => 'required|numeric',
            'address_detail' => 'required|string',
            'province_id'    => 'required|numeric', 
            'city_id'        => 'required|numeric',
            'district_id'    => 'required|numeric',
            'postal_code'    => 'required|numeric',
        ]);

        Address::create([
            'user_id'        => auth()->id(),
            'recipient_name' => $request->recipient_name,
            'phone_number'   => $request->phone_number,
            'address_detail' => $request->address_detail,
            
            // PERBAIKAN DI SINI:
            // Sebelah KIRI: Nama Kolom di Database (city, province)
            // Sebelah KANAN: Nama Input di Form HTML ($request->city_id)
            'province'       => $request->province_id, 
            'city'           => $request->city_id, 
            'disctrict'       => $request->district_id, 
            
            'postal_code'    => $request->postal_code,
        ]);

        return back()->with('success', 'Alamat baru berhasil ditambahkan!');
    }

    public function deleteAddress($id)
    {
        $address = Address::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $address->delete();
        
        return back()->with('success', 'Alamat berhasil dihapus.');
    }
}