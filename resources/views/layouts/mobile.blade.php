<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Petugas') - AutoRent</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-bg text-text font-sans antialiased">

    <!-- Header -->
    <div
        class="bg-white px-4 py-3 flex items-center justify-between border-b border-border sticky top-0 z-30 shadow-sm">
        <div class="font-bold text-lg flex items-center gap-2">
            <i class="fa-solid fa-car text-primary"></i> AutoRent Petugas
        </div>
        <a href="{{ route('petugas.transaksi.form') }}"
            class="bg-primary text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-1.5">
            <i class="fa-solid fa-plus"></i> Transaksi
        </a>
    </div>

    <!-- Content -->
    <main class="flex-1 p-4 pb-28">
        @yield('content')
    </main>

    <!-- Bottom Navigation -->
    <nav
        class="fixed bottom-0 inset-x-0 bg-white border-t border-border flex justify-around items-center h-16 z-40 shadow-[0_-2px_10px_rgba(0,0,0,0.05)]">
        <a href="{{ route('petugas.transaksi.index') }}"
            class="flex flex-col items-center gap-0.5 text-[11px] font-semibold {{ request()->routeIs('petugas.transaksi.index') ? 'text-primary bg-primary-light' : 'text-text-light hover:text-primary' }} px-4 py-1.5 rounded-xl transition">
            <i class="fa-solid fa-credit-card text-lg"></i>
            <span>Transaksi</span>
        </a>
        <a href="{{ route('petugas.transaksi.form') }}"
            class="flex flex-col items-center gap-0.5 text-[11px] font-semibold {{ request()->routeIs('petugas.transaksi.form') ? 'text-primary bg-primary-light' : 'text-text-light hover:text-primary' }} px-4 py-1.5 rounded-xl transition">
            <i class="fa-solid fa-pen-to-square text-lg"></i>
            <span>Input Baru</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex flex-col items-center gap-0.5 text-[11px] font-semibold text-text-light hover:text-danger px-4 py-1.5 rounded-xl transition">
                <i class="fa-solid fa-right-from-bracket text-lg"></i>
                <span>Keluar</span>
            </button>
        </form>
    </nav>

</body>

</html>
