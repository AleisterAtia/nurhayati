<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Keripik Nusantara')</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css" rel="stylesheet" />

    {{-- Fonts (Optional: Google Fonts Noto Sans / Poppins agar lebih modern) --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Animasi halus untuk dropdown */
        .fade-enter {
            opacity: 0;
            transform: translateY(-10px);
        }

        .fade-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.3s, transform 0.3s;
        }
    </style>
</head>

<body class="bg-[#FFFBF2] text-[#4A3426] flex flex-col min-h-screen">

    {{-- NAVBAR --}}
    <nav class="bg-[#FFFBF2] shadow-md sticky top-0 z-50 border-b border-[#EFEBE9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">

                {{-- 1. Logo & Desktop Menu --}}
                <div class="flex items-center">
                    {{-- Logo --}}
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}">
                            {{-- Sesuaikan tinggi logo dengan h-12 atau h-14 --}}
                            <img class="h-12 w-auto object-contain" src="{{ asset('gambar/logo.png') }}"
                                alt="Logo Nurhayati">
                        </a>
                    </div>

                    {{-- Desktop Menu Links (Hidden di Mobile) --}}
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="{{ route('home') }}"
                            class="{{ request()->routeIs('home') ? 'text-[#D84315] border-b-2 border-[#D84315]' : 'text-[#5D4037] hover:text-[#D84315]' }} px-1 pt-1 text-sm font-semibold transition duration-150 ease-in-out">
                            Home
                        </a>
                        <a href="{{ route('products.catalog') }}"
                            class="text-[#5D4037] hover:text-[#D84315] px-1 pt-1 text-sm font-semibold transition duration-150 ease-in-out">
                            Katalog
                        </a>
                        {{-- <a href="#"
                            class="text-[#5D4037] hover:text-[#D84315] px-1 pt-1 text-sm font-semibold transition duration-150 ease-in-out">
                            About Us
                        </a> --}}
                        <a href="#footer"
                            class="text-[#5D4037] hover:text-[#D84315] px-1 pt-1 text-sm font-semibold transition duration-150 ease-in-out">
                            Contact
                        </a>
                    </div>
                </div>

                {{-- 2. Desktop Right Side (Cart & Auth) --}}
                <div class="hidden md:flex md:items-center md:space-x-6">

                    {{-- Cart Icon (Selalu muncul jika tidak guest, atau sesuai logika bisnis) --}}
                    <a href="{{ route('cart.index') }}" class="relative text-[#5D4037] hover:text-[#D84315] transition">
                        <i class="ri-shopping-cart-2-line text-2xl"></i>
                        @if (is_array(session('cart')) && count(session('cart')) > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    @guest
                        <a href="{{ route('login') }}" class="text-[#5D4037] font-medium hover:text-[#D84315]">Log In</a>
                        <a href="{{ route('register') }}"
                            class="bg-[#5D4037] hover:bg-[#3E2723] text-white px-5 py-2 rounded-full text-sm font-medium transition shadow-md hover:shadow-lg">
                            Sign Up
                        </a>
                    @else
                        {{-- User Dropdown --}}
                        <div class="ml-3 relative" id="desktop-user-menu-container">
                            <div>
                                <button type="button" id="desktop-user-menu-button"
                                    class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5D4037]"
                                    aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <div
                                        class="h-9 w-9 rounded-full bg-[#D7CCC8] flex items-center justify-center text-[#5D4037] font-bold border border-[#A1887F]">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span class="ml-2 text-[#5D4037] font-semibold">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down ml-2 text-xs text-[#8D6E63]"></i>
                                </button>
                            </div>

                            {{-- Dropdown Panel --}}
                            <div id="desktop-user-menu-dropdown"
                                class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 transform transition-all duration-200">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm text-gray-500">Signed in as</p>
                                    <p class="text-sm font-bold text-[#3E2723] truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#D84315]">Profil
                                    Saya</a>
                                <a href="{{ route('orders.myorders') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#D84315]">Pesanan
                                    Saya</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                {{-- 3. Mobile Menu Button (Hamburger) --}}
                <div class="-mr-2 flex items-center md:hidden gap-4">
                    {{-- Cart Icon Mobile --}}
                    <a href="{{ route('cart.index') }}" class="relative text-[#5D4037]">
                        <i class="ri-shopping-cart-2-line text-2xl"></i>
                        @if (is_array(session('cart')) && count(session('cart')) > 0)
                            <span
                                class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <button type="button" id="mobile-menu-button"
                        class="bg-[#FFFBF2] inline-flex items-center justify-center p-2 rounded-md text-[#5D4037] hover:text-[#D84315] hover:bg-orange-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5D4037]">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars text-2xl" id="menu-icon-open"></i>
                        <i class="fas fa-times text-2xl hidden" id="menu-icon-close"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- 4. Mobile Menu Panel (Slide Down) --}}
        <div class="hidden md:hidden bg-white border-t border-gray-100" id="mobile-menu">
            <div class="pt-2 pb-3 space-y-1 px-4">
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'bg-orange-50 text-[#D84315]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#D84315]' }} block px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="{{ route('products.catalog') }}"
                    class="text-gray-600 hover:bg-gray-50 hover:text-[#D84315] block px-3 py-2 rounded-md text-base font-medium">Katalog</a>
                {{-- <a href="#"
                    class="text-gray-600 hover:bg-gray-50 hover:text-[#D84315] block px-3 py-2 rounded-md text-base font-medium">About
                    Us</a> --}}
                <a href="#footer"
                    class="text-gray-600 hover:bg-gray-50 hover:text-[#D84315] block px-3 py-2 rounded-md text-base font-medium">Contact</a>
            </div>

            <div class="pt-4 pb-4 border-t border-gray-200">
                @guest
                    <div class="px-4 space-y-2">
                        <a href="{{ route('login') }}"
                            class="block w-full text-center px-4 py-2 border border-[#5D4037] rounded-full text-[#5D4037] font-medium hover:bg-orange-50">Log
                            In</a>
                        <a href="{{ route('register') }}"
                            class="block w-full text-center px-4 py-2 bg-[#5D4037] border border-transparent rounded-full text-white font-medium hover:bg-[#3E2723]">Sign
                            Up</a>
                    </div>
                @else
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <div
                                class="h-10 w-10 rounded-full bg-[#D7CCC8] flex items-center justify-center text-[#5D4037] font-bold border border-[#A1887F]">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-[#3E2723]">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium leading-none text-gray-500 mt-1">{{ Auth::user()->email }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <a href="#"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-[#D84315] hover:bg-orange-50">Profil
                            Saya</a>
                        <a href="{{ route('orders.myorders') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-[#D84315] hover:bg-orange-50">Pesanan
                            Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50">Sign
                                out</button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="flex-grow">

        @yield('content')
    </main>

    @include('components.toast')

    @include('layouts.footer')

    {{-- Javascript Logic untuk Navbar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- 1. Logic Hamburger Menu (Mobile) ---
            const btnMobile = document.getElementById('mobile-menu-button');
            const menuMobile = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('menu-icon-open');
            const iconClose = document.getElementById('menu-icon-close');

            if (btnMobile) {
                btnMobile.addEventListener('click', () => {
                    menuMobile.classList.toggle('hidden');
                    iconOpen.classList.toggle('hidden');
                    iconClose.classList.toggle('hidden');
                });
            }

            // --- 2. Logic Dropdown User (Desktop) ---
            const btnUser = document.getElementById('desktop-user-menu-button');
            const dropdownUser = document.getElementById('desktop-user-menu-dropdown');

            if (btnUser && dropdownUser) {
                // Toggle saat klik tombol
                btnUser.addEventListener('click', (e) => {
                    e.stopPropagation(); // Mencegah event bubbling
                    dropdownUser.classList.toggle('hidden');
                });

                // Tutup dropdown jika klik di luar
                window.addEventListener('click', (e) => {
                    if (!btnUser.contains(e.target) && !dropdownUser.contains(e.target)) {
                        dropdownUser.classList.add('hidden');
                    }
                });
            }

            // --- 3. Smooth Scroll ---
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    if (this.getAttribute('href').length > 1) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href').substring(
                            1); // ambil ID setelah #
                        const targetElement = document.getElementById(
                            targetId); // cari elemen by ID

                        if (targetElement) {
                            // Scroll manual jika elemen ada
                            const headerOffset = 80; // sesuaikan dengan tinggi navbar
                            const elementPosition = targetElement.getBoundingClientRect().top;
                            const offsetPosition = elementPosition + window.pageYOffset -
                                headerOffset;

                            window.scrollTo({
                                top: offsetPosition,
                                behavior: "smooth"
                            });
                        } else {
                            // Fallback jika ID tidak ditemukan di halaman ini (misal link #produk tapi di halaman lain)
                            // Biarkan default behavior atau redirect jika perlu
                            window.location.href = this.getAttribute('href');
                        }
                    }
                });
            });

        });

          function slideLeft() {
            var container = document.getElementById('product-slider');
            // Geser ke kiri sejauh 250px (cukup sekali perintah, CSS yang akan membuatnya mulus)
            container.scrollBy({
                left: -250,
                behavior: 'smooth'
            });
        }

        function slideRight() {
            var container = document.getElementById('product-slider');
            // Geser ke kanan sejauh 250px
            container.scrollBy({
                left: 250,
                behavior: 'smooth'
            });
        }

        function slideLeft() {
            const slider = document.getElementById('catalog-slider');
            if(slider) {
                // Geser ke KIRI (Negatif) sejauh lebar kartu
                slider.scrollBy({ left: -300, behavior: 'smooth' });
            }
        }

        function slideRight() {
            const slider = document.getElementById('catalog-slider');
            if(slider) {
                // Geser ke KANAN (Positif) sejauh lebar kartu
                slider.scrollBy({ left: 300, behavior: 'smooth' });
            }
        }
    </script>

    @stack('scripts')
</body>

</html>
