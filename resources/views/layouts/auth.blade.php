<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth') - AutoRent</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-bg text-text font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center px-4 py-10">

        <div class="bg-white rounded-2xl shadow-xl border border-border p-8 sm:p-10 w-full max-w-md">
            <!-- Logo -->
            <a href="{{ route('landing') }}" class="flex items-center justify-center gap-2.5 mb-8">
                <span class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white text-xl">
                    <i class="fa-solid fa-car"></i>
                </span>
                <span class="text-2xl font-bold text-primary">AutoRent</span>
            </a>

            <h2 class="text-center text-xl font-bold mb-6">@yield('judul')</h2>

            @if (session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-exclamation mt-0.5"></i> {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('form')

            @yield('link-alternatif')

            <p class="text-center text-sm mt-3">
                <a href="{{ route('landing') }}" class="text-primary font-semibold">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Beranda
                </a>
            </p>
        </div>
    </div>
</body>

</html>
