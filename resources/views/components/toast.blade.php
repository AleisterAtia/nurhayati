@if (session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
    <div id="toast-notification" 
         class="fixed bottom-5 right-5 z-[999] flex items-center w-full max-w-sm p-4 text-gray-500 bg-white rounded-2xl shadow-2xl border-l-4 border-gray-200 transform transition-all duration-500 translate-y-20 opacity-0"
         role="alert">
        
        {{-- Ikon & Warna Border Berdasarkan Tipe Pesan --}}
        @php
            $type = 'info';
            $icon = 'fa-info-circle';
            $color = 'text-blue-500';
            $borderColor = 'border-blue-500';

            if(session('success')) {
                $type = 'success';
                $icon = 'fa-check-circle';
                $color = 'text-green-500';
                $borderColor = 'border-green-500';
                $message = session('success');
            } elseif(session('error')) {
                $type = 'error';
                $icon = 'fa-times-circle';
                $color = 'text-red-500';
                $borderColor = 'border-red-500';
                $message = session('error');
            } elseif(session('warning')) {
                $type = 'warning';
                $icon = 'fa-exclamation-circle';
                $color = 'text-yellow-500';
                $borderColor = 'border-yellow-500';
                $message = session('warning');
            } else {
                $message = session('info');
            }
        @endphp

        {{-- Set Border Color Dinamis --}}
        <style>
            #toast-notification { border-left-color: var(--toast-border); }
        </style>
        
        {{-- Ikon --}}
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 {{ $color }} bg-gray-50 rounded-full">
            <i class="fas {{ $icon }} text-lg"></i>
        </div>

        {{-- Pesan --}}
        <div class="ml-3 text-sm font-medium text-[#3E2723] break-words flex-1">
            {{ $message }}
        </div>

        {{-- Tombol Close --}}
        <button type="button" onclick="closeToast()" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 items-center justify-center transition-colors">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('toast-notification');
            
            // Set warna border via JS agar dinamis
            toast.style.setProperty('--toast-border', '{{ $type == "success" ? "#22c55e" : ($type == "error" ? "#ef4444" : ($type == "warning" ? "#eab308" : "#3b82f6")) }}');

            // Animasi Masuk (Slide Up & Fade In)
            setTimeout(() => {
                toast.classList.remove('translate-y-20', 'opacity-0');
            }, 100);

            // Timer Hilang Otomatis (4 Detik)
            setTimeout(() => {
                closeToast();
            }, 4000);
        });

        function closeToast() {
            const toast = document.getElementById('toast-notification');
            if(toast) {
                // Animasi Keluar
                toast.classList.add('translate-y-20', 'opacity-0');
                // Hapus dari DOM setelah animasi selesai
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }
        }
    </script>
@endif