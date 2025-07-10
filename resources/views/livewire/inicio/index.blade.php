<div>
    <x-head title="Inicio" />

    <div class="grid grid-cols-1 gap-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-card class="lg:col-span-2">
                <x-card.body class="flex flex-col lg:flex-row gap-3 lg:gap-4 items-center">
                    <div class="flex aspect-square size-16 items-center justify-center rounded-2xl bg-white dark:bg-zinc-700 border border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 shadow-xs">
                        <img
                            src="{{ asset('assets/files/logo-carro.png') }}"
                            alt="Logo"
                            class="size-10 fill-current text-white dark:text-black"
                        />
                    </div>
                    <div class="flex flex-col text-center lg:text-start">
                        <span class="text-md lg:text-lg font-bold">
                            Bienvenidos al Sistema de Placas
                        </span>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ auth()->user()->email }}
                        </span>
                    </div>
                </x-card.body>
            </x-card>
            <div class="lg:col-span-4 grid grid-cols-2 gap-4" wire:ignore>
                <x-card>
                    <x-card.body>
                        <div id="chart"></div>
                    </x-card.body>
                </x-card>
            </div>
        </div>

        {{-- <x-card class="p-4">
            <flux:button
                @click="$dispatch('toast', { message: 'Esta funcionalidad no esta disponible', type: 'success' })"
            >
                Notificacion success
            </flux:button>
            <flux:button
                @click="$dispatch('toast', { message: 'Esta funcionalidad no esta disponible', type: 'error' })"
            >
                Notificacion error
            </flux:button>
            <flux:button
                @click="$dispatch('toast', { message: 'Esta funcionalidad no esta disponible', type: 'warning' })"
            >
                Notificacion warning
            </flux:button>
            <flux:button
                @click="$dispatch('toast', { message: 'Esta funcionalidad no esta disponible', type: 'info' })"
            >
                Notificacion info
            </flux:button>
            <flux:button
                @click="$dispatch('toast', { message: 'Esta funcionalidad no esta disponible', type: 'neutral' })"
            >
                Notificacion neutral
            </flux:button>
        </x-card> --}}
    </div>
</div>

@script
<script>
    const listado = @json($this->getDataChart);

    const options = {
        series: [{
            name: 'Cantidad',
            data: Object.values(listado)
        }],
            chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                borderRadius: 5,
                borderRadiusApplication: 'end'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: Object.keys(listado),
        },
        yaxis: {
            title: {
                text: 'Cantidad'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " registros"
                }
            }
        },
        theme: {
            palette: 'palette3' // upto palette10
        },
        title: {
            text: 'Cantidad de vehiculos registrados en los ultimos 6 días',
            align: 'center',
            style: {
                fontSize: '16px',
                fontWeight: 'bold',
                color: '#263238'
            }
        },
    };

    const chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
@endscript
