<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
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
                        google: '#DB4437'
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-krem via-white to-soft p-6">

    <div
        class="w-full max-w-md backdrop-blur-xl bg-white/80 rounded-2xl shadow-2xl px-8 py-10 border border-white/30">

        {{-- LOGO --}}
        <div class="flex justify-center mb-6">
            <img src="{{ asset('gambar/logo.png') }}" alt="Logo"
                class="h-20 w-auto drop-shadow-md">
        </div>

        {{-- TITLE --}}
        <h2 class="text-3xl font-extrabold text-center text-secondary mb-2">
            Buat Akun Baru
        </h2>
        <p class="text-center text-sm text-gray-500 mb-8">
            Daftar untuk mulai menggunakan layanan kami
        </p>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-1">
                    Nama Lengkap
                </label>
                <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-3 rounded-xl bg-soft border border-gray-300
                           focus:ring-2 focus:ring-primary focus:outline-none transition">
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-1">
                    Email
                </label>
                <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 rounded-xl bg-soft border border-gray-300
                           focus:ring-2 focus:ring-primary focus:outline-none transition">
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-1">
                    Password
                </label>
                <input type="password" placeholder="Minimal 8 karakter" name="password" required
                    class="w-full px-4 py-3 rounded-xl bg-soft border border-gray-300
                           focus:ring-2 focus:ring-primary focus:outline-none transition">
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-1">
                    Konfirmasi Password
                </label>
                <input type="password" placeholder="Minimal 8 karakter" name="password_confirmation" required
                    class="w-full px-4 py-3 rounded-xl bg-soft border border-gray-300
                           focus:ring-2 focus:ring-primary focus:outline-none transition">
            </div>

            {{-- REGISTER BUTTON --}}
            <button type="submit"
                class="w-full py-3 rounded-xl bg-green hover:bg-greenDark text-white
                       font-semibold shadow-lg transition transform hover:-translate-y-0.5">
                Register
            </button>
        </form>

        {{-- DIVIDER --}}
        <div class="flex items-center my-6">
            <div class="flex-grow border-t"></div>
            <span class="mx-3 text-sm text-gray-500">atau</span>
            <div class="flex-grow border-t"></div>
        </div>

        {{-- GOOGLE --}}
        <a href="{{ route('google.redirect') }}"
            class="w-full flex items-center justify-center gap-3 py-3 rounded-xl border
                   bg-white hover:bg-gray-50 shadow transition">
            <i class="fab fa-google text-google text-xl"></i>
            <span class="font-semibold text-secondary">
                Register dengan Google
            </span>
        </a>

        {{-- LOGIN LINK --}}
        <p class="mt-8 text-center text-sm text-primary">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold hover:underline">
                Login
            </a>
        </p>
    </div>

</body>
</html>