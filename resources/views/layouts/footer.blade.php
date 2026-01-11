<footer class="bg-[#3E2723] text-[#FFFBF2] pt-16 pb-8 border-t-4 border-[#D84315]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Grid Container: 1 Kolom di Mobile, 3 Kolom di Laptop --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">

            {{-- KOLOM 1: Brand & Alamat --}}
            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    {{-- Logo --}}
                    <div class="bg-white p-2 rounded-full h-16 w-16 flex items-center justify-center shadow-lg">
                        <img src="{{ asset('gambar/logo.png') }}" alt="Logo Keripik Nurhayati"
                            class="h-12 w-auto object-contain">
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold tracking-wide text-white">Keripik Nurhayati</h2>
                        <span class="text-xs text-orange-200 uppercase tracking-widest">Cita Rasa Nusantara</span>
                    </div>
                </div>

                {{-- ALAMAT (DIBUAT BISA DIKLIK) --}}
                <a href="https://www.google.com/maps/place/KERIPIK+NURHAYATI/@-0.9620388,100.4780473,19z/data=!4m12!1m5!3m4!2zMMKwNTcnNDMuMyJTIDEwMMKwMjgnNDMuMyJF!8m2!3d-0.9620388!4d100.478691!3m5!1s0x2fd4b7909027560b:0xc016f4a6c8255f5c!8m2!3d-0.9620106!4d100.4785971!16s%2Fg%2F11ym0bbbyf?hl=en&entry=ttu&g_ep=EgoyMDI2MDEwNy4wIKXMDSoKLDEwMDc5MjA2N0gBUAM%3D"
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="group block text-gray-300 leading-relaxed max-w-xs hover:text-white transition-colors duration-300">
                    <i class="fas fa-map-marker-alt text-[#D84315] mr-2 group-hover:animate-bounce"></i>
                    TK Islam Anak Sholeh, Jl. Manunggal Bhakti, Batu Gadang, Kec. Lubuk Kilangan, Kota Padang, Sumatera Barat 25236<br>
                    <span class="ml-6"></span>
                </a>
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
                    <a href="https://wa.me/6282389312625" target="_blank"
                        class="flex items-center gap-3 text-2xl font-bold text-white hover:text-[#FFAB91] transition-colors">
                        <i class="fab fa-whatsapp text-green-400"></i>
                        <span>+62 823-8931-2625</span>
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