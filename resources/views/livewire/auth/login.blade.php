<div class="w-80 max-w-80 space-y-6 py-4 mb-10">
    <div class="flex justify-center opacity-85 dark:opacity-90">
        <a
            href="{{ route('inicio.index') }}"
            wire:navigate
            class="group flex items-center gap-3"
        >
        <div class="flex aspect-square size-22 items-center justify-center rounded-2xl bg-white dark:bg-zinc-700 border border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 shadow-xs">
            <img
                src="{{ asset('assets/files/logo-carro.png') }}"
                alt="Logo"
                class="size-14 fill-current text-white dark:text-black"
            />
        </div>
        </a>
    </div>
    <flux:heading class="text-center" size="xl">
        Sistema de Placas
    </flux:heading>
    <form class="flex flex-col gap-6" wire:submit="login">
        <div class="flex flex-col gap-4">
            <flux:input label="Correo Electrónico" wire:model="correo_electronico" placeholder="correo_electronico@unu.edu.pe" />
            <flux:input label="Contraseña" type="password" wire:model="contrasena" placeholder="Ingrese su contraseña" viewable />
        </div>
        <flux:checkbox label="Recordarme" wire:model="recuerdame" />
        <flux:button type="submit" variant="primary" class="w-full cursor-pointer">
            Iniciar sesión
        </flux:button>
    </form>
</div>
