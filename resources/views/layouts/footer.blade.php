<footer class="bg-[#3E2723] text-[#FFFBF2] pt-16 pb-8 border-t-4 border-[#D84315]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Grid Container: 1 Kolom di Mobile, 3 Kolom di Laptop --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">

            {{-- KOLOM 1: Brand & Alamat --}}
            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    {{-- Logo: Diberi background putih tipis agar menonjol di latar gelap --}}
                    <div class="bg-white p-2 rounded-full h-16 w-16 flex items-center justify-center shadow-lg">
                        <img src="{{ asset('gambar/logo.png') }}" alt="Logo Keripik Nurhayati"
                            class="h-12 w-auto object-contain">
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold tracking-wide text-white">Keripik Nurhayati</h2>
                        <span class="text-xs text-orange-200 uppercase tracking-widest">Cita Rasa Nusantara</span>
                    </div>
                </div>
                <p class="text-gray-300 leading-relaxed max-w-xs">
                    <i class="fas fa-map-marker-alt text-[#D84315] mr-2"></i>
                    Indarung, Kecamatan Lubuk Kilangan,<br>
                    <span class="ml-6">Kota Padang, Sumatera Barat</span>
                </p>
            </div>

            {{-- KOLOM 2: Social Media --}}
            <div>
                <h3 class="text-xl font-bold mb-6 text-orange-200 relative inline-block">
                    Our Social Media
                    <span class="absolute bottom-0 left-0 w-1/2 h-1 bg-[#D84315] rounded-full"></span>
                </h3>
                <ul class="space-y-4">
                    <li>
                        <a href="#"
                            class="group flex items-center gap-3 text-gray-300 hover:text-white transition-all duration-300 hover:translate-x-2">
                            <span
                                class="h-10 w-10 rounded-full bg-[#5D4037] group-hover:bg-[#D84315] flex items-center justify-center transition-colors">
                                <i class="fab fa-instagram text-lg"></i>
                            </span>
                            <span class="font-medium">@keripiknurhayati</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="group flex items-center gap-3 text-gray-300 hover:text-white transition-all duration-300 hover:translate-x-2">
                            <span
                                class="h-10 w-10 rounded-full bg-[#5D4037] group-hover:bg-[#D84315] flex items-center justify-center transition-colors">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </span>
                            <span class="font-medium">Keripik Nurhayati Official</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="group flex items-center gap-3 text-gray-300 hover:text-white transition-all duration-300 hover:translate-x-2">
                            <span
                                class="h-10 w-10 rounded-full bg-[#5D4037] group-hover:bg-[#D84315] flex items-center justify-center transition-colors">
                                <i class="fab fa-tiktok text-lg"></i>
                            </span>
                            <span class="font-medium">@keripiknurhayati</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- KOLOM 3: Contact Us --}}
            <div>
                <h3 class="text-xl font-bold mb-6 text-orange-200 relative inline-block">
                    Contact Us
                    <span class="absolute bottom-0 left-0 w-1/2 h-1 bg-[#D84315] rounded-full"></span>
                </h3>
                <div class="bg-[#5D4037] bg-opacity-50 p-6 rounded-2xl border border-[#6D4C41]">
                    <p class="text-sm text-gray-300 mb-2">Hubungi kami via WhatsApp:</p>
                    <a href="https://wa.me/62812345678901" target="_blank"
                        class="flex items-center gap-3 text-2xl font-bold text-white hover:text-[#FFAB91] transition-colors">
                        <i class="fab fa-whatsapp text-green-400"></i>
                        <span>+62 812-3456-789</span>
                    </a>
                    <p class="text-xs text-gray-400 mt-4">
                        Senin - Sabtu: 08.00 - 17.00 WIB
                    </p>
                </div>
            </div>

        </div>

        {{-- COPYRIGHT BAR --}}
        <div class="border-t border-[#5D4037] pt-8 text-center">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} <strong class="text-white">Keripik Nurhayati</strong>. All Rights Reserved.
            </p>
            <p class="text-xs text-gray-500 mt-2">
                Dibuat dengan <i class="fas fa-heart text-red-500 mx-1"></i> di Padang.
            </p>
        </div>

    </div>
</footer>
