<div>
    <x-head title="Gestión de Vehiculos">
        <x-slot name="breadcrumbs">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item icon="home" href="{{ route('inicio.index') }}" wire:navigate />
                <flux:breadcrumbs.item>Gestión de Vehiculos</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </x-slot>
        <x-slot name="button">
            <flux:button icon="pencil-square" variant="primary" class="cursor-pointer" wire:click="cargarData">
                Nuevo registro
            </flux:button>
        </x-slot>
    </x-head>

    <div class="grid grid-cols-1 gap-4">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4 w-full md:w-sm">
                <flux:input
                    icon="magnifying-glass"
                    placeholder="Buscar"
                    wire:model.live.debounce.500ms="buscar"
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
        </div>

        <x-card>
            <x-card.body class="!p-0 relative overflow-hidden w-full overflow-x-auto rounded-xl border border-zinc-200">
                <table class="w-full text-left text-sm text-zinc-800 dark:text-zinc-200">
                    <thead class="border-b border-zinc-200 bg-zinc-200/25 text-sm text-zinc-700 dark:border-zinc-700 dark:bg-zinc-800/75 dark:text-zinc-100">
                        <tr>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 w-[10px] text-center">NRO</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 w-[80px] min-w-[65px] text-center">PLACA</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 min-w-xs">DUEÑO</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2">CONDUCTOR</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2">MARCA</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2">MODELO</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 text-center">SANCION</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 text-center">ESTADO</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 text-center">F. REGISTRO</th>
                            <th scope="col" class="border-l border-zinc-200 dark:border-zinc-700 font-semibold p-2 w-[10px]"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($this->vehiculos as $item)
                            <tr wire:key="item-{{ $item->id }}">
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2 text-center font-semibold">
                                    {{ $loop->iteration + ($this->vehiculos->currentPage() - 1) * $this->vehiculos->perPage() }}
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2 text-center">
                                    <flux:badge :color="$item->tieneSancion ? 'zinc' : 'sky'">
                                        {{ $item->placa }}
                                    </flux:badge>
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2">
                                    {{ $item->nombre_completo }}
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2">
                                    {{ $item->conductor ? $item->conductor : $item->nombre_completo }}
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2">
                                    {{ $item->marca }}
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2">
                                    {{ $item->modelo }}
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2 text-center">
                                    <flux:badge :color="$item->tieneSancion ? 'zinc' : 'sky'">
                                        @if ($item->tieneSancion)
                                            <flux:tooltip content="{{ $item->sancion->nombre }}" position="top">
                                                <span>Con sanción</span>
                                            </flux:tooltip>
                                        @else
                                            Sin sanción
                                        @endif
                                    </flux:badge>
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2 text-center">
                                    <flux:modal.trigger name="modal-estado-{{ $item->id }}">
                                        <flux:badge
                                            as="button"
                                            :icon="$item->estado ? 'check-circle' : 'x-circle'"
                                            :color="$item->estado ? 'green' : 'red'"
                                            class="cursor-pointer transition duration-500 ease-in-out"
                                        >
                                            {{ $item->estado ? 'Activo' : 'Inactivo' }}
                                        </flux:badge>
                                    </flux:modal.trigger>
                                    <!-- Modal cambiar estado -->
                                    <flux:modal
                                        name="modal-estado-{{ $item->id }}"
                                        class="w-full !p-0 !rounded-2xl text-left"
                                    >
                                        <x-card>
                                            <x-card.body class="space-y-6">
                                                <div>
                                                    <flux:heading size="lg">
                                                        Estado del registro
                                                    </flux:heading>

                                                    <flux:subheading>
                                                        <p>
                                                            ¿Está seguro de que desea cambiar el estado del vehículo con placa Nº "{{ $item->placa }}"?
                                                        </p>
                                                    </flux:subheading>
                                                </div>

                                                <div class="flex gap-2">
                                                    <flux:spacer />

                                                    <flux:modal.close>
                                                        <flux:button variant="ghost">Cancelar</flux:button>
                                                    </flux:modal.close>

                                                    <flux:button variant="primary" class="cursor-pointer" wire:click="cambiarEstado({{ $item->id }})">
                                                        Cambiar estado
                                                    </flux:button>
                                                </div>
                                            </x-card.body>
                                        </x-card>
                                    </flux:modal>
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2 text-center">
                                    {{ $item->created_at->format('H:i a d/m/Y') }}
                                </td>
                                <td class="border-l border-zinc-200 dark:border-zinc-700 p-2">
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
                                </td>
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
                    wire:target="buscar, gotoPage, nextPage, previousPage"
                ></div>
                <div
                    class="flex justify-center items-center absolute inset-0 bd-white dark:bd-zinc-800 opacity-50"
                    wire:loading.flex
                    wire:target="buscar, gotoPage, nextPage, previousPage"
                >
                    <flux:icon.loading class="size-8" />
                </div>
            </x-card.body>
        </x-card>

        @if ($this->vehiculos->hasPages())
            <div class="flex justify-center">
                {{ $this->vehiculos->links() }}
            </div>
        @endif
    </div>

    <!-- Modal crear y editar vehículo -->
    <flux:modal
        name="modal-vehiculo"
        class="w-full !p-0 !rounded-2xl min-w-sm max-w-2xl"
    >
        <x-card>
            <x-card.body>
                <div class="space-y-5">
                    <div>
                        <flux:heading size="lg">
                            {{ $modalEditar ? 'Editar vehículo' : 'Registrar vehículo' }}

                        </flux:heading>
                        <flux:text class="mt-2" x-show="!$wire.modalEditar" x-cloak>
                            Completa los campos necesarios para registrar un nuevo vehículo. Si ya tienes un registro, puedes editarlo aquí.
                        </flux:text>
                    </div>

                    <div class="space-y-4">
                        <flux:callout color="sky" icon="information-circle" heading="Asegúrate de ingresar el número de placa correctamente." />

                        <flux:field>
                            <flux:label>
                                Número de placa <span class="text-red-500 ml-2">*</span>
                            </flux:label>
                            <flux:input
                                oninput="this.value = this.value.toUpperCase()"
                                wire:model.live="placa"
                                placeholder="Ingrese el número de placa... Ejemplo: UN1234"
                            />
                            <flux:error name="placa" />
                        </flux:field>
                        <div class="grid grid-cols-2 gap-4">
                            <flux:field>
                                <flux:label>
                                    Apellido del conductor <span class="text-red-500 ml-2">*</span>
                                </flux:label>
                                <flux:input
                                    oninput="this.value = this.value.toUpperCase()"
                                    wire:model.live="apellido"
                                    placeholder="Ingrese el apellido del conductor..."
                                />
                                <flux:error name="apellido" />
                            </flux:field>
                            <flux:field>
                                <flux:label>
                                    Nombre del conductor <span class="text-red-500 ml-2">*</span>
                                </flux:label>
                                <flux:input
                                    oninput="this.value = this.value.toUpperCase()"
                                    wire:model.live="nombre"
                                    placeholder="Ingrese el nombre del conductor..."
                                />
                                <flux:error name="nombre" />
                            </flux:field>
                            <flux:field>
                                <flux:label>
                                    Marca del vehículo <span class="text-red-500 ml-2">*</span>
                                </flux:label>
                                <flux:input
                                    oninput="this.value = this.value.toUpperCase()"
                                    wire:model.live="marca"
                                    placeholder="Ingrese la marca del vehículo..."
                                />
                                <flux:error name="marca" />
                            </flux:field>
                            <flux:field>
                                <flux:label>
                                    Modelo del vehículo <span class="text-red-500 ml-2">*</span>
                                </flux:label>
                                <flux:input
                                    oninput="this.value = this.value.toUpperCase()"
                                    wire:model.live="modelo"
                                    placeholder="Ingrese el modelo del vehículo..."
                                />
                                <flux:error name="modelo" />
                            </flux:field>
                        </div>
                        <flux:field variant="inline">
                            <flux:checkbox wire:model.live="tieneSancion" />
                            <flux:label>¿El vehículo tiene sanciones?</flux:label>
                            <flux:error name="tieneSancion" />
                        </flux:field>
                        <flux:field x-show="$wire.tieneSancion" x-cloak wire:transition>
                            <flux:label>
                                Sanciones @if ($tieneSancion) <span class="text-red-500 ml-2">*</span> @endif
                            </flux:label>
                            <flux:select wire:model.live="sancion">
                                <flux:select.option value="">Seleccione una sanción...</flux:select.option>
                                @foreach($this->sanciones as $item)
                                    <flux:select.option value="{{ $item->id }}">{{ $item->nombre }}</flux:select.option>
                                @endforeach
                            </flux:select>
                            <flux:error name="sancion" />
                        </flux:field>
                        <flux:field variant="inline">
                            <flux:checkbox wire:model.live="tieneDiferenteConductor" />
                            <flux:label>¿Tiene diferente conductor?</flux:label>
                            <flux:error name="tieneDiferenteConductor" />
                        </flux:field>
                        <flux:field wire:transition x-show="$wire.tieneDiferenteConductor" x-cloak>
                            <flux:label>
                                Conductor <span class="text-red-500 ml-2">*</span>
                            </flux:label>
                            <flux:input
                                oninput="this.value = this.value.toUpperCase()"
                                wire:model.live="conductor"
                                placeholder="Ingrese el nombre del conductor..."
                            />
                            <flux:error name="conductor" />
                        </flux:field>
                    </div>

                    <div class="flex gap-2">
                        <flux:spacer />

                        <flux:modal.close>
                            <flux:button variant="ghost" x-on:click="$wire.cerrarModal()">Cancelar</flux:button>
                        </flux:modal.close>

                        <flux:button variant="primary" class="cursor-pointer" wire:click="guardar" icon="save">
                            {{ $modalEditar ? 'Actualizar' : 'Registrar' }}
                        </flux:button>
                    </div>
                </div>
            </x-card.body>
        </x-card>
    </flux:modal>
</div>
