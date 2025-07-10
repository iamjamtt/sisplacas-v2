<div>
    <x-head title="Mi perfil">
        <x-slot name="breadcrumbs">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item icon="home" href="{{ route('inicio.index') }}" wire:navigate />
                <flux:breadcrumbs.item>Mi perfil</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </x-slot>
    </x-head>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="col-span-1 md:col-span-2 lg:col-span-3 xl:col-span-4 relative">
            <x-card class="lg:max-w-xl">
                <x-card.body>
                    <flux:heading size="lg" class="flex items-center gap-2">
                        <flux:icon.key class="p-1 rounded-md shadow-xs border border-zinc-200 dark:border-zinc-700" variant="solid" />
                        Seguridad
                    </flux:heading>
                    <flux:text size="sm" class="text-zinc-500 dark:text-zinc-400 mt-2">
                        Actualiza tu contraseña y preferencias de seguridad.
                    </flux:text>
                    <flux:separator variant="subtle" class="mt-2 mb-4" />
                    <div class="grid grid-cols-1 gap-6">
                        <flux:field>
                            <flux:label>
                                Contraseña actual <span class="text-red-500 ml-2">*</span>
                            </flux:label>
                            <flux:input
                                type="password"
                                wire:model.live="password"
                                placeholder="Ingrese la contraseña actual..."
                            />
                            <flux:error name="password" />
                        </flux:field>
                        <flux:field>
                            <flux:label>
                                Nueva contraseña <span class="text-red-500 ml-2">*</span>
                            </flux:label>
                            <flux:input
                                type="password"
                                wire:model.live="nueva_contrasena"
                                placeholder="Ingrese la nueva contraseña..."
                            />
                            <flux:error name="nueva_contrasena" />
                        </flux:field>
                    </div>
                    <flux:separator variant="subtle" class="my-4" />
                    <div class="flex items-center justify-end gap-2">
                        <flux:button
                            variant="subtle"
                            wire:click="restablecerPerfilSeguridad"
                            class="cursor-pointer"
                        >
                            Restablecer
                        </flux:button>
                        <flux:button
                            variant="primary"
                            wire:click="guardarPerfilSeguridad"
                            class="cursor-pointer"
                        >
                            Guardar
                        </flux:button>
                    </div>
                </x-card.body>
            </x-card>
        </div>
    </div>
</div>
