<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Dashboard - AutoRent Komponen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-bg text-text font-sans antialiased">

    <!-- ============ LAYOUT DASHBOARD ADMIN ============
         Pola: sidebar fixed (kiri) + main-content (margin-kiri) .
         main-content berisi: topbar (sticky) + content-area. -->

    <!-- Sidebar -->
    <aside class="w-60 bg-sidebar text-[#c8d6e5] flex flex-col fixed inset-y-0 left-0 z-40 hidden md:flex">
        <div class="flex items-center gap-2.5 px-5 py-5 border-b border-white/10">
            <span class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white text-lg">
                <i class="fa-solid fa-car"></i>
            </span>
            <div class="flex items-center gap-2">
                <span class="font-bold text-white">AutoRent</span>
                <span
                    class="text-[10px] bg-accent text-white px-2 py-0.5 rounded-full font-semibold uppercase">Admin</span>
            </div>
        </div>
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="{{route('index-dashboard')}}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium {{ url()->current() == route('index-dashboard') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 hover:text-[#e0e8f2] transition' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i> Dashboard
            </a>
            <a href="{{ route('index-kelola-mobil') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('index-kelola-mobil*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 hover:text-[#e0e8f2] transition' }}">
                <i class="fa-solid fa-car w-5 text-center"></i> Kelola Mobil
            </a>
            <a href="{{ route('admin.transaksi.index') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.transaksi.*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 hover:text-[#e0e8f2] transition' }}">
                <i class="fa-solid fa-receipt w-5 text-center"></i> Transaksi
            </a>
            <a href="{{ route('admin.user.index') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.user.*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 hover:text-[#e0e8f2] transition' }}">
                <i class="fa-solid fa-users-gear w-5 text-center"></i> Kelola User
            </a>
        </nav>
        <div class="px-3 py-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm text-[#a0b4cc] hover:bg-red-500/15 hover:text-red-300 transition">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 md:ml-60 flex flex-col min-h-screen">

        <!-- Topbar -->
        <header
            class="bg-white border-b border-border px-6 py-3.5 flex items-center justify-between gap-4 sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-primary"></i> @yield('title', 'RentAuto')
                </span>
            </div>
            <div class="flex items-center gap-3">

                <span
                    class="w-9 h-9 bg-primary-light text-primary rounded-full flex items-center justify-center text-sm font-bold">{{ strtoupper(substr(auth()->user()->nama ?? 'AD', 0, 2)) }}</span>
            </div>
        </header>

        <!-- Content Area -->
        @yield('content')
        {{-- <div class="flex-1 p-6 sm:p-8">
            <div class="bg-white rounded-2xl border border-dashed border-border p-10 text-center text-text-light">
            </div>
        </div> --}}
    </div>

</body>

</html>
