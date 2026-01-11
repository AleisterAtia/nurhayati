<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6D4C41',
                        secondary: '#4A3F35',
                        krem: '#F5F5DC',
                        soft: '#FAF8F5',
                        green: '#24913b',
                        greenDark: '#1a6341',
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-krem via-white to-soft p-6">

    <div class="w-full max-w-md backdrop-blur-xl bg-white/80 rounded-2xl shadow-2xl px-8 py-10 border border-white/30 text-center">

        {{-- LOGO --}}
        <div class="flex justify-center mb-6">
            <img src="{{ asset('gambar/logo.png') }}" alt="Logo" class="h-20 w-auto drop-shadow-md">
        </div>

        {{-- ICON EMAIL --}}
        <div class="mb-4 text-green">
            <i class="fas fa-envelope-open-text text-5xl"></i>
        </div>

        {{-- TITLE --}}
        <h2 class="text-2xl font-extrabold text-secondary mb-2">
            Verifikasi Email Anda
        </h2>
        
        <p class="text-sm text-gray-600 mb-6 leading-relaxed">
            Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke email Anda.
        </p>

        {{-- ALERT SUKSES KIRIM ULANG --}}
        @if (session('resent'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2 text-left">
                <i class="fas fa-check-circle"></i>
                <span>Tautan verifikasi baru telah dikirim ke alamat email Anda.</span>
            </div>
        @endif

        {{-- ACTION BUTTONS --}}
        <div class="space-y-4">
            {{-- Tombol Kirim Ulang --}}
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" 
                    class="w-full py-3 rounded-xl bg-primary hover:bg-secondary text-white font-semibold shadow-lg transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane"></i> Kirim Ulang Email Verifikasi
                </button>
            </form>

            {{-- Tombol Logout (Jika salah email) --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-primary underline transition">
                    Logout & Ganti Akun
                </button>
            </form>
        </div>

    </div>

</body>
</html>