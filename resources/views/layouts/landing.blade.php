<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AutoRent') - Rental Mobil Terpercaya</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-bg text-text font-sans antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav
        class="bg-white/95 backdrop-blur border-b border-border px-4 sm:px-10 py-3 sm:py-4 flex items-center justify-between sticky top-0 z-40">
        <a href="{{ route('landing') }}" class="flex items-center gap-2.5 font-bold text-xl text-primary">
            <span class="w-9 h-9 bg-primary rounded-xl flex items-center justify-center text-white">
                <i class="fa-solid fa-car"></i>
            </span>
            AutoRent
        </a>
        <div class="flex items-center gap-3 sm:gap-6">
            @auth
                @if (auth()->user()->role === 'user')
                    <a href="{{ route('riwayat') }}"
                        class="text-sm font-medium hover:text-primary transition hidden sm:flex items-center gap-1.5">
                        <i class="fa-solid fa-clipboard-list"></i> Riwayat Saya
                    </a>
                @endif
                <span class="text-sm font-semibold hidden md:inline">{{ auth()->user()->nama }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="border-2 border-border hover:border-danger hover:text-danger text-text-light px-4 py-2 rounded-full text-sm font-semibold transition flex items-center gap-1.5">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar
                    </button>
                </form>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="text-sm font-medium hover:text-primary transition">Masuk</a>
                <a href="{{ route('register') }}"
                    class="bg-accent hover:bg-accent-dark text-white px-4 sm:px-5 py-2.5 rounded-full text-sm font-semibold transition">Daftar</a>
            @endguest
        </div>
    </nav>

    <!-- Konten -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#1a1f2e] text-[#aab4c0] text-center py-8 mt-12">
        <p class="text-sm">&copy; 2026 <strong class="text-white">AutoRent</strong> — Rental Mobil Terpercaya di
            Indonesia.</p>
    </footer>

</body>

</html>
