@extends('layouts.navbaradmin')

@section('title', 'Profil Saya')
@section('page-title', 'Pengaturan Akun')

@section('content')
<div class="animate-fade-in-down pb-12">
    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            {{-- Header Profil --}}
            <div class="bg-[#3E2723] p-8 text-center md:text-left md:flex md:items-center md:justify-between relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
                    <div class="h-24 w-24 rounded-full bg-[#D84315] border-4 border-white shadow-lg flex items-center justify-center text-white text-3xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="text-white text-center md:text-left">
                        <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                        <p class="text-orange-200 text-sm">{{ $user->email }}</p>
                        <span class="inline-block mt-2 px-3 py-1 bg-white/20 rounded-full text-xs font-semibold backdrop-blur-sm border border-white/10">Administrator</span>
                    </div>
                </div>
                
                {{-- Dekorasi Background --}}
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-[#5D4037] rounded-full opacity-50 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-[#D84315] rounded-full opacity-30 blur-2xl"></div>
            </div>

            <div class="p-8">
                <form action="{{ route('profile.admin.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {{-- KOLOM KIRI: INFO DASAR --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-bold text-[#3E2723] border-b border-gray-100 pb-2 mb-4">Informasi Dasar</h3>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                        class="pl-10 w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#D84315] focus:border-transparent outline-none transition-all">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                        class="pl-10 w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#D84315] focus:border-transparent outline-none transition-all">
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: GANTI PASSWORD --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-bold text-[#3E2723] border-b border-gray-100 pb-2 mb-4">Keamanan (Opsional)</h3>
                            
                            <div class="bg-orange-50 p-4 rounded-xl border border-orange-100">
                                <p class="text-xs text-gray-600 mb-4 flex gap-2">
                                    <i class="fas fa-info-circle text-[#D84315] mt-0.5"></i>
                                    Isi bagian ini hanya jika Anda ingin mengubah kata sandi.
                                </p>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1">Password Saat Ini</label>
                                        <input type="password" name="current_password" placeholder="********"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#D84315] focus:ring-1 focus:ring-[#D84315] outline-none text-sm">
                                        @error('current_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1">Password Baru</label>
                                        <input type="password" name="new_password" placeholder="Minimal 8 karakter"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#D84315] focus:ring-1 focus:ring-[#D84315] outline-none text-sm">
                                        @error('new_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1">Konfirmasi Password Baru</label>
                                        <input type="password" name="new_password_confirmation" placeholder="Ulangi password baru"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#D84315] focus:ring-1 focus:ring-[#D84315] outline-none text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- TOMBOL SIMPAN --}}
                    <div class="flex justify-end pt-6 border-t border-gray-100">
                        <button type="submit" 
                            class="bg-[#5D4037] hover:bg-[#3E2723] text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-2">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection