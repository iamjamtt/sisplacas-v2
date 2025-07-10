<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Universidad Nacional de Ucayali" />
        <meta name="description" content="Sistema de Placas UNIA" />

        <title>{{ $title ?? 'SISPLACAS V2' }}</title>

        <link rel="shortcut icon" href="{{ asset('assets/files/logo-carro.png') }}" type="image/x-icon">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

        <link href="{{ asset('assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />

        <script defer src="https://unpkg.com/alpinejs-notify@latest/dist/notifications.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        @fluxAppearance
        @vite('resources/css/app.css')
    </head>

    <body class="min-h-screen bg-white dark:bg-zinc-800 relative">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(230,230,230,0.35)_1px,transparent_1px),linear-gradient(to_bottom,rgba(230,230,230,0.35)_1px,transparent_1px)] bg-[size:25px_25px] dark:bg-[linear-gradient(to_right,rgba(78,78,78,0.2)_1px,transparent_1px),linear-gradient(to_bottom,rgba(78,78,78,0.2)_1px,transparent_1px)] -z-10"></div>

        <flux:header sticky class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700 !px-4 gap-2">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" />

            <flux:brand href="{{ route('inicio.index') }}" wire:navigate>
                <x-slot name="name">
                    <span class="hidden lg:flex">
                        SISPLACAS V2
                    </span>
                    <span class="lg:hidden">
                        SISPLACAS
                    </span>
                </x-slot>
                <x-slot
                    name="logo"
                    class="flex aspect-square size-10 items-center justify-center rounded-lg bg-white dark:bg-zinc-700 border border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 shadow-xs"
                >
                    <img
                        src="{{ asset('assets/files/logo-carro.png') }}"
                        alt="Logo"
                        class="size-6 fill-current text-white dark:text-black"
                    />
                </x-slot>
            </flux:brand>

            <flux:spacer />

            <flux:dropdown x-data align="end">
                <flux:button variant="subtle" square class="group cursor-pointer" aria-label="Preferred color scheme">
                    <flux:icon.sun x-show="$flux.appearance === 'light'" x-cloak variant="mini" class="text-zinc-500 dark:text-white" />
                    <flux:icon.moon x-show="$flux.appearance === 'dark'" x-cloak variant="mini" class="text-zinc-500 dark:text-white" />
                    <flux:icon.moon x-show="$flux.appearance === 'system' && $flux.dark" x-cloak variant="mini" />
                    <flux:icon.sun x-show="$flux.appearance === 'system' && ! $flux.dark" x-cloak variant="mini" />
                </flux:button>
                <flux:menu>
                    <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Claro</flux:menu.item>
                    <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Oscuro</flux:menu.item>
                    <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">Sistema</flux:menu.item>
                </flux:menu>
            </flux:dropdown>

            <livewire:components.profile.index />
        </flux:header>

        <flux:sidebar stashable sticky class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <flux:brand href="{{ route('inicio.index') }}" class="lg:hidden" wire:navigate>
                <x-slot name="name">
                    SISPLACAS V2
                </x-slot>
                <x-slot
                    name="logo"
                    class="flex aspect-square size-10 items-center justify-center rounded-lg bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75 border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600 shadow-xs"
                >
                    <img
                        src="{{ asset('assets/files/logo-carro.png') }}"
                        alt="Logo"
                        class="size-6 fill-current text-white dark:text-black"
                    />
                </x-slot>
            </flux:brand>

            <flux:navlist variant="outline" class="space-y-4">
                <flux:navlist.group>
                    <flux:navlist.item
                        :href="route('inicio.index')"
                        :current="request()->routeIs('inicio.*')"
                        wire:navigate
                    >
                        <x-slot name="icon">
                            <i class="ki-filled ki-menu mt-1 text-lg"></i>
                        </x-slot>
                        Inicio
                    </flux:navlist.item>
                    <flux:navlist.item
                        :href="route('vehiculo.index')"
                        :current="request()->routeIs('vehiculo.*')"
                        wire:navigate
                    >
                        <x-slot name="icon">
                            <i class="ki-filled ki-delivery mt-1 text-lg"></i>
                        </x-slot>
                        Vehiculos
                    </flux:navlist.item>
                    <flux:navlist.item
                        {{-- :href="route('registros.index')" --}}
                        {{-- :current="request()->routeIs('registros.*')" --}}
                        wire:navigate
                    >
                        <x-slot name="icon">
                            <i class="ki-filled ki-share mt-1 text-lg"></i>
                        </x-slot>
                        Gestion de Control
                    </flux:navlist.item>
                </flux:navlist.group>

            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline" class="space-y-4">
                <flux:navlist.group>
                    <flux:navlist.item
                        :href="route('perfil.index')"
                        :current="request()->routeIs('perfil.*')"
                        wire:navigate
                    >
                        <x-slot name="icon">
                            <i class="ki-filled ki-profile-circle mt-1 text-lg"></i>
                        </x-slot>
                        Mi perfil
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>
        </flux:sidebar>

        <flux:main class="!p-4">
            {{ $slot }}
        </flux:main>

        <flux:footer class="bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700 !py-4 !px-4 space-y-1">
            <flux:text size="sm">
                &copy; {{ date('Y') }} Universidad Nacional de Ucayali
            </flux:text>
            <flux:text size="sm">

            </flux:text>
        </flux:footer>

        @persist('toast')
            <x-notificacion />
        @endpersist

        @fluxScripts
        @vite('resources/js/app.js')
    </body>
</html>
