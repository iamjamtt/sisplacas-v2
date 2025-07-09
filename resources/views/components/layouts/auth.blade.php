<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Universidad Nacional de Ucayali" />
        <meta name="description" content="Sistema de Placas UNIA" />

        <title>{{ $title ?? 'REGISTROS ACADÉMICOS UNIA' }}</title>

        <link rel="shortcut icon" href="{{ asset('assets/files/logo-carro.png') }}" type="image/x-icon">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

        <link href="{{ asset('assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />

        <script defer src="https://unpkg.com/alpinejs-notify@latest/dist/notifications.min.js"></script>

        @fluxAppearance
        @vite('resources/css/app.css')
    </head>

    <body class="min-h-screen bg-white dark:bg-zinc-800 relative">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(230,230,230,0.35)_1px,transparent_1px),linear-gradient(to_bottom,rgba(230,230,230,0.35)_1px,transparent_1px)] bg-[size:25px_25px] dark:bg-[linear-gradient(to_right,rgba(78,78,78,0.2)_1px,transparent_1px),linear-gradient(to_bottom,rgba(78,78,78,0.2)_1px,transparent_1px)] -z-10"></div>

        <div class="flex min-h-screen">
            <div class="flex-1 flex justify-center items-center relative">
                {{ $slot }}

                <div class="absolute bottom-0 left-0 right-0 flex flex-col items-center justify-center gap-2 p-4">
                    <flux:text size="sm">
                        &copy; {{ date('Y') }} Universidad Nacional de Ucayali
                    </flux:text>
                    <flux:text size="sm">

                    </flux:text>
                </div>
            </div>
            <div class="flex-1 p-4 max-lg:hidden">
                <div
                    class="text-white relative rounded-lg h-full w-full bg-zinc-900 flex flex-col items-start justify-end p-16 shadow"
                    style="background-image: url({{ asset('assets/files/auth_banner.png') }}); background-size: cover; background-position: center;"
                >
                    <div class="flex gap-2 mb-4">
                        <flux:icon.star variant="solid" />
                        <flux:icon.star variant="solid" />
                        <flux:icon.star variant="solid" />
                        <flux:icon.star variant="solid" />
                        <flux:icon.star variant="solid" />
                    </div>
                    <div class="mb-6 italic font-base text-3xl xl:text-4xl">
                        <p class="text-2xl xl:text-3xl font-bold" style="text-shadow: 2px 2px 4px rgba(0,0,0,1);">
                            Sistema de Placas
                        </p>
                        <p class="text-xl xl:text-2xl font-semibold" style="text-shadow: 2px 2px 4px rgba(0,0,0,1);">
                            Universidad Nacional de Ucayali
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @persist('toast')
            <x-notificacion />
        @endpersist

        @fluxScripts
        @vite('resources/js/app.js')
    </body>
</html>
