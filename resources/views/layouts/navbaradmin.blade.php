<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Scrollbar kustom */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #D7CCC8;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #A1887F;
        }

        .nav-active {
            background-color: #5D4037;
            border-right: 4px solid #D84315;
            color: white;
        }
        
        /* Animasi Dropdown */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.2s ease-out;
        }
    </style>
</head>

<body class="bg-[#FFFBF2] text-[#4A3426] font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- 1. OVERLAY (Mobile) --}}
        <div id="sidebar-overlay" onclick="toggleSidebar()"
            class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden hidden" aria-hidden="true">
        </div>

        {{-- 2. SIDEBAR --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-30 w-64 bg-[#3E2723] text-[#FFFBF2] transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 shadow-2xl flex flex-col">

            {{-- Sidebar Header --}}
            <div class="flex items-center justify-center h-20 border-b border-[#5D4037] bg-[#2D1B15]">
                <div class="flex items-center gap-3">
                    <div class="bg-white p-1.5 rounded-full">
                        <img src="{{ asset('gambar/logo.png') }}" alt="Logo" class="h-8 w-8 object-contain">
                    </div>
                    <span class="text-lg font-bold tracking-wider text-white">ADMIN PANEL</span>
                </div>
            </div>

            {{-- Sidebar Navigation --}}
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'nav-active' : 'hover:bg-[#4E342E] text-gray-300 hover:text-white' }}">
                    <i class="fas fa-tachometer-alt w-6 text-center {{ request()->routeIs('admin.dashboard') ? 'text-[#FFAB91]' : 'text-gray-400 group-hover:text-white' }}"></i>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>

                <a href="{{ route('products.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('products.*') ? 'nav-active' : 'hover:bg-[#4E342E] text-gray-300 hover:text-white' }}">
                    <i class="fas fa-box-open w-6 text-center {{ request()->routeIs('products.*') ? 'text-[#FFAB91]' : 'text-gray-400 group-hover:text-white' }}"></i>
                    <span class="ml-3 font-medium">Kelola Produk</span>
                </a>

                <a href="{{ route('orders.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('orders.*') ? 'nav-active' : 'hover:bg-[#4E342E] text-gray-300 hover:text-white' }}">
                    <i class="fas fa-shopping-cart w-6 text-center {{ request()->routeIs('orders.*') ? 'text-[#FFAB91]' : 'text-gray-400 group-hover:text-white' }}"></i>
                    <span class="ml-3 font-medium">Kelola Pesanan</span>
                </a>

                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Laporan & Lainnya</p>

                <a href="{{ route('laporan.laporanpesanan') }}"
                    class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('laporan.*') ? 'nav-active' : 'hover:bg-[#4E342E] text-gray-300 hover:text-white' }}">
                    <i class="fas fa-chart-line w-6 text-center {{ request()->routeIs('laporan.*') ? 'text-[#FFAB91]' : 'text-gray-400 group-hover:text-white' }}"></i>
                    <span class="ml-3 font-medium">Laporan Pesanan</span>
                </a>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="p-4 border-t border-[#5D4037] bg-[#2D1B15]">


                <a href="{{ route('profile.admin') }}" class="flex items-center gap-3 mb-4 px-2 group hover:bg-[#3E2723] p-2 rounded-lg transition-colors cursor-pointer">
        <div class="h-10 w-10 rounded-full bg-[#D84315] flex items-center justify-center text-white font-bold border-2 border-[#5D4037] group-hover:border-white transition-colors">
            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
        </div>
        <div class="overflow-hidden">
            <p class="text-sm font-bold text-white truncate group-hover:text-[#FFAB91] transition-colors">{{ Auth::user()->name ?? 'Admin' }}</p>
            <p class="text-xs text-gray-400 truncate">Administrator</p>
        </div>
    </a>


                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-[#B71C1C] hover:bg-[#D32F2F] text-white transition-colors duration-200 shadow-md">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- 3. MAIN CONTENT WRAPPER --}}
        <div class="flex-1 flex flex-col overflow-hidden relative">

            {{-- Top Header --}}
            <header class="flex items-center justify-between px-6 py-4 bg-white shadow-sm border-b border-orange-100 z-10">
                <div class="flex items-center gap-4">
                    {{-- Hamburger Button --}}
                    <button onclick="toggleSidebar()"
                        class="lg:hidden text-[#3E2723] hover:text-[#D84315] focus:outline-none transition-colors">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>

                    <h1 class="text-xl md:text-2xl font-bold text-[#3E2723]">
                        @yield('page-title', 'Admin Dashboard')
                    </h1>
                </div>

                {{-- Admin Actions (Notifikasi & Profile) --}}
                <div class="flex items-center gap-4">
                    
                    {{-- ===== LOGIKA NOTIFIKASI START ===== --}}
                    @php
                        // Mengambil notifikasi user yang sedang login (Admin)
                        $notifications = auth()->user()->unreadNotifications;
                    @endphp

                    <div class="relative">
                        {{-- Tombol Lonceng --}}
                        <button onclick="toggleNotificationDropdown()" 
                                class="relative p-2 text-[#5D4037] hover:text-[#D84315] transition-colors focus:outline-none">
                            <i class="fas fa-bell text-xl"></i>
                            
                            {{-- Badge Merah (Hanya muncul jika ada notifikasi) --}}
                            @if($notifications->count() > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full animate-pulse border-2 border-white">
                                    {{ $notifications->count() }}
                                </span>
                            @endif
                        </button>
                    
                        {{-- Dropdown Menu --}}
                        <div id="notification-dropdown" 
                             class="hidden absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-xl border border-orange-100 overflow-hidden z-50 origin-top-right animate-fade-in-down">
                            
                            <div class="px-4 py-3 bg-orange-50 border-b border-orange-100 flex justify-between items-center">
                                <h3 class="text-sm font-bold text-[#3E2723]">Notifikasi</h3>
                                @if($notifications->count() > 0)
                                    <a href="{{ route('notifications.markAsRead') }}" class="text-xs text-[#D84315] hover:underline font-semibold">Tandai semua dibaca</a>
                                @endif
                            </div>
                    
                            <div class="max-h-80 overflow-y-auto custom-scrollbar">
                                @forelse($notifications as $notification)
                                    <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 hover:bg-orange-50/50 transition border-b border-gray-50 last:border-0 group">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 bg-orange-100 rounded-full p-2 text-[#D84315] group-hover:bg-[#D84315] group-hover:text-white transition-colors">
                                                <i class="fas fa-shopping-bag text-sm"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-bold text-gray-800 truncate">
                                                    {{ $notification->data['user_name'] ?? 'Pelanggan' }}
                                                </p>
                                                <p class="text-xs text-gray-600 mt-0.5 line-clamp-2">
                                                    {{ $notification->data['message'] ?? 'Pesanan baru masuk' }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 mt-1 flex items-center gap-1">
                                                    <i class="far fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-4 py-8 text-center text-gray-400">
                                        <div class="bg-gray-50 rounded-full h-12 w-12 flex items-center justify-center mx-auto mb-2 text-gray-300">
                                            <i class="far fa-bell-slash text-xl"></i>
                                        </div>
                                        <p class="text-sm">Tidak ada notifikasi baru.</p>
                                    </div>
                                @endforelse
                            </div>
                            
                            @if($notifications->count() > 0)
                                <div class="bg-gray-50 px-4 py-2 text-center border-t border-gray-100">
                                    <a href="{{ route('orders.index') }}" class="text-xs font-bold text-[#5D4037] hover:text-[#D84315]">Lihat Semua Pesanan</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- ===== LOGIKA NOTIFIKASI END ===== --}}

                </div>
            </header>

            {{-- Scrollable Content Area --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#FFFBF2] p-6 scroll-smooth">
                {{-- Flash Message --}}

                @yield('content')
            </main>
            @include('components.toast')
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        // Toggle Sidebar Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        // Toggle Notification Dropdown
        function toggleNotificationDropdown() {
            const dropdown = document.getElementById('notification-dropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close Dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notification-dropdown');
            const button = event.target.closest('button[onclick="toggleNotificationDropdown()"]');
            
            // Jika klik di luar dropdown DAN bukan di tombol loncengnya
            if (!dropdown.classList.contains('hidden') && !dropdown.contains(event.target) && !button) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>

</html>