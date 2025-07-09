<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Universidad Nacional de Ucayali" />
    <meta name="description" content="Sistema de Placas UNIA" />

    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('assets/files/logo-unia.webp') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>

    @fluxAppearance
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col items-center justify-center min-h-screen px-4 text-center">
    <div class="space-y-6 max-w-lg">
        <div class="flex justify-center">
            <div class="relative">
                <div class="text-9xl font-bold text-zinc-100 dark:text-zinc-500">@yield('code')</div>
                @yield('icon')
            </div>
        </div>
        <h1 class="text-3xl font-bold tracking-tighter sm:text-4xl text-zinc-700 dark:text-zinc-100">@yield('title')</h1>
        <p class="text-zinc-500 md:text-xl/relaxed">
            @yield('message')
        </p>
        <div class="flex justify-center">
            <flux:button
                href="javascript:window.history.back();"
                icon="arrow-left"
                variant="subtle"
            >
                Regresar a la página anterior
            </flux:button>
        </div>
    </div>
</body>

</html>
