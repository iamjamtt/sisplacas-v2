<div>
    <x-head title="Gestión de Control de Vehículos">
        <x-slot name="breadcrumbs">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item icon="home" href="{{ route('inicio.index') }}" wire:navigate />
                <flux:breadcrumbs.item>Gestión de Control</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </x-slot>
        <x-slot name="button">
            <flux:button icon="arrow-down-tray" variant="primary" class="cursor-pointer" wire:click="exportar">
                Exportar
            </flux:button>
        </x-slot>
    </x-head>

    <div class="grid grid-cols-1 gap-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4 w-full md:w-sm">
                <flux:input
                    icon="magnifying-glass"
                    placeholder="Buscar por placa y conductor..."
                    wire:model.live.debounce.500ms="buscar"
                    label="Filtro búsqueda"
                >
                    <x-slot name="iconTrailing">
                        <flux:button
                            size="sm"
                            variant="subtle"
                            icon="x-mark"
                            class="-mr-1"
                            x-on:click="$wire.set('buscar', '')"
                        />
                    </x-slot>
                </flux:input>
            </div>
            <flux:input
                type="date"
                wire:model.live.debounce.500ms="filtroFecha"
                label="Filtro fecha"
                class="w-full md:w-64"
            >
                <x-slot name="iconTrailing">
                    <flux:button
                        size="sm"
                        variant="subtle"
                        icon="x-mark"
                        class="-mr-1"
                        x-on:click="$wire.set('filtroFecha', null)"
                    />
                </x-slot>
            </flux:input>
        </div>

        <x-card wire:poll.15s>
            <x-card.body class="!p-0 relative overflow-hidden w-full overflow-x-auto rounded-xl border border-zinc-200">
                <table class="w-full text-left text-sm text-zinc-800 dark:text-zinc-200">
                    <thead class="border-b border-zinc-200 bg-zinc-200/25 text-sm text-zinc-700 dark:border-zinc-700 dark:bg-zinc-800/75 dark:text-zinc-100">
                        <tr>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 w-[10px] text-center">NRO</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 w-[80px] min-w-[65px] text-center">PLACA</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 min-w-sm">CONDUCTOR</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 text-center">INGRESO</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 text-center">FOTO INGRESO</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 text-center">SALIDA</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 text-center">FOTO SALIDA</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 w-[10px]"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($this->controles as $item)
                            <tr wire:key="item-{{ $item->id }}">
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2 text-center font-semibold">
                                    {{ $loop->iteration + ($this->controles->currentPage() - 1) * $this->controles->perPage() }}
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2 text-center">
                                    <flux:badge :color="$item->vehiculo->tieneSancion ? 'zinc' : 'sky'">
                                        {{ $item->vehiculo->placa }}
                                    </flux:badge>
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2">
                                    {{ $item->vehiculo->nombre_completo }}
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2 text-center">
                                    {{ $item->ingreso->format('H:i a d/m/Y') }}
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2 text-center">
                                    <flux:button size="sm" icon="photo" variant="primary" color="cyan" class="cursor-pointer" wire:click="verFotos({{ $item->id }}, 'ingreso')">Ver fotos</flux:button>
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2 text-center">
                                    {{ $item->salida ? $item->salida->format('H:i a d/m/Y') : '-' }}
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2 text-center">
                                    @if ($item->salida)
                                        <flux:button size="sm" icon="photo" variant="primary" color="cyan" class="cursor-pointer" wire:click="verFotos({{ $item->id }}, 'salida')">Ver fotos</flux:button>
                                    @else
                                        -
                                    @endif
                                </td>
                                {{-- <td class="border-l border-zinc-200 dark:border-zinc-700 p-2">
                                    <div class="flex items-center justify-center">
                                        <flux:dropdown position="bottom" align="end">
                                            <flux:button variant="filled" size="sm" inset="bottom" icon="ellipsis-horizontal" class="cursor-pointer" />

                                            <flux:menu>
                                                <flux:menu.group heading="Acciones">
                                                    <flux:menu.item
                                                        icon="pencil-square"
                                                        class="cursor-pointer"
                                                        wire:click="cargarData({{ $item->id }}, true)"
                                                    >
                                                        Editar registro
                                                    </flux:menu.item>
                                                    <flux:modal.trigger name="modal-eliminar-{{ $item->id }}">
                                                        <flux:menu.item icon="trash" class="cursor-pointer" variant="danger">Eliminar</flux:menu.item>
                                                    </flux:modal.trigger>
                                                </flux:menu.group>
                                            </flux:menu>
                                        </flux:dropdown>
                                        <!-- Modal eliminar registro -->
                                        <flux:modal
                                            name="modal-eliminar-{{ $item->id }}"
                                            class="w-full !p-0 !rounded-2xl"
                                        >
                                            <x-card>
                                                <x-card.body class="space-y-6">
                                                    <div>
                                                        <flux:heading size="lg">
                                                            Eliminar registro
                                                        </flux:heading>

                                                        <flux:subheading>
                                                            <p>
                                                                ¿Está seguro de que desea eliminar el vehículo con placa Nº "{{ $item->placa }}"?
                                                            </p>
                                                        </flux:subheading>
                                                    </div>

                                                    <div class="flex gap-2">
                                                        <flux:spacer />

                                                        <flux:modal.close>
                                                            <flux:button variant="ghost">Cancelar</flux:button>
                                                        </flux:modal.close>

                                                        <flux:button variant="danger" class="cursor-pointer" wire:click="eliminar({{ $item->id }})">
                                                            Eliminar
                                                        </flux:button>
                                                    </div>
                                                </x-card.body>
                                            </x-card>
                                        </flux:modal>
                                    </div>
                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="flex flex-col justify-center items-center gap-3 py-15 text-zinc-500 dark:text-zinc-400">
                                        <flux:icon.exclamation-triangle class="size-8" />
                                        <span>
                                            No se encontraron resultados
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div
                    class="absolute inset-0 bg-white dark:bg-zinc-800 opacity-50"
                    wire:loading
                    wire:target="buscar, gotoPage, nextPage, previousPage, filtroFecha"
                ></div>
                <div
                    class="flex justify-center items-center absolute inset-0 bd-white dark:bd-zinc-800 opacity-50"
                    wire:loading.flex
                    wire:target="buscar, gotoPage, nextPage, previousPage, filtroFecha"
                >
                    <flux:icon.loading class="size-8" />
                </div>
            </x-card.body>
        </x-card>

        @if ($this->controles->hasPages())
            <div class="flex justify-center">
                {{ $this->controles->links() }}
            </div>
        @endif
    </div>

    <!-- Modal ver fotos -->
    <flux:modal
        name="modal-ver-fotos"
        class="w-full !p-0 !rounded-2xl min-w-sm max-w-3xl"
    >
        <x-card>
            <x-card.body>
                <div class="space-y-5">
                    <div>
                        <flux:heading size="lg">
                            Fotos del vehículo con placa Nº {{ $placa ?? 'No disponible' }}
                        </flux:heading>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <flux:heading size="sm">
                                Foto de {{ $tipoFoto ?? '' }} (angulo 1)
                            </flux:heading>
                            @if ($foto1)
                                <img
                                    src="{{ asset($foto1) }}"
                                    alt="Foto de {{ $tipoFoto ?? '' }}"
                                    class="rounded-lg"
                                />
                            @else
                                <div class="flex items-center justify-center h-48 bg-zinc-100 dark:bg-zinc-700 rounded-lg">
                                    <span class="text-zinc-500 dark:text-zinc-400">No hay foto disponible</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col gap-2">
                            <flux:heading size="sm">
                                Foto de {{ $tipoFoto ?? '' }} (angulo 2)
                            </flux:heading>
                            @if ($foto2)
                                <img
                                    src="{{ asset($foto2) }}"
                                    alt="Foto de {{ $tipoFoto ?? '' }}"
                                    class="rounded-lg"
                                />
                            @else
                                <div class="flex items-center justify-center h-48 bg-zinc-100 dark:bg-zinc-700 rounded-lg">
                                    <span class="text-zinc-500 dark:text-zinc-400">No hay foto disponible</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card.body>
        </x-card>
    </flux:modal>
</div>
