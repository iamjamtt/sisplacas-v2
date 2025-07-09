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
        <div class="col-span-1 lg:col-span-2 xl:col-span-1">
            <div class="flex items-center gap-2 mb-3">
                <flux:avatar
                    :name="$usuario->nombre_usu"
                    src="{{ $usuario->tieneFoto ? $usuario->avatar_usu : null }}"
                    color="auto"
                    size="lg"
                />
                <div>
                    <flux:heading>{{ $usuario->nombre_usu }}</flux:heading>
                    <flux:text>
                        {{ $usuario->correo_electronico_usu }}
                    </flux:text>
                </div>
            </div>
            <flux:navlist class="w-full space-y-2" variant="outline">
                <flux:navlist.item
                    wire:click="asignarTab('perfil')"
                    :current="$tab === 'perfil'"
                    class="cursor-pointer"
                >
                    <x-slot name="icon">
                        <i class="ki-filled ki-user-edit mt-1 text-lg"></i>
                    </x-slot>
                    Perfil
                </flux:navlist.item>
                <flux:navlist.item
                    wire:click="asignarTab('seguridad')"
                    :current="$tab === 'seguridad'"
                    class="cursor-pointer"
                >
                    <x-slot name="icon">
                        <i class="ki-filled ki-key mt-1 text-lg"></i>
                    </x-slot>
                    Seguridad
                </flux:navlist.item>
            </flux:navlist>
        </div>
        <div class="col-span-1 md:col-span-2 lg:col-span-3 xl:col-span-4 relative">
            <x-card
                wire:show="tab === 'perfil'"
                wire:cloak
                wire:transition.in.duration.500ms
                class="lg:max-w-xl"
            >
                <x-card.body>
                    <flux:heading size="lg" class="flex items-center gap-2">
                        <flux:icon.user class="p-1 rounded-md shadow-xs border border-zinc-200 dark:border-zinc-700" variant="solid" />
                        Perfil
                    </flux:heading>
                    <flux:text size="sm" class="text-zinc-500 dark:text-zinc-400 mt-2">
                        Actualiza tu información personal y preferencias de cuenta.
                    </flux:text>
                    <flux:separator variant="subtle" class="mt-2 mb-4" />
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex items-center gap-4">
                            @if ($foto)
                                <img
                                    src="{{ $foto->temporaryUrl() }}"
                                    alt="Foto de perfil"
                                    class="size-16 rounded-xl object-cover border border-zinc-200 dark:border-zinc-700 shadow-xs"
                                />
                            @else
                                <flux:avatar
                                    :name="$usuario->nombre_usu"
                                    src="{{ $usuario->tieneFoto ? $usuario->avatar_usu : null }}"
                                    color="auto"
                                    size="xl"
                                />
                            @endif
                            <div>
                                <flux:field>
                                    <flux:label>Foto de perfil</flux:label>
                                    <br>
                                    <flux:button
                                        size="sm"
                                        onclick="document.getElementById('foto').click()"
                                        class="cursor-pointer"
                                    >
                                        Subir imagen
                                    </flux:button>
                                    <input
                                        type="file"
                                        wire:model.live="foto"
                                        class="hidden"
                                        accept="image/*"
                                        id="foto"
                                    />
                                    <flux:error name="password" />
                                </flux:field>
                            </div>
                        </div>
                        <flux:field>
                            <flux:label badge="Obligatorio">Nombre</flux:label>
                            <flux:input
                                oninput="this.value = this.value.toUpperCase()"
                                wire:model.live="nombre"
                                placeholder="Ingrese el nombre del usuario..."
                            />
                            <flux:error name="nombre" />
                        </flux:field>
                    </div>
                    <flux:separator variant="subtle" class="my-4" />
                    <div class="flex items-center justify-end gap-2">
                        <flux:button
                            variant="subtle"
                            wire:click="restablecerPerfil"
                            class="cursor-pointer"
                        >
                            Restablecer
                        </flux:button>
                        <flux:button
                            variant="primary"
                            wire:click="guardarPerfil"
                            class="cursor-pointer"
                        >
                            Guardar
                        </flux:button>
                    </div>
                </x-card.body>
            </x-card>
            <x-card
                wire:show="tab === 'seguridad'"
                wire:cloak
                wire:transition.in.duration.500ms
                class="lg:max-w-xl"
            >
                <x-card.body>
                    <flux:heading size="lg" class="flex items-center gap-2">
                        <flux:icon.key class="p-1 rounded-md shadow-xs border border-zinc-200 dark:border-zinc-700" variant="solid" />
                        Seguridad
                    </flux:heading>
                    <flux:text size="sm" class="text-zinc-500 dark:text-zinc-400 mt-2">
                        Actualiza tu contraseña y preferencias de seguridad.
                    </flux:text>
                    <flux:separator variant="subtle" class="mt-2 mb-4" />
                    <div class="grid grid-cols-1 gap-4">
                        <flux:field>
                            <flux:label badge="Obligatorio">
                                Contraseña actual
                            </flux:label>
                            <flux:input
                                type="password"
                                wire:model.live="password"
                                placeholder="Ingrese la contraseña actual..."
                            />
                            <flux:error name="password" />
                        </flux:field>
                        <flux:field>
                            <flux:label badge="Obligatorio">
                                Nueva contraseña
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
            <div
                class="absolute inset-0 bg-white dark:bg-zinc-800 opacity-50 lg:max-w-xl"
                wire:loading
                wire:target="asignarTab"
            ></div>
            <div
                class="flex justify-center items-center absolute inset-0 bd-white dark:bd-zinc-800 opacity-50 lg:max-w-xl"
                wire:loading.flex
                wire:target="asignarTab"
            >
                <flux:icon.loading class="size-8" />
            </div>
        </div>
    </div>
</div>
